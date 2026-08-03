# ConsultFlow UI & Architecture Explanation

This document explains the structural choices, performance optimizations, and Tailwind techniques used to build the complete frontend for ConsultFlow, adhering strictly to the `AGENTS.md` guidelines.

## 1. Architecture Overview (Nuxt 3)

We utilized Nuxt 3's modern file-based routing and layout system:
- **`app/layouts/`**: We created two main layouts:
  - `default.vue`: For public-facing pages (`/`, `/checkout`, `/services/[id]`). It includes a sticky top navbar (`<Header />`) and a standard footer.
  - `dashboard.vue`: For authenticated provider pages (`/provider/dashboard`). It introduces a left sidebar (`<aside>`) and a top utility bar to maximize horizontal space for data tables.
- **`app/pages/`**: The Nuxt router automatically maps these to URLs. For example, `checkout.vue` becomes `/checkout` and `provider/dashboard.vue` becomes `/provider/dashboard`. Auth pages (`login.vue`, `register.vue`) set `definePageMeta({ layout: false })` to utilize the full viewport for their split-screen design.

## 2. Component Strategy

- **UI Components (`app/components/ui/`)**: We rely on isolated components like `Button.vue`, `Badge.vue`, and `Card.vue`. These components use the `cn()` utility (a wrapper around `clsx` and `tailwind-merge`) to allow dynamic class merging.
- **Auto-Imports**: Nuxt 3 handles all component imports automatically. We do not write `import Header from '~/components/Header.vue'` in most places, keeping the `<script setup>` blocks clean.

## 3. Performance Hacks (Vue 3 / Nuxt 3)

As dictated by the **Nuxt 3 Expert Rules**, we focused on maximum performance:
- **`shallowRef` for State**: In our Pinia stores (like `booking.ts`), large lists like `services` or `availableDates` use `shallowRef` instead of `ref` or `reactive`. This prevents Vue from deeply walking through complex nested objects to establish reactivity, significantly reducing CPU overhead during render.
- **Icon Rendering Strategy**: Instead of globally registering all `@lucide/vue` icons, we only import the specific icons we need on a per-page basis. This enables excellent tree-shaking by Vite.
- **Vite Polling (Docker HMR Fix)**: To ensure fast Developer Experience (DX) on Windows/Docker without manually restarting the container, we configured `vite.server.watch.usePolling: true` inside `nuxt.config.ts`.

## 4. Tailwind CSS Techniques

To match the precision of the Figma / Stitch UI mockups, we mapped custom design tokens via `tailwind.config.js`:
- **CSS Variables**: Classes like `bg-surface-container-lowest` and `border-outline-variant` pull dynamically from the theme configuration, ensuring dark mode / light mode compatibility down the line.
- **Typography Tokens**: Classes like `font-headline-md text-headline-md` strictly enforce the font family (Inter), font size (24px), line height (32px), and weight (600) defined by the designer.
- **Flexbox & Grid Layouts**: 
  - The `index.vue` page uses `grid-cols-1 lg:grid-cols-2` for a responsive consultant layout. 
  - The Auth screens use `w-full lg:w-1/2` alongside `flex` to create a perfect 50/50 split-screen on desktop while stacking cleanly on mobile.
  - `sticky top-[100px]` is used on the checkout and booking sidebars to keep the order summary visible as the user scrolls down the page.

## 5. State Management & Mock Data

- **Pinia Stores**: The `useBookingStore` simulates backend data fetching. 
- **Simulating SSR**: Once we integrate Laravel, these mock states will be replaced by `useFetch` or `useAsyncData` calls inside `setup()`. This guarantees Server-Side Rendering (SSR) correctly awaits the data before sending HTML to the client, solving SEO and hydration mismatch issues.
