# Modern Design System - Quick Reference

**Status**: ✅ Configuration Created - NOT YET APPLIED

---

## 🎨 Color Tokens

### CSS Variables Usage
```css
/* In CSS/SCSS */
background: hsl(var(--modern-primary));
color: hsl(var(--modern-primary-foreground));
border: 1px solid hsl(var(--modern-border));
```

### Tailwind Usage (After Merge)
```html
<!-- After merging tailwind extension -->
<div class="bg-modern-primary text-modern-primary-foreground border-modern-border">
```

---

## 📝 Typography Tokens

### Font Families
- `--modern-font-body`: Inter
- `--modern-font-heading`: Inter
- `--modern-font-mono`: SF Mono, Monaco, etc.

### Font Sizes (CSS Variables)
- `--modern-text-xs`: 0.75rem (12px)
- `--modern-text-sm`: 0.875rem (14px)
- `--modern-text-base`: 1rem (16px)
- `--modern-text-lg`: 1.125rem (18px)
- `--modern-text-xl`: 1.25rem (20px)
- `--modern-text-2xl`: 1.5rem (24px)
- `--modern-text-3xl`: 1.875rem (30px)
- `--modern-text-4xl`: 2.25rem (36px)
- `--modern-text-5xl`: 3rem (48px)

### Font Weights
- `--modern-weight-normal`: 400
- `--modern-weight-medium`: 500
- `--modern-weight-semibold`: 600
- `--modern-weight-bold`: 700

### Line Heights
- `--modern-leading-tight`: 1.25
- `--modern-leading-snug`: 1.375
- `--modern-leading-normal`: 1.5
- `--modern-leading-relaxed`: 1.625

---

## 📏 Spacing Tokens (4px Grid)

- `--modern-spacing-0`: 0
- `--modern-spacing-1`: 0.25rem (4px)
- `--modern-spacing-2`: 0.5rem (8px)
- `--modern-spacing-3`: 0.75rem (12px)
- `--modern-spacing-4`: 1rem (16px)
- `--modern-spacing-5`: 1.25rem (20px)
- `--modern-spacing-6`: 1.5rem (24px)
- `--modern-spacing-8`: 2rem (32px)
- `--modern-spacing-10`: 2.5rem (40px)
- `--modern-spacing-12`: 3rem (48px)
- `--modern-spacing-16`: 4rem (64px)
- `--modern-spacing-20`: 5rem (80px)
- `--modern-spacing-24`: 6rem (96px)

---

## 🔲 Border Radius Tokens

- `--modern-radius-sm`: 0.375rem (6px)
- `--modern-radius-md`: 0.5rem (8px)
- `--modern-radius-lg`: 0.75rem (12px)
- `--modern-radius-xl`: 1rem (16px)
- `--modern-radius-2xl`: 1rem (16px) **Primary**
- `--modern-radius-3xl`: 1.5rem (24px)
- `--modern-radius-full`: 9999px

---

## 🌫️ Shadow Tokens

- `--modern-shadow-xs`: Subtle
- `--modern-shadow-sm`: Small
- `--modern-shadow-md`: Medium
- `--modern-shadow-lg`: Large
- `--modern-shadow-xl`: Extra Large
- `--modern-shadow-2xl`: Maximum

---

## ⏱️ Transition Tokens

- `--modern-transition-base`: 200ms
- `--modern-transition-fast`: 150ms
- `--modern-transition-slow`: 300ms
- `--modern-transition-all`: all with base timing

---

## 🎯 Component Tokens

### Primary Button
```css
--modern-button-primary-bg: linear-gradient(135deg, hsl(210 70% 58%), hsl(280 60% 62%));
--modern-button-primary-foreground: hsl(0 0% 100%);
```

### Card
```css
--modern-card-bg: hsl(var(--modern-background));
--modern-card-border: hsl(var(--modern-border));
--modern-card-shadow: subtle shadow;
```

### Input
```css
--modern-input-bg: hsl(var(--modern-background));
--modern-input-border: hsl(var(--modern-border));
--modern-input-focus-border: hsl(var(--modern-primary));
--modern-input-focus-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
```

---

## 🔄 Dark Mode

All color tokens automatically adapt in dark mode via `.theme-dark` or `:root:has(body.theme-dark)`.

---

## 📚 Files Reference

1. **Design System**: `_modern-design-system.scss`
2. **Tailwind Extension**: `_modern-tailwind-extension.js`
3. **Implementation Guide**: `_modern-design-guide.md`
4. **This Quick Reference**: `_modern-design-tokens.md`

---

**Status**: ✅ Ready for Implementation (NOT YET APPLIED)

