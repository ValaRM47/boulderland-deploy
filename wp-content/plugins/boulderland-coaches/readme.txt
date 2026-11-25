=== Boulderland Coaches ===
Requires at least: WordPress 6.0
Requires PHP: 7.4
Recommended: Advanced Custom Fields (ACF) — free version is enough

Coach cards for Boulderland: a photo on one side and the coach's info on the other
(نام، تخصص، تحصیلات، زمان‌های حضور). Cards are reorderable by drag‑and‑drop.

== Install ==
1. Zip the `boulderland-coaches` folder → Plugins → Add New → Upload → Activate.
2. Make sure ACF is active (the coach fields appear automatically).

== Add coaches ==
WordPress admin → «مربیان» → «مربی جدید»:
  - Title = نام مربی
  - ACF box «مشخصات مربی»: عکس مربی، تخصص، تحصیلات، زمان‌های حضور.

== Reorder ==
In «مربیان» list, **drag the rows** up/down to set the order (saved automatically).
You can also use the «ترتیب» (Order) field in Page Attributes.

== Show the coaches ==
- Standalone page: `boulderland.ir/coaches/` pulls the coaches from the REST API
  (`/wp-json/blc-coaches/v1/coaches`) and renders the cards.
- Or on any WordPress page, use the shortcode:  [boulderland_coaches]

== Notes ==
- Function/metadata prefixes are `blcc_` so this plugin never clashes with
  Boulderland Courses (`blc_`).
- Uninstalling does not delete your coaches (they stay as a custom post type).
