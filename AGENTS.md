# PROJECT STANDARDS & INSTRUCTIONS FOR AI AGENT

## 1. Project Overview & Stack
- **Project Name:** SaaS Service Booking & Consultation Platform
- **Monorepo Architecture:** 
  - `./frontend`: Nuxt 3 (SSR) + Tailwind CSS + Pinia + @lucide/vue
  - `./backend`: Laravel 11 API + Sanctum Auth + PostgreSQL + Redis
  - `./mockups`: Static HTML/CSS files exported from Stitch UI (Reference only)
  - `./docker-compose.yml`: Local development environment orchestration

## 2. Directory Structure Conventions (STRICT)
- **Frontend (Nuxt 3/4 App Directory):**
  - ALL frontend app source code MUST reside inside `frontend/app/`.
  - UI Components: `frontend/app/components/ui/`
  - Pinia Stores: `frontend/app/stores/`
  - Composables: `frontend/app/composables/`
  - Pages & Routes: `frontend/app/pages/`
  - Utils/Helpers: `frontend/app/utils/`
- **Backend (Laravel 11 API Structure):**
  - API Controllers: `backend/app/Http/Controllers/Api/`
  - Eloquent Models: `backend/app/Models/`
  - Form Validation: `backend/app/Http/Requests/`
  - Routes: `backend/routes/api.php`

## 3. Code Quality & Conventions
- **Vue 3 / Nuxt 3:**
  - ALWAYS use `<script setup lang="ts">` (Composition API).
  - Use `cn()` from `~/app/utils/cn` for Tailwind class merging.
  - Rely on Nuxt Auto-Imports for components, composables, and stores. Do NOT add unnecessary manual imports.
- **Laravel 11:**
  - Keep controllers thin! Move heavy business logic into Service classes (`backend/app/Services/`) or Repositories.
  - ALWAYS use Form Requests (`php artisan make:request`) for input validation.
  - Return standardized JSON API responses: `{ "success": true, "data": ..., "message": ... }`.
  - Avoid N+1 database queries (always use Eloquent eager loading `with()`).

## 4. UI & Styling Rules
- Primary Accent Color: **Emerald** (`emerald-600`, `emerald-500`).
- Base Neutral Tones: **Slate** (`slate-900` for dark text, `slate-50` for page background).
- Border Radius: `rounded-xl` for cards, modals, and buttons.
- ALWAYS reference layout, colors, and components from `./mockups` HTML files before building new pages.

## 5. Workflow Execution Instructions
Before executing any coding task:
1. Read this `AGENTS.md` and check `project-tasks.md` for current progress.
2. Check if a relevant mockup exists in `./mockups/` to mirror its UI structure.
3. Perform a self-review for Security, Type Safety (TypeScript), and Clean Architecture before marking the task complete.

## 6. Nuxt 3 & Vue 3 Expert Rules (Frontend Performance & SSR)
- **State & Reactivity:** Prefer `ref` over `reactive`. ALWAYS use `shallowRef` for large arrays or static data lists to prevent heavy Vue reactivity overhead.
- **Data Fetching:** MUST use `useFetch` or `useAsyncData` for API calls to ensure proper Server-Side Rendering (SSR) and prevent hydration mismatches. Do NOT use plain `axios` or `fetch` inside `onMounted` for initial page data.
- **Auto-imports:** Do NOT manually import Vue core APIs (`ref`, `computed`, `watch`) or standard Nuxt composables. Let Nuxt handle auto-imports to keep the code clean.
- **TypeScript:** Enforce strict typing. Always define `interface` or `type` for component Props, Emits, and API JSON responses.

## 7. Laravel 11 Expert Rules (Backend Performance & Clean Architecture)
- **Anti N+1 Queries (STRICT):** STRICTLY FORBID N+1 query problems. ALWAYS use eager loading (`with()`, `load()`, `loadMissing()`) when returning models with relationships.
- **Thin Controllers & Fat Services:** Controllers must ONLY handle HTTP requests (receive input, call service, return response). ALL business logic MUST be extracted into `app/Services/` classes.
- **Strict PHP Typing:** Enable strict types. Every function/method MUST have type-hinted arguments and explicit return types (e.g., `: JsonResponse`, `: void`, `: array`). Leverage PHP 8.2+ features like readonly properties and match expressions.
- **API Response Formatting:** NEVER return raw Eloquent models directly from controllers. ALWAYS use Laravel API Resources (`app/Http/Resources/`) to encapsulate and format JSON responses safely, ensuring hidden fields (like passwords or internal IDs) are never leaked.
- **Error Handling:** Do not use `try-catch` blocks in controllers for standard model not found errors; let Laravel's exception handler deal with `ModelNotFoundException` automatically.

## 8. AI Code Generation Etiquette
- **No Hallucinations:** If you do not know the exact Nuxt 3 or Laravel 11 syntax, output a comment asking the developer to provide documentation rather than guessing.
- **Refactoring:** When modifying existing code, DO NOT remove existing developer comments unless they are obsolete. ONLY output the specific code blocks that need changing, or provide the full file if structural changes are massive.

* Execution Strategy: FRONTEND-FIRST. Build all UI pages using Tailwind/Components based on ./mockups first. Use local Mock Data (Pinia Stores / Nuxt server API) to simulate backend responses.