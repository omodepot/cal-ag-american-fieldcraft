# Rollback

Git rollback restores **theme code only**. If the problem involves content,
settings, plugins, media or the database, restore those from DreamHost / the
WordPress backup system ([BACKUPS.md](BACKUPS.md)). Git cannot do that.

## Production: roll back to the previous release

1. Find the previous good version under GitHub → **Releases** (e.g. `v1.0.0` if `v1.1.0` is bad).
2. Download its `cal-ag-fieldcraft-vX.Y.Z.zip` and verify against `SHA256SUMS.txt`:
   `sha256sum -c SHA256SUMS.txt`
3. Install it:
   - **WP Admin:** Appearance → Themes → Add New → Upload Theme → choose the zip → *Replace active with uploaded*; or
   - **SFTP/SSH:** rename the live folder to
     `cal-ag-fieldcraft.broken-YYYYMMDD`, upload and unzip the previous release into
     `wp-content/themes/cal-ag-fieldcraft/`.
4. Clear any caches (DreamHost/plugin cache, CDN if used) and smoke-test.
5. If the release also changed content/settings, restore the pre-release
   database backup taken before installing (production releases always take one first).
6. Record the rollback in the bad release's notes on GitHub.

## Fix forward in Git

Then make `main` match what is live:

```bash
git checkout -b fix/revert-v1.1.0 main
git revert <merge-commit-of-bad-release>   # creates new commits; never rewrite main
# open PR → staging (verify) → main, then tag the next PATCH, e.g. v1.1.1
```

Do not delete or move the bad tag. Releases are a permanent record.

## Staging rollback

Each staging deploy archives the previous theme on the server first.

**Option A — redeploy a known-good commit:** revert the bad commit on
`staging` (`git revert <sha>` → push). The workflow redeploys automatically.

**Option B — restore the server archive (fastest):**
```bash
ssh <user>@<dreamhost-host>
ls -1t ~/theme-backups/staging/          # newest first; DEPLOY_LOG.txt lists SHAs
cd /home/<user>/staging.cal-ag.com/wp-content/themes
mv cal-ag-fieldcraft cal-ag-fieldcraft.broken-$(date +%Y%m%d%H%M)
tar -xzf ~/theme-backups/staging/cal-ag-fieldcraft-<timestamp>-pre-<sha>.tar.gz
```
Then revert the bad commit on `staging` so the next deploy doesn't reintroduce it.
