# Markdown to Elementor Layouts

A WordPress plugin that converts Markdown files with custom layout syntax into Elementor-compatible JSON layouts. Ideal for developers or content creators who prefer writing in Markdown but want visually structured Elementor pages.

---

## ✨ Features

* Write page layouts in Markdown using simple custom syntax
* Supports:

  * Sections
  * Columns (multi-column layout)
  * Headings
  * Images
* Converts Markdown to Elementor-compatible JSON
* Easily import layouts into Elementor
* Unit-tested with sample markdown files

---

## ✍️ Markdown Syntax

Use custom `:::` blocks to define layout:

```markdown
::: section
::: row

::: column
# Welcome to My Page
:::

::: column
![My Image](https://example.com/image.jpg)
:::

:::
:::
```

---

## 🚀 Installation

1. Upload `md2elementor/` to your `/wp-content/plugins/` directory.
2. Activate the plugin via the WordPress admin.
3. Use the admin page (if implemented) to upload/paste Markdown and generate Elementor JSON.

---

## 🔪 Testing

To run unit tests:

1. Install the [WordPress Unit Test environment](https://developer.wordpress.org/plugins/wordpress-org/plugin-unit-tests/).
2. Run:

```bash
phpunit tests/test-converter.php
```

---

## 📜 License

MIT License. Free to use and modify.

---

## 🙋‍♀️ Future Features (Planned)

* Support for additional widgets (buttons, text editors, videos)
* Visual preview in admin panel
* JSON file export
* Integration with Elementor's importer
