markdown
# 🚀 Dynamic Portfolio CMS

A fully dynamic, single‑page portfolio builder with a powerful admin panel.  
Build your personal portfolio visually — add, remove, and rearrange sections (rows/columns/blocks) on the fly. All content is stored in a flexible EAV system, so you never need to run migrations for new section types.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)
![Filament](https://img.shields.io/badge/Filament-3.x-blue.svg)
![Quasar](https://img.shields.io/badge/Quasar-2.x-1976D2.svg)
![Vue](https://img.shields.io/badge/Vue-3.x-4FC08D.svg)

---

## ✨ Features

- 🧩 **Visual Page Builder** – Drag & drop rows, columns, and content blocks directly in the admin panel.
- 📦 **EAV Content Storage** – All text, images, and structured data are stored as JSON payloads. No schema changes needed for new content types.
- 🎨 **Quasar Frontend** – Responsive, beautiful rendering of your portfolio using Vue 3 + Quasar components.
- 🛠️ **Laravel Filament Admin** – A clean, full‑featured admin panel to manage everything.
- 🌟 **GitHub Projects** – Curate a list of repositories by star; the page fetches live data from the GitHub API.
- ✍️ **Inline Editing** – Create and edit content right inside the page builder modal.
- 📱 **Mobile‑ready** – The frontend is fully responsive.

---

## 🧰 Built With

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11 |
| Admin Panel | Filament 3 |
| Frontend | Quasar (Vue 3) |
| Database | MySQL 8+ |
| API | Laravel REST API |
| Authentication | Laravel Breeze / Jetstream |

---

## 📦 Getting Started

### Prerequisites

Make sure you have the following installed:

- PHP 8.1 or higher
- Composer
- Node.js 18+ and npm / yarn
- MySQL 8+

### Installation

1. **Clone the repository**
   ```bash
   git clone git@github.com:shayanir85/protfolio.git
   cd Protfolio
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   # or
   yarn install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Edit your `.env` file with your database credentials and other settings.

5. **Run migrations & seeders**
   ```bash
   php artisan migrate --seed
   ```
   The seeder will create a default homepage layout with a few example blocks.

6. **Create a symbolic link for storage**
   ```bash
   php artisan storage:link
   ```

7. **Build the Quasar frontend**
   ```bash
   npm run build
   # or
   yarn build
   ```

8. **Serve the application**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

---

## ⚙️ Configuration

### Admin User

Create an admin user for the Filament panel:

```bash
php artisan make:filament-user
```

Follow the prompts to set up your email and password.  
Then visit `/admin` to log in.

---

## 🖱️ How to Use the Page Builder

After logging into the admin panel (`/admin`), navigate to **Page Builder** (the primary resource).

- **Add Rows** – Click “Add Row” at the bottom of the page.
- **Add Columns** – Inside any row, click “Add Column” and choose a width (e.g., 6/12 for half, 4/12 for one‑third).
- **Add Blocks** – Within a column, click “Add Block”, choose a block type, and fill in the content modal.
- **Reorder** – Drag rows or blocks using the handle icons to change their order.
- **Edit / Delete** – Use the icons on each block or row.

The page saves automatically when you hit the **Save** button at the top.

---

## 🚧 Roadmap

- [ ] Multi‑page support (add more pages)
- [ ] Media library for reusable images
- [ ] Version history / revert changes
- [ ] Scheduled publishing
- [ ] Dark mode toggle
- [ ] SEO meta tags per block

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to check the [issues page](../../issues).

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---

## 👤 Author

**shayanIranpour** – [Your Website](https://shayaniranpor.ir) – [@yourhandle](https://twitter.com/yourhandle)

---
