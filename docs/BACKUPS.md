# Backups: database and media are NOT in Git

Git holds the theme's code only. Everything below must be backed up through
**DreamHost** or a **WordPress backup system**, and is never committed:

| Item | Where it lives | Back up with |
|---|---|---|
| Database (pages, posts, menus, settings, users) | DreamHost MySQL | DreamHost Panel → MySQL Databases / phpMyAdmin export, or a backup plugin |
| Media uploads | `wp-content/uploads/` | SFTP/rsync download, DreamHost backups, or a backup plugin |
| Plugins | `wp-content/plugins/` | Backup plugin, or reinstall from known versions |
| `wp-config.php`, salts, DB credentials | Server only | Password manager (not Git, not email) |
| WordPress core | Server | Reinstallable; note the version |

## Minimum policy

- **Before every production theme release:** full backup (database + `wp-content/uploads/`).
  Note the backup name/time in the GitHub Release notes.
- **Ongoing:** an automatic schedule (e.g. daily DB, weekly files) via a
  WordPress backup plugin (UpdraftPlus, BlogVault, Jetpack VaultPress Backup, or
  similar) sending copies **off the DreamHost server** (S3, Google Drive, Dropbox).
  Don't rely on DreamHost's own backups alone.
- **Staging** can be refreshed from production, but never push a staging
  database over production without a fresh production backup.
- **Test a restore** at least once (e.g. restore production into staging) so
  the process is known to work before it's needed.

## Never in this repository

`.sql` dumps, `.wpress`/plugin archives, `uploads/`, `wp-config.php`, `.env`
files, or any password/key. `.gitignore` and `scripts/check-repo-hygiene.sh`
block these, and CI fails if one slips through.
