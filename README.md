# Boulderland — deployment repo

Custom front‑end for **boulderland.ir** (a static site that sits on top of WordPress).
WordPress stays untouched; it only powers `/wp-admin`, the REST API, media, and the
courses registration backend (the `boulderland-courses` plugin).

## Structure (mirrors `public_html`)
```
index.html                     ← HOME (static; header/footer baked in — see note)
components/header.php footer.php ← shared header + footer (PHP includes, used by sub-pages)
assets/css/*  assets/js/*        ← shared global.css/header.css/footer.css + per-page css/js
comps/*.php                      ← competition pages (shared header/footer)
courses/index.php                ← courses + registration (pulls courses from WP REST)
coaches/coach-ali.php            ← coach profile
wp-content/plugins/boulderland-courses/  ← the custom plugin (v1.0.3)
.cpanel.yml  .gitignore
```

## Why the home is `index.html` and sub‑pages are `.php`
The server runs `DirectoryIndex index.html index.php`, and **WordPress owns the root
`index.php`** (its rewrite routes every non‑file request there). So:
- **Sub‑pages** are real `.php` files → they execute PHP and `include` the shared
  `components/header.php` / `footer.php`. One source of truth for the chrome. ✅
- **The home can't be `index.php`** (that would overwrite WordPress's bootstrap and
  break the whole backend). It's served as `index.html`, so its header/footer are
  **inlined** (a copy of the shared components). It still links the same external
  `assets/css` + `assets/js`.
  → **When you change `components/header.php` or `footer.php`, also update the inlined
  copy at the top/bottom of `index.html`** (or regenerate it).

## Deploy (GitHub → cPanel)
1. `git init` here, commit, push to your GitHub repo.
2. cPanel → **Git Version Control** → clone that GitHub repo onto the server.
3. Edit **`.cpanel.yml`**: replace `CPANEL_USER` with your cPanel username.
4. Each change: `git push` → in cPanel click **Update from Remote**, then **Deploy** →
   `.cpanel.yml` copies these paths into `public_html`.

`.cpanel.yml` deploys **only** the custom files + the plugin. It never touches
`wp-config.php`, `.htaccess`, WordPress core, uploads, or other plugins/themes.

## Not deployed on purpose
- `index.php` (WordPress's), `.htaccess`, `wp-config.php`, WP core, `wp-content/uploads`,
  third‑party plugins/themes — all managed by WordPress itself.
