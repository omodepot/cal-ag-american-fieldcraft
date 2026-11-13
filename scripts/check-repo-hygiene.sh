#!/usr/bin/env bash
# Fails if tracked files include credentials, WordPress core, backups or temp files.
# Run locally before committing, and automatically in CI.
#   bash scripts/check-repo-hygiene.sh
set -euo pipefail

cd "$(git rev-parse --show-toplevel)"
fail=0

# 1. Forbidden file names/paths among tracked files
forbidden='(^|/)(\.env(\..+)?|wp-config(-.+)?\.php|\.htpasswd|sftp-config\.json|auth\.json|id_rsa.*|id_ed25519.*)$|\.(pem|key|ppk|p12|pfx|sql|sql\.gz|wpress|bak|log|tmp|swp|zip)$|(^|/)(wp-admin|wp-includes|wp-content/uploads|wp-content/plugins|node_modules|vendor)/|(^|/)(\.DS_Store|Thumbs\.db)$'
allowed='(^|/)(\.env\.example|wp-config-sample\.php)$'

bad_files=$(git ls-files | grep -E "$forbidden" | grep -Ev "$allowed" || true)
if [ -n "$bad_files" ]; then
  echo "ERROR: forbidden files are tracked:"
  echo "$bad_files" | sed 's/^/  - /'
  fail=1
fi

# 2. Credential-looking content in tracked text files
patterns="define\(\s*['\"](DB_PASSWORD|DB_USER|AUTH_KEY|SECURE_AUTH_KEY|LOGGED_IN_KEY|NONCE_KEY)['\"]\s*,\s*['\"][^'\"]+['\"]|-----BEGIN [A-Z ]*PRIVATE KEY-----|(password|passwd|pwd)\s*[:=]\s*['\"][^'\"\$\{]{4,}['\"]"
hits=$(git grep -nIiE "$patterns" -- . ':!scripts/check-repo-hygiene.sh' ':!docs/*' || true)
if [ -n "$hits" ]; then
  echo "ERROR: possible credentials found in tracked files:"
  echo "$hits" | sed 's/^/  /'
  fail=1
fi

if [ "$fail" -ne 0 ]; then
  echo
  echo "Remove these from Git (git rm --cached <file>), rotate any exposed credential, and try again."
  exit 1
fi
echo "Repo hygiene check passed: no credentials, WordPress core, backups or temp files tracked."
