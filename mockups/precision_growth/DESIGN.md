---
name: Precision & Growth
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#3d4a42'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#6d7a72'
  outline-variant: '#bccac0'
  surface-tint: '#006c4a'
  primary: '#006948'
  on-primary: '#ffffff'
  primary-container: '#00855d'
  on-primary-container: '#f5fff7'
  inverse-primary: '#68dba9'
  secondary: '#4b41e1'
  on-secondary: '#ffffff'
  secondary-container: '#645efb'
  on-secondary-container: '#fffbff'
  tertiary: '#545c72'
  on-tertiary: '#ffffff'
  tertiary-container: '#6c748b'
  on-tertiary-container: '#fefcff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#85f8c4'
  primary-fixed-dim: '#68dba9'
  on-primary-fixed: '#002114'
  on-primary-fixed-variant: '#005137'
  secondary-fixed: '#e2dfff'
  secondary-fixed-dim: '#c3c0ff'
  on-secondary-fixed: '#0f0069'
  on-secondary-fixed-variant: '#3323cc'
  tertiary-fixed: '#dae2fd'
  tertiary-fixed-dim: '#bec6e0'
  on-tertiary-fixed: '#131b2e'
  on-tertiary-fixed-variant: '#3f465c'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 14px
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  2xl: 48px
  3xl: 64px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
---

## Brand & Style
The design system is engineered for modern B2B and B2C SaaS platforms that prioritize clarity, professional authority, and user efficiency. The brand personality is rooted in "Expertise" and "Growth," manifesting through a minimalist geometric aesthetic that avoids unnecessary decoration in favor of functional precision.

The design style is **Minimalist-Modern**. It leverages heavy whitespace to reduce cognitive load in data-dense environments while utilizing a high-contrast color palette to guide user attention. The interface evokes a sense of reliability and technical excellence, ensuring that complex workflows feel manageable and sophisticated.

## Colors
The palette is built on a foundation of **Slate** neutrals to provide a stable, professional backdrop. 
- **Primary (Emerald 600):** Reserved for the strongest "Growth" actions—primary buttons, progress indicators, and success states.
- **Secondary (Indigo 600):** Used for "Expertise" accents—secondary navigation elements, selection states, and interactive icons.
- **Neutral (Slate):** `Slate-50` is the primary canvas color, while `Slate-900` provides high-contrast legibility for typography. 
- **Borders:** `Slate-200` is the standard for structural definition, ensuring UI boundaries are visible but unobtrusive.

## Typography
This design system utilizes **Inter** exclusively to maintain a systematic, utilitarian aesthetic that excels in readability. 
- **Headlines:** Use SemiBold (600) or Bold (700) with slight negative letter spacing to create a compact, authoritative look.
- **Body:** Standardized on a 16px base for accessibility. 
- **Labels:** Use Medium or SemiBold weights to differentiate meta-data and UI controls from narrative text.
- **Hierarchy:** Maintain strict vertical rhythm by adhering to the defined line heights, ensuring data-heavy dashboards remain legible.

## Layout & Spacing
The layout follows a **Fluid Grid** model with a 12-column structure for desktop and a 4-column structure for mobile. 
- **Dashboards:** Utilize a high-density spacing model for data tables and sidebars, typically using `md` (16px) for internal padding.
- **Content Pages:** Increase whitespace using `lg` (24px) and `xl` (32px) increments to improve focus.
- **Breakpoints:**
  - **Desktop:** 1280px+ (Gutter: 24px)
  - **Tablet:** 768px - 1279px (Gutter: 20px)
  - **Mobile:** <767px (Margin: 16px)

## Elevation & Depth
Visual hierarchy is established using **Tonal Layers** combined with **Ambient Shadows**.
- **Surface Level (Base):** `Slate-50` background.
- **Container Level (Cards/Modals):** Pure white `#FFFFFF` surfaces with a `Slate-200` border and `shadow-sm`.
- **Shadows:** Use a soft, low-opacity neutral shadow (`rgba(15, 23, 42, 0.05)`) with a small blur radius to suggest lift without creating visual clutter.
- **Interactions:** On hover, cards should transition to a slightly deeper shadow or a thin `Indigo-600` focus ring.

## Shapes
The design system employs a **Rounded** shape language to soften the industrial feel of the Slate palette. 
- **Standard UI Elements:** Buttons, inputs, and chips use a `0.5rem` (8px) radius.
- **Structural Containers:** Cards and primary dashboard panels use `rounded-xl` (1.5rem / 24px) to create a distinct, modern "app-like" container feel.
- **Geometric Mark:** The logo and iconography should follow these corner radii to maintain visual cohesion.

## Components
- **Buttons:** 
  - *Primary:* Emerald-600 background, white text, 8px radius.
  - *Secondary:* White background, Slate-200 border, Slate-900 text.
  - *Hover States:* Darken background color by 10%; add 2px Indigo-600 focus ring for accessibility.
- **Input Fields:** White background, 8px radius, Slate-200 border. On focus, the border transitions to Indigo-600.
- **Cards:** White background, 24px (xl) radius, Slate-200 border, shadow-sm. Used for grouping dashboard widgets.
- **Chips/Badges:** 4px radius (soft), low-saturation backgrounds (e.g., Emerald-50 for success) with high-saturation text.
- **Lists:** High-density with 1px Slate-200 dividers. Use `body-sm` for secondary metadata.
- **Progress Indicators:** Use Emerald-600 to represent growth and completion.
- **Data Tables:** Strict 1px Slate-200 horizontal borders, no vertical borders. Header text in `label-sm` (Slate-500, uppercase).