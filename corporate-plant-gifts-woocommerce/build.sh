#!/usr/bin/env bash
# Rebuild the installable zips after editing the theme or plugin source.
# Usage: ./build.sh
set -euo pipefail
cd "$(dirname "$0")"

echo "Linting PHP..."
fail=0
while IFS= read -r f; do
  php -l "$f" >/dev/null || { php -l "$f"; fail=1; }
done < <(find theme plugin -name '*.php')
[ "$fail" -eq 0 ] || { echo "PHP errors found, stopping."; exit 1; }

echo "Building zips..."
rm -rf dist
mkdir -p dist/corporate-plant-gifts-woocommerce/{theme,plugin,docs,source}
D="$PWD/dist/corporate-plant-gifts-woocommerce"

( cd theme  && zip -rq "$D/theme/plantgift-pro.zip"   plantgift-pro   -x '*.DS_Store' )
( cd plugin && zip -rq "$D/plugin/plantgift-core.zip" plantgift-core -x '*.DS_Store' )

cp -r theme/plantgift-pro   "$D/source/"
cp -r plugin/plantgift-core "$D/source/"
cp docs/*.md docs/*.csv "$D/docs/"
cp README.md "$D/"

( cd dist && zip -rq ../../corporate-plant-gifts-woocommerce.zip corporate-plant-gifts-woocommerce )
rm -rf dist

echo "Done: ../corporate-plant-gifts-woocommerce.zip"
ls -lh ../corporate-plant-gifts-woocommerce.zip
