# Elementor Markdown DSL Syntax Guide

This document defines the **Elementor Markdown DSL (Domain-Specific Language)** — a lightweight, human-readable syntax designed for creating Elementor page layouts without relying on a WordPress runtime.

## 🔄 Overview

The DSL enables developers to write structured Elementor layouts using Markdown-like syntax with special container blocks and macros. It maps to Elementor's JSON structure and supports conversion to `.json` or `.zip` templates.

---

## 🔠 Basic Building Blocks

### Sections

```
::: section [options]
... content ...
:::
```

* Represents an Elementor section.
* **Options:** `class`, `background`, `padding`, etc.

### Rows (Inner Sections)

```
::: row
... columns ...
:::
```

### Columns

```
::: column [width=50]
... widgets ...
:::
```

* Width is in percent (`width=33`, `width=100`, etc.)

### Headings

```
# H1 Heading
## H2 Heading
### H3 Heading
```

### Text (Paragraph)

Regular Markdown paragraphs become text widgets:

```
This is a paragraph block of text.
```

### Images

```
![Alt text](https://example.com/image.jpg)
```

### Buttons

```
::: button [text="Click Here"] [link="https://example.com"] [style="primary"]
:::
```

### Videos

```
::: video [url="https://youtube.com/watch?v=abc123"]
:::
```

### Spacers

```
::: spacer [height=40]
:::
```

### Dividers

```
::: divider [style="solid"] [width=50] [alignment="center"]
:::
```

---

## 🔄 Macros

### Purpose

Macros allow you to define reusable widget blocks or layout patterns.

### Define a Macro

```
::: macro hero-block
::: section
::: row
::: column
# Welcome to {{title}}
{{description}}
:::
::: column
![Image]({{image_url}})
:::
:::
:::
:::
```

### Use a Macro

```
::: use hero-block [title="Elementor DSL"] [description="A simple template"] [image_url="https://example.com/banner.jpg"]
:::
```

---

## 🎓 Advanced Attributes

Use attribute syntax for widgets:

```
::: heading [level=2] [text="Section Title"] [alignment="center"]
:::

::: image [url="https://example.com"] [alt="Image"] [width=100] [height=auto]
:::
```

All core Elementor widget attributes can be mapped.

---

## 🌐 Supported Core Widgets

| Widget  | Syntax Type              | Notes                           |
| ------- | ------------------------ | ------------------------------- |
| Section | `::: section`            | With optional settings          |
| Column  | `::: column`             | Width as attribute              |
| Heading | `#`, `##`, `::: heading` | Markdown or block syntax        |
| Text    | Paragraph text           | Converted to Text Editor widget |
| Image   | `![alt](url)`            | Or block with attributes        |
| Button  | `::: button`             | Requires text + link            |
| Video   | `::: video`              | Supports YouTube/Vimeo URLs     |
| Divider | `::: divider`            | Horizontal rule with options    |
| Spacer  | `::: spacer`             | Height in px                    |

---

## ⚡ Example Template

```
::: section
::: row

::: column [width=60]
# Hello from Markdown DSL
This is a simple text paragraph.
:::

::: column [width=40]
![Banner](https://example.com/banner.jpg)
:::

:::
:::
```

---

## 🌍 Future Extensions

* Support for **global styles**, **templates**, and **theme parts**
* Full **widget coverage** (sliders, forms, tabs, etc.)
* **Visual preview** CLI or web renderer

---

## 💡 Notes

* Conversion should be handled by a parser (e.g., in PHP or Node.js)
* Widget compatibility depends on Elementor version
* Output should generate Elementor-compatible JSON structure
