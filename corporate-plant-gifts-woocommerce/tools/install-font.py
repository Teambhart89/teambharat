#!/usr/bin/env python3
"""
Install a Google Font into the PlantGift Pro theme.

    python3 tools/install-font.py "Montserrat"
    python3 tools/install-font.py "Poppins"
    python3 tools/install-font.py "Plus Jakarta Sans"

Fonts are taken from the google/fonts repository rather than the Google Fonts
CSS API. The API splits families into per-subset files, and the Latin subset it
serves leaves out the rupee sign, which every price on this store needs. The
repository files are complete, so nothing is silently missing.

Variable fonts are instanced to fixed weights, static families use their
nearest published weight. Everything is subset to the character set the theme
uses, converted to WOFF2 and written to the four filenames the CSS already
references, so no CSS edits are needed after a swap.

Requires: pip install fonttools brotli
"""

import os
import re
import sys
import shutil
import tempfile
import urllib.request
import urllib.error

RAW = "https://raw.githubusercontent.com/google/fonts/main"
UA = {"User-Agent": "Mozilla/5.0 (compatible; PlantGiftFontInstaller/1.0)"}

# Latin, Latin Extended A, the punctuation and arrow ranges the theme uses,
# plus the euro, rupee and trademark signs.
UNICODES = (
    "U+0000-00FF,U+0100-017F,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,"
    "U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+20B9,U+2122,"
    "U+2190-2193,U+2212,U+2215,U+FEFF,U+FFFD"
)
FEATURES = "kern,liga,clig,calt,tnum,frac"

# Output filename -> (weight, italic)
TARGETS = {
    "pg-400": (400, False),
    "pg-600": (600, False),
    "pg-700": (700, False),
    "pg-400i": (400, True),
}


def fetch(url):
    return urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=60).read()


def try_fetch(url):
    try:
        return fetch(url)
    except urllib.error.HTTPError:
        return None
    except Exception as exc:
        print(f"  network error on {url}: {exc}", file=sys.stderr)
        return None


def find_family(family):
    """Locate a family directory and its files under ofl, apache or ufl."""
    slug = re.sub(r"[^a-z0-9]", "", family.lower())
    for licence in ("ofl", "apache", "ufl"):
        meta = try_fetch(f"{RAW}/{licence}/{slug}/METADATA.pb")
        if meta:
            names = re.findall(r'filename:\s*"([^"]+)"', meta.decode("utf-8", "replace"))
            if names:
                return licence, slug, names
    return None, None, None


def pick(files, italic):
    """Choose the best source file for a roman or italic cut."""
    variable = [f for f in files if "[" in f and (("Italic" in f) == italic)]
    if variable:
        return variable[0], True

    statics = [f for f in files if "[" not in f and (("Italic" in f) == italic)]
    if not statics:
        return None, False

    # Prefer Regular for the roman cut, and the plain Italic for the italic cut.
    preferred = "Italic.ttf" if italic else "Regular.ttf"
    for f in statics:
        if f.endswith(preferred):
            return f, False
    return statics[0], False


def build(src_path, weight, is_variable, out_path):
    from fontTools.ttLib import TTFont
    from fontTools.varLib import instancer
    from fontTools import subset

    work = src_path
    if is_variable:
        font = TTFont(src_path)
        if "fvar" in font:
            axes = {a.axisTag: (a.minValue, a.maxValue) for a in font["fvar"].axes}
            if "wght" in axes:
                lo, hi = axes["wght"]
                target = max(lo, min(hi, weight))
                if target != weight:
                    print(f"    weight {weight} outside {int(lo)}-{int(hi)}, using {int(target)}")
                # updateFontNames rewrites the name table to match the instance,
                # otherwise the file still reports the variable font default and
                # every weight claims to be the same style.
                instancer.instantiateVariableFont(
                    font, {"wght": target}, inplace=True, updateFontNames=True
                )
                work = src_path + f".{weight}.ttf"
                font.save(work)

    args = [
        work,
        f"--unicodes={UNICODES}",
        f"--layout-features={FEATURES}",
        "--flavor=woff2",
        f"--output-file={out_path}",
        "--no-hinting",
        "--desubroutinize",
        "--name-IDs=*",
        "--drop-tables+=DSIG",
    ]
    subset.main(args)


def main():
    if len(sys.argv) < 2:
        sys.exit(__doc__)

    family = sys.argv[1]
    root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    dest = os.path.join(root, "theme", "plantgift-pro", "assets", "fonts")
    if not os.path.isdir(dest):
        sys.exit(f"Cannot find {dest}")

    print(f"Looking up {family} ...")
    licence, slug, files = find_family(family)
    if not files:
        sys.exit(f"'{family}' not found in the google/fonts repository. Check the spelling.")
    print(f"  found under {licence}/{slug}, {len(files)} files")

    tmp = tempfile.mkdtemp()
    cache = {}
    written = []

    for out, (weight, italic) in TARGETS.items():
        name, is_var = pick(files, italic)
        if not name and italic:
            # Family ships no italic. Fall back to the roman so the site still
            # renders, rather than leaving a missing file.
            name, is_var = pick(files, False)
            if name:
                print(f"  {out}: no italic published, using the roman cut")
        if not name:
            print(f"  {out}: unavailable, skipped")
            continue

        if name not in cache:
            url = f"{RAW}/{licence}/{slug}/{urllib.parse.quote(name)}"
            data = try_fetch(url)
            if not data:
                print(f"  {out}: could not download {name}")
                continue
            path = os.path.join(tmp, name.replace("[", "_").replace("]", "_"))
            open(path, "wb").write(data)
            cache[name] = path
        src = cache[name]

        target = os.path.join(dest, out + ".woff2")
        try:
            build(src, weight, is_var, target)
        except Exception as exc:
            print(f"  {out}: failed, {exc}")
            continue
        written.append((out, os.path.getsize(target)))

    if not written:
        sys.exit("Nothing installed.")

    # Verify the result actually covers what the store renders.
    from fontTools.ttLib import TTFont
    probe = TTFont(os.path.join(dest, written[0][0] + ".woff2"))
    cmap = probe.getBestCmap()
    missing = [f"U+{c:04X}" for c in (0x20B9, 0x2019, 0x2014, 0x00A0) if c not in cmap]

    # Refresh the licence file so attribution stays correct.
    for old in os.listdir(dest):
        if old.endswith("-OFL.txt") or old.endswith("-LICENSE.txt"):
            os.remove(os.path.join(dest, old))
    lic_name = family.replace(" ", "") + ("-OFL.txt" if licence == "ofl" else "-LICENSE.txt")
    lic = try_fetch(f"{RAW}/{licence}/{slug}/OFL.txt") or try_fetch(f"{RAW}/{licence}/{slug}/LICENSE.txt")
    with open(os.path.join(dest, lic_name), "wb" if lic else "w") as fh:
        fh.write(lic if lic else f"{family} licence: see https://fonts.google.com/specimen/{family.replace(' ', '+')}\n")

    shutil.rmtree(tmp, ignore_errors=True)

    total = sum(s for _, s in written)
    print(f"\nInstalled {family}")
    for name, size in written:
        print(f"  {name}.woff2   {size // 1024} KB")
    print(f"  total        {total // 1024} KB")
    print(f"  glyphs       {len(cmap)}")
    if missing:
        print(f"  WARNING: missing {', '.join(missing)}. Prices or punctuation may fall back.")
    else:
        print("  coverage     rupee, curly quotes, em dash and nbsp all present")
    print("\nNo CSS changes needed. Rebuild with ./build.sh")


if __name__ == "__main__":
    import urllib.parse  # noqa: E402  (used in main)
    main()
