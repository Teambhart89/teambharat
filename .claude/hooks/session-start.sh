#!/bin/bash
set -euo pipefail

if [ "${CLAUDE_CODE_REMOTE:-}" != "true" ]; then
  exit 0
fi

pip install -r "$CLAUDE_PROJECT_DIR/requirements.txt"

# OSINT tools — best-effort; detective.py pre-flight check will report if missing
pip install holehe || echo "Warning: holehe install failed — install manually"
pip install sherlock-project || echo "Warning: sherlock-project install failed — install manually"
