# Water Supply Reporting System

A simple Laravel-based MVP for reporting and tracking water supply issues.

## Requirements

- PHP 8.1+
- Composer
- MySQL 5.7+ or 8.0+
- Laravel 10.x

## Installation

1. **Clone/Download the project**
   ```bash
   cd "Water Supply Reporting System"
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Create the database**
   ```sql
   CREATE DATABASE water_reporting;
   ```

4. **Configure environment**
   Edit `.env` file with your database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3309
   DB_DATABASE=water_reporting
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Start the server**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000`

## Creating Admin User

Run this in tinker:
```bash
php artisan tinker
```

Then:
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => \Illuminate\Support\Facades\Hash::make('password'),
    'is_admin' => true
]);
```

## Features

### User Features
- User registration and login
- Submit water issue reports (Leak, No water, Low pressure, Contaminated water)
- Upload images with reports
- Track report status (Pending, In Progress, Resolved)
- View status history

### Admin Features
- Dashboard with statistics
- View all reports
- Update report status
- Add comments to reports
- View all users

## File Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ReportController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Report.php
│       └── Update.php
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_create_users_table.php
│       ├── 2024_01_01_000002_create_reports_table.php
│       └── 2024_01_01_000003_create_updates_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── reports/
│       │   ├── dashboard.blade.php
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── show-report.blade.php
│           └── users.blade.php
├── routes/
│   └── web.php
└── config/
    ├── database.php
    ├── auth.php
    ├── filesystems.php
    └── session.php
```

## Database Schema

### users
- id, name, email, password, is_admin, timestamps

### reports
- id, user_id, title, description, issue_type, location, latitude, longitude, image, status, timestamps

### updates
- id, report_id, admin_id, status, comment, timestamps

## Tech Stack

- **Backend:** Laravel 10
- **Database:** MySQL
- **Frontend:** Blade + Tailwind CSS
- **File Storage:** Local filesystem

## Security

- CSRF protection
- Password hashing
- Session management
- Admin middleware protection

## License

MIT License
