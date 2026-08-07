#!/usr/bin/env bash
#
# Swap the theme font to any Google Font, in one command.
#
#   ./tools/swap-font.sh "Poppins"
#   ./tools/swap-font.sh "Plus Jakarta Sans"
#   ./tools/swap-font.sh "Figtree"
#
# Downloads the complete family from the google/fonts repository, instances it
# to weights 400, 600 and 700 plus a 400 italic, subsets it to the character
# set this store uses, and writes WOFF2 files over the four the CSS already
# points at. No CSS edits are needed afterwards.
#
# Requires: pip install fonttools brotli
#
set -euo pipefail
cd "$(dirname "$0")/.."

if [ $# -lt 1 ]; then
	echo "Usage: $0 \"Font Family Name\"" >&2
	echo "Example: $0 \"Poppins\"" >&2
	exit 1
fi

python3 tools/install-font.py "$1"

cat <<'NOTE'

Two things worth checking after a swap:

  1. Families set at different widths. If headings wrap awkwardly, adjust
     --pg-step-3 and --pg-step-4 in theme/plantgift-pro/assets/css/main.css.

  2. Geometric faces want negative tracking at large sizes, humanist faces
     usually do not. Tune --pg-tr-display and --pg-tr-head in the same file.

Then rebuild the zips:  ./build.sh
NOTE
