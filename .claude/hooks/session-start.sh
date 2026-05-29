#!/bin/bash
set -euo pipefail

if [ "${CLAUDE_CODE_REMOTE:-}" != "true" ]; then
  exit 0
fi

pip install setuptools --upgrade --break-system-packages --quiet
pip install -r "$CLAUDE_PROJECT_DIR/requirements.txt" --break-system-packages --quiet
pip install holehe sherlock-project --break-system-packages --quiet
