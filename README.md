# 📝 To-Do App — Laravel 11

A clean, responsive To-Do List web application built with **Laravel 11**, featuring task management with due dates, times, priority levels, completion tracking, and a rich-text (HTML) note editor.

Built as part of a Development Internship training exercise to gain hands-on experience with the latest Laravel release.

---

## ✨ Features

- ✅ **Full CRUD** — Create, view, edit, and delete tasks
- 📅 **Date & Time** — Each task has a due date and time
- 📝 **Rich Text Notes** — HTML-friendly note editor powered by Quill.js (bold, italics, lists, links)
- 🚦 **Priority Levels** — Mark tasks as Low, Medium, or High priority with color-coded badges
- ☑️ **Mark as Complete** — Toggle tasks between pending and completed with a single click
- 🔍 **Search & Filter** — Search tasks by name, and filter by priority or completion status
- 📊 **Dashboard Stats** — At-a-glance counters for total, completed, and high-priority tasks
- 📱 **Fully Responsive** — Works seamlessly on desktop, tablet, and mobile
- 🎨 **Modern UI** — Custom gradient theme, Poppins typography, smooth hover animations

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 11 |
| Language | PHP 8.3+ |
| Database | MySQL |
| Frontend Styling | Bootstrap 5 |
| Rich Text Editor | Quill.js |
| Date/Time Handling | Carbon |
| Local Dev Environment | Laragon |

---

## 🗄️ Database Schema

**`tasks` table**

| Column | Type | Description |
|---|---|---|
| `id` | BIGINT (PK) | Auto-incrementing primary key |
| `task` | VARCHAR(255) | Task title |
| `date` | DATE | Due date |
| `time` | TIME | Due time |
| `note` | LONGTEXT (nullable) | Rich-text (HTML) note |
| `is_completed` | BOOLEAN (default: false) | Completion status |
| `priority` | ENUM('low','medium','high') | Priority level, default: `medium` |
| `created_at` / `updated_at` | TIMESTAMP | Standard Eloquent timestamps |

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js (optional, for asset compilation)

### Installation

1. **Clone the repository**

```bash
   git clone https://github.com/shehanidileka/TODO-APP.git
   cd TODO-APP
```

2. **Install PHP dependencies**

```bash
   composer install
```

   If you hit a Composer security-advisory error during install, run:

```bash
   composer config policy.advisories.block false
   composer install
```

3. **Set up your environment file**

```bash
   cp .env.example .env
   php artisan key:generate
```

4. **Configure your database** in `.env`

```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_app
   DB_USERNAME=root
   DB_PASSWORD=
```

5. **Create the database** (e.g. via phpMyAdmin or the MySQL CLI), then run migrations:

```bash
   php artisan migrate
```

6. **Serve the application**

```bash
   php artisan serve
```

7. Visit **http://127.0.0.1:8000/tasks** in your browser 🎉

---

## 🗂️ Project Structure