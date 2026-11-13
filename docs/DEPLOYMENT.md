# Deployment — CAL-AG American Fieldcraft theme

This repository tracks **only** the custom WordPress theme at
`wordpress-theme/cal-ag-fieldcraft/`, plus docs and tooling. WordPress core,
plugins, `wp-content/uploads/`, `wp-config.php` and the database live on
DreamHost and are never stored in Git (see [BACKUPS.md](BACKUPS.md)).

> **The approved design is frozen.** Deployment work must not change the
> theme's HTML, CSS, JS or images. Design changes need explicit client
> approval and their own release.

## Branches

| Branch    | Purpose                                     | Deploys to                          |
|-----------|---------------------------------------------|-------------------------------------|
| `staging` | Integration and client review               | DreamHost **staging** site (automatic) |
| `main`    | Approved production releases only           | Nothing automatically. Production is a manual, approved step |
| `feature/*`, `fix/*` | Individual changes               | Nothing                             |

Flow: `feature/*` → PR into `staging` → review on DreamHost staging →
PR `staging` → `main` → tag `vX.Y.Z` → GitHub Release → manual production install.

Recommended branch protection (GitHub → Settings → Branches):
- `main`: require a pull request with 1 approval, require the **Repo hygiene** check, block force-pushes and deletion.
- `staging`: require the **Repo hygiene** check, block force-pushes.

## One-time setup: DreamHost staging deploy

The workflow `.github/workflows/deploy-staging.yml` does nothing useful until
these are configured. **Credentials go in GitHub Secrets only. Never commit them.**

1. **DreamHost:** create (or reuse) an SFTP/SSH user for the staging site
   (Panel → Websites → Manage → SFTP users, with SSH enabled). Note its server
   hostname (e.g. `iad1-shared-xx-xx.dreamhost.com`).
2. **Deploy key:** on your own machine,
   `ssh-keygen -t ed25519 -C "github-actions-cal-ag-staging" -f cal-ag-staging-deploy -N ""`.
   Append `cal-ag-staging-deploy.pub` to `~/.ssh/authorized_keys` for the
   DreamHost user. Keep the private key out of every repo folder; delete your local copy after step 4.
3. **Host key (pinned):** `ssh-keyscan -t ed25519 <dreamhost-host>` and verify
   the fingerprint against DreamHost's (or via a first manual SSH login).
4. **GitHub:** Settings → Environments → **New environment** `staging`
   (optionally restrict it to the `staging` branch). Add these **environment secrets**:

   | Secret | Value |
   |---|---|
   | `DREAMHOST_SSH_HOST` | DreamHost server hostname |
   | `DREAMHOST_SSH_USER` | SFTP/SSH username |
   | `DREAMHOST_SSH_PRIVATE_KEY` | Contents of `cal-ag-staging-deploy` (private key) |
   | `DREAMHOST_SSH_KNOWN_HOSTS` | The verified `ssh-keyscan` line |
   | `DREAMHOST_STAGING_THEME_PATH` | Absolute path, e.g. `/home/<user>/staging.cal-ag.com/wp-content/themes/cal-ag-fieldcraft` |

The workflow refuses to run if any secret is missing, if the path does not
contain `staging`, does not end in `/wp-content/themes/cal-ag-fieldcraft`,
or points into a `cal-ag.com` / `www.cal-ag.com` directory.

## Deploying to staging

1. Merge a PR into `staging` (or push to it). Changes under
   `wordpress-theme/cal-ag-fieldcraft/` trigger the deploy; you can also run it
   manually from Actions → *Deploy theme to DreamHost staging* → Run workflow.
2. The workflow:
   - runs the hygiene check (no credentials/core/backups tracked),
   - tars the current staging theme to `~/theme-backups/staging/` on the server (keeps last 10),
   - `rsync`s the theme folder only, removing files that no longer exist in Git,
   - appends the commit SHA to `~/theme-backups/staging/DEPLOY_LOG.txt`.
3. In staging WP Admin, confirm **Appearance → Themes** shows *CAL-AG Fieldcraft* as active, then review the pages against the approved design.

## Releasing to production (cal-ag.com)

There is **no automated production deploy**, and none should be added without
the client's sign-off. DNS for `cal-ag.com` is not managed from this repo.

When the client approves staging:

1. Take a fresh database + media backup of production ([BACKUPS.md](BACKUPS.md)).
2. Open a PR `staging` → `main`, get approval, merge.
3. Tag and release from `main` ([RELEASING.md](RELEASING.md)). The release
   workflow attaches `cal-ag-fieldcraft-vX.Y.Z.zip`.
4. Install that zip on production during an agreed window, by WP Admin →
   Appearance → Themes → Add New → Upload (replace current), or by SFTP into
   `wp-content/themes/cal-ag-fieldcraft/` after first archiving the existing folder.
5. Smoke-test: home page, navigation, phone links, images, mobile layout.
6. Record the version and time in the release notes.

If anything is wrong, follow [ROLLBACK.md](ROLLBACK.md).

## Before every commit

```bash
bash scripts/check-repo-hygiene.sh
```

If a credential is ever committed: remove it, **rotate it immediately**
(DreamHost password/SSH key, WordPress salts, DB password), and ask a repo
admin to purge it from history. Deleting the file in a later commit doesn't remove it from history.
