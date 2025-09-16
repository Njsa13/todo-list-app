# Todo List Application - Laravel 5.1

A simple Todo List application built with **Laravel 5.1**.  
This project allows users to manage their daily tasks by adding, editing, marking as completed, and deleting tasks.  
It is designed as a learning project for understanding Laravel 5.1 fundamentals.

---

## Requirements

Before running the project, make sure your environment meets the following requirements:

- PHP >= 5.5.9
- Composer
- Database: PostgreSQL
- PHP Extensions: OpenSSL, PDO, Mbstring, Tokenizer

---

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**
   ```bash
   git clone https://github.com/Njsa13/todo-list-app.git
   cd todo-list-app
   ```
2. **Install dependencies using Composer**
   ```bash
   composer install
   ```
3. **Set up environment file**
   ```bash
   cp .env.example .env
   ```
4. **Generate application key**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations**
   ```bash
   php artisan migrate
   ```
6. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at:
http://localhost:8000

## Features

- User authentication (register & login)
- Create new tasks
- Edit existing tasks
- Mark tasks as completed or incomplete
- Delete tasks
- One-to-Many relationship between User and Task (each user has their own tasks)

## Project Structure (Important Directories)

- app/Http/Controllers → Application controllers (e.g., TaskController, AuthController)
- app/Models → Eloquent models (Task, User)
- resources/views → Blade templates for frontend UI
- database/migrations → Migration files for creating database tables
- routes/web.php → Application routes

## License

This project is open-sourced under the [MIT license](LICENSE).
