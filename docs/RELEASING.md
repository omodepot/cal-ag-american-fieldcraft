# Versioning and releases

Releases use [Semantic Versioning](https://semver.org/) with Git tags `vMAJOR.MINOR.PATCH`
and GitHub Releases.

| Change | Bump | Example |
|---|---|---|
| Bug fix, content correction, no visual change | PATCH | `v1.0.0 → v1.0.1` |
| New template/section, approved visual addition | MINOR | `v1.0.1 → v1.1.0` |
| Redesign or breaking change to templates/settings | MAJOR | `v1.1.0 → v2.0.0` |

The first approved production build is **`v1.0.0`**.

## Cutting a release

Releases are cut **only from `main`**, after the `staging` → `main` PR is approved and merged.

1. On a branch off `staging`, set the version in the theme header
   `wordpress-theme/cal-ag-fieldcraft/style.css`:
   ```css
   /*
   Theme Name: CAL-AG Fieldcraft
   Version: 1.0.0
   */
   ```
   This header comment is metadata only and does not change the design.
   Add an entry to `CHANGELOG.md`. Merge via `staging` → `main`.
2. Tag the merge commit on `main`:
   ```bash
   git checkout main && git pull
   git tag -a v1.0.0 -m "v1.0.0 — first approved production release"
   git push origin v1.0.0
   ```
3. The **Package theme release** workflow checks that the tag is on `main`
   and matches `Version:` in `style.css`, runs the hygiene check, builds
   `cal-ag-fieldcraft-v1.0.0.zip` + `SHA256SUMS.txt`, and publishes a GitHub Release.
4. Edit the release notes: what changed, who approved it, and (after install)
   when it went live on production.

Rules:
- Never move or delete a published tag. If a release is bad, ship a new PATCH (or roll back, see [ROLLBACK.md](ROLLBACK.md)).
- Every production install must come from a GitHub Release zip, never from a working copy.
