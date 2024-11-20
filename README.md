![image](https://github.com/user-attachments/assets/db98d9d8-324c-48ef-ad83-54a059081e05)

<h1 align="center"> Laravel Sanctum API Only </h1>

<p align="center">
<a href="https://github.com/YaraZan/laravel-sanctum-api-only/actions"><img src="https://github.com/YaraZan/laravel-sanctum-api-only/actions/workflows/laravel.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.com/YaraZan/laravel-sanctum-api-only/actions"><img src="https://github.com/YaraZan/laravel-sanctum-api-only/actions/workflows/php.yml/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/yarazan/laravel-sanctum-api-only"><img src="https://img.shields.io/packagist/dt/yarazan/laravel-sanctum-api-only" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/yarazan/laravel-sanctum-api-only"><img src="https://img.shields.io/packagist/v/yarazan/laravel-sanctum-api-only" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/yarazan/laravel-sanctum-api-only"><img src="https://img.shields.io/packagist/l/yarazan/laravel-sanctum-api-only" alt="License"></a>
</p>

### Overview

This Laravel project is an **API-only** application designed for robust authentication and authorization using Laravel Sanctum. It includes seamless support for handling **UUIDs in binary format** across both **MySQL** and **PostgreSQL**, along with essential features like root user management, seeders, and role-based policies.


## Key Features

### 1. **UUID Handling**
- Models requiring UUIDs can use the `HasUuid` trait (`App\Traits\HasUuid`) to automatically handle UUID generation and binary storage (16 bytes).
- Custom validation rule: `BinaryUuidExists` for checking object existence during validation steps.
- Database configuration supports both MySQL and PostgreSQL UUID handling.

### 2. **API Authentication**
- **Sanctum-based authentication** with `/register` and `/login` routes.
- Upon successful authentication, the server responds with a JSON object containing a `['token']` structure.
- Default **custom validation rules** are implemented for both `/register` and `/login` requests.

### 3. **Extended Token Management**
- Includes a modified version of `HasApiTokens` as `HasApiTokensWithLocation` to track **device name** and **location** alongside tokens.

### 4. **Root User Management**
- Pre-configured **root user** with a dedicated role (`root` or `admin`).
- Artisan command `app:generate-root-password` generates a secure root user password and stores it in the `.env` file. 
  - Ensure the `.env` file exists before running the command.
- Default seeders create:
  - `root` role (or custom role based on your `.env` configuration).
  - Root user with credentials stored in the `.env` file.

### 5. **Role Management**
- Includes an implemented policy and controller for the **Role** model.
- Role-based access control is applied using Sanctum's `auth:sanctum` middleware.


## Getting Started

### 1. **Installation**
1. Clone the repository:
   ```bash
   git clone <repository_url>
   ```
2. Navigate to the project directory:
   ```bash
   cd <project_name>
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

### 2. **Database Configuration**
- Configure your database connection in the `.env` file:
  ```env
  DB_CONNECTION=mysql      # or pgsql
  DB_HOST=127.0.0.1
  DB_PORT=3306             # or 5432 for PostgreSQL
  DB_DATABASE=your_db
  DB_USERNAME=your_user
  DB_PASSWORD=your_password
  ```

### 3. **UUID Configuration**
- For MySQL, UUIDs are stored as `BINARY(16)`.
- For PostgreSQL, UUIDs use the native `UUID` type.

---

## Usage

### Root User Setup
1. Generate a root password:
   ```bash
   php artisan app:generate-root-password
   ```
   - This will generate a secure password in the `.env` file.

2. Run seeders to create the root role and root user:
   ```bash
   php artisan db:seed
   ```

### Routes
- Define your API routes in the `routes/api.php` file.
- Protect routes with Sanctum middleware:
   ```php
   Route::middleware('auth:sanctum')->group(function () {
       // Your protected routes here
   });
   ```

### Example Endpoints
#### Registration
```http
POST /register
Content-Type: application/json

{
    "name": "Your Name",
    "email": "your@example.com",
    "password": "securepassword",
    "password_confirmation": "securepassword"
}
```

#### Login
```http
POST /login
Content-Type: application/json

{
    "email": "your@example.com",
    "password": "securepassword"
}
```

### Seeders
- Default seeders are included for `Role` and `User` models.


## Policies and Validation

### Policies
- **Role Policy** is pre-configured for the `Role` model.

### Validation Rules
- `BinaryUuidExists` ensures UUID existence during validation.
- Custom rules for `/register` and `/login` routes ensure robust input validation.


## Contributing
Feel free to fork this repository and submit pull requests. Contributions are always welcome!


## License
This project is open-sourced and licensed under the [MIT License](https://opensource.org/licenses/MIT).
