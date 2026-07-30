# Portfolio CMS - Technical Specification

## Project Overview

A fully dynamic, single-page portfolio website with a self-service admin panel. The system uses a **page-builder approach** where the homepage layout is stored as a JSON tree (rows/columns/blocks), and all content is managed via an **EAV (Entity-Attribute-Value)** system with JSON payloads.

### Core Features

- **Dynamic Page Builder**: Drag-and-drop interface for arranging rows, columns, and content blocks
- **EAV Content Management**: All content (text, images, structured data) stored flexibly
- **GitHub Projects Integration**: Curated list of repos displayed via GitHub API
- **Inline Content Creation**: Create and edit content directly within the page builder
- **Quasar Frontend**: Vue-based rendering of the page layout
- **Filament Admin Panel**: Laravel-powered admin interface with full CRUD

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 10/11 |
| Admin Panel | Filament 3.x |
| Frontend Framework | Quasar.js (Vue 3) |
| Database | MySQL 8+ |
| API Approach | Inertia.js or REST API |
| Authentication | Laravel Breeze/Jetstream |
| File Storage | Laravel Filesystem (Local) |

---

## Database Schema

### 1. `pages`

Stores the homepage layout JSON.

```php
Schema::create('pages', function (Blueprint $table) {
    $table->id();
    $table->string('slug')->unique()->default('home');
    $table->json('layout')->nullable(); // JSON tree with rows/columns/blocks
    $table->timestamps();
});
```

**`layout` JSON Structure:**

```json
{
  "rows": [
    {
      "id": "row_xxx",
      "columns": [
        {
          "id": "col_xxx",
          "width": 6,
          "blocks": [
            {
              "id": "block_xxx",
              "entity_id": 42,
              "type": "about_blurb"
            }
          ]
        }
      ]
    }
  ]
}
```

---

### 2. `eav_entities`

Stores all dynamic content blocks as JSON payloads.

```php
Schema::create('eav_entities', function (Blueprint $table) {
    $table->id();
    $table->string('type'); // e.g., 'about_blurb', 'pricing_tier', 'experience_item'
    $table->json('data'); // All attributes stored as JSON
    $table->timestamps();
});
```

**Example `data` payloads:**

```json
// about_blurb
{
  "title": "About Me",
  "text": "I'm a full-stack developer...",
  "avatar_url": "/uploads/avatar.jpg"
}

// pricing_tier
{
  "plan_name": "Pro",
  "price": "$49/mo",
  "features": ["Feature A", "Feature B", "Feature C"],
  "cta_text": "Get Started",
  "cta_link": "/signup"
}

// experience_item
{
  "company": "Acme Corp",
  "position": "Senior Developer",
  "start_date": "2022-01",
  "end_date": "2024-12",
  "description": "Built scalable APIs...",
  "tech_stack": ["Laravel", "Vue", "AWS"]
}

// skill_set
{
  "skills": [
    { "name": "Laravel", "level": 90 },
    { "name": "Vue.js", "level": 85 }
  ],
  "category": "Backend"
}

// contact_info
{
  "email": "me@example.com",
  "phone": "+1234567890",
  "social_links": {
    "github": "https://github.com/username",
    "linkedin": "https://linkedin.com/in/username"
  }
}
```

---

### 3. `project_picks`

Curated list of GitHub repositories to display.

```php
Schema::create('project_picks', function (Blueprint $table) {
    $table->id();
    $table->string('repo_name'); // e.g., 'laravel/laravel'
    $table->integer('display_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

---

### 4. `users`

Admin authentication (corrected from original migrations).

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password'); // Hashed
    $table->rememberToken();
    $table->string('phone_number')->nullable();
    $table->timestamps();
});
```

---

### Migration Cleanup

The following tables from your original migrations will be **dropped** in favor of the EAV model:
- `paragraph`
- `images`
- `my_skills`

---

## Filament Admin Panel

### Resources Structure

| Resource | Filament Class | Purpose |
|---|---|---|
| **Page Builder** | `PageBuilderResource` | Primary UI for editing homepage layout |
| **Content Entities** | `EavEntityResource` | Browse/manage all EAV entities (backup) |
| **Project Picks** | `ProjectPickResource` | Manage curated GitHub repos |

---

### Page Builder Resource (Main Admin Interface)

#### Page View
A custom Filament page (not a standard resource table) that renders the visual page builder.

**UI Components:**

1. **Toolbar**: Preview toggle, Save button, Publish status
2. **Row Container**: Each row is a card with drag handle, delete button
3. **Column Container**: Within rows, with width selector (3, 4, 6, 8, 12/12)
4. **Block List**: Inside columns, with drag reorder, edit, delete
5. **Add Block Modal**: Choose block type → Open content form modal
6. **Content Form Modal**: Dynamic form based on block type (filament forms)

**Block Types & Their Form Schemas:**

| Type | Fields |
|---|---|
| `about_blurb` | Title (text), Text (textarea), Avatar (file upload) |
| `profile_image` | Image URL (file upload) |
| `skill_set` | Skills (repeater: name text, level number) |
| `experience_item` | Company, Position, Start Date, End Date, Description, Tech Stack (tags) |
| `pricing_tier` | Plan Name, Price, Features (repeater), CTA Text, CTA Link |
| `contact_info` | Email, Phone, Social Links (key-value) |
| `projects` | No content form (uses `project_picks` table) |

**Form to EAV Entity Flow:**

```
User clicks "Add Block" 
→ Selects block type 
→ Modal opens with dynamic form
→ User fills fields, clicks Save
→ Backend creates EAV entity with type + data JSON
→ Entity ID returned
→ Layout JSON updated with block reference
→ Page saved
```

---

### Content Entities Resource (Backup/Management)

A standard Filament resource with:
- Table view: ID, Type, Data preview, Created/Updated
- Actions: Edit, Delete
- Filters: By type
- Search: Within JSON data (using MySQL JSON functions)

---

### Project Picks Resource

Simple resource with:
- Table: Repo name, Active toggle, Display order (drag reorder)
- Actions: Add new repo, Delete, Reorder
- Button: "Sync from GitHub" to validate repository existence
- The actual portfolio fetches fresh data from GitHub API on render (not stored)

---

## Frontend Rendering (Quasar.js)

### Page Load Flow

1. Quasar app loads → Fetches `GET /api/page`
2. API returns: `{ layout: {...}, entities: { 42: {...}, 43: {...} } }`
3. App recursively renders the layout tree:

```vue
<template>
  <div v-for="row in layout.rows" :key="row.id" class="row-container">
    <div v-for="col in row.columns" :key="col.id" :class="`col-${col.width}`">
      <template v-for="block in col.blocks" :key="block.id">
        <component 
          :is="getBlockComponent(block.type)"
          :data="entities[block.entity_id]"
        />
      </template>
    </div>
  </div>
</template>
```

### Block Components (Quasar)

| Block Type | Quasar Component | Description |
|---|---|---|
| `about_blurb` | `AboutBlurb.vue` | Avatar + title + text |
| `profile_image` | `ProfileImage.vue` | Full-width image with optional overlay |
| `skill_set` | `SkillSet.vue` | Skill bars or tag cloud |
| `experience_item` | `ExperienceItem.vue` | Timeline card with company, dates, description |
| `pricing_tier` | `PricingTier.vue` | Card with plan name, price, features, CTA |
| `contact_info` | `ContactInfo.vue` | Email, phone, social icons |
| `projects` | `ProjectsSection.vue` | Grid of GitHub project cards |

---

### Projects Block Logic

The `ProjectsSection` component:
1. Fetches `GET /api/projects` on mount
2. Gets list of repo names from `project_picks` table
3. Calls GitHub API to fetch repo details (name, description, stars, URL, language)
4. Caches in Laravel for 1 hour
5. Renders as grid of cards

**API Endpoint:** `GET /api/projects` returns:

```json
{
  "projects": [
    {
      "name": "laravel/laravel",
      "description": "Laravel framework",
      "stars": 78000,
      "url": "https://github.com/laravel/laravel",
      "language": "PHP"
    }
  ]
}
```

---

## API Endpoints

| Endpoint | Method | Purpose |
|---|---|---|
| `/api/page` | GET | Returns homepage layout + all referenced EAV entities |
| `/api/projects` | GET | Returns list of GitHub projects (with fresh repo data) |
| `/api/admin/page` | PUT | Updates the `pages.layout` JSON |
| `/api/admin/eav-entities` | POST | Creates a new EAV entity |
| `/api/admin/eav-entities/{id}` | PUT | Updates an EAV entity |
| `/api/admin/eav-entities/{id}` | DELETE | Deletes an EAV entity |
| `/api/admin/project-picks` | GET/POST/PUT/DELETE | Standard CRUD for project picks |

---

## Development Roadmap

### Phase 1: Database & Models
- [ ] Create and run all migrations
- [ ] Create Laravel models: `Page`, `EavEntity`, `ProjectPick`
- [ ] Seed with default homepage layout (hero section + about + skills + projects + contact)
- [ ] Set up model factories for testing

### Phase 2: Admin Panel (Filament)
- [ ] Install Filament and configure admin auth
- [ ] Create `PageBuilderResource` custom page (most complex)
- [ ] Implement row/column/block management with Livewire
- [ ] Build dynamic content forms per block type
- [ ] Create `EavEntityResource` for backup management
- [ ] Create `ProjectPickResource` for repo management
- [ ] Add "Sync GitHub" button to validate repos

### Phase 3: API Layer
- [ ] Create `PageController` with GET endpoint
- [ ] Create `ProjectController` with GET endpoint (GitHub API integration)
- [ ] Implement caching for GitHub API calls
- [ ] Secure admin endpoints with middleware

### Phase 4: Frontend (Quasar)
- [ ] Set up Quasar project with Vue 3
- [ ] Build recursive page renderer
- [ ] Create all block components
- [ ] Implement `ProjectsSection` with GitHub API
- [ ] Add responsive breakpoints (mobile/tablet/desktop)
- [ ] Add smooth animations/transitions

### Phase 5: Deployment
- [ ] Set up production environment
- [ ] Configure .env variables (GitHub token for API rate limits)
- [ ] Deploy Laravel + Quasar (separate or integrated)
- [ ] Set up queue for GitHub cache refresh
- [ ] Document admin user guide

---

## Key Design Decisions Summary

| Decision | Chosen Approach |
|---|---|
| Content storage | EAV with JSON payloads |
| Layout storage | JSON tree in `pages` table |
| Content linking | Reference IDs in layout JSON |
| Admin workflow | Inline creation via modals |
| Projects section | GitHub API, curated via `project_picks` |
| Image handling | File upload → URL stored in EAV `data` |
| Frontend framework | Quasar.js (Vue 3) |
| Admin framework | Laravel Filament 3 |
| Page model | Single-page (only homepage) |

---

## Security Considerations

- Admin routes protected by Filament's authentication
- CSRF protection enabled on all POST/PUT/DELETE endpoints
- File uploads validated (mime types, max size)
- GitHub API token stored in `.env` (not exposed to frontend)
- API responses sanitize HTML (or use markdown rendering)
- Rate limiting on public API endpoints

---

## Future Extensibility (Out of Scope for V1)

- Multi-page support (add more pages with different layouts)
- Media library (reusable images with metadata)
- Version history / revert changes
- Scheduled publishing (set future publish date)
- Multi-language support (content translations)
- Analytics integration
- SEO meta tags per block/page
- RSS feed for blog/updates
- Dark mode toggle

---

*This specification is ready for implementation. All decisions have been validated with the project owner.*