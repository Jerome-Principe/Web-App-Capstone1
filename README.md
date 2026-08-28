# FitDroid Gym Management System

FitDroid is a full-stack gym and fitness-studio management application built for day-to-day operations and member engagement. It gives administrators and front-desk staff a single web portal for memberships, payments, attendance, appointments, inventory, announcements, and reporting, while exposing mobile-focused API endpoints for members to manage profiles, goals, plans, appointments, feedback, and notifications.

The application combines a role-aware Laravel web portal with a member-facing API, backed by a relational database and Blade-based administrative views.

## Key Features

### Membership and member services

- Membership request intake with pending, approved, and declined states.
- Membership type and expiry-date management, including Bronze, Silver, and Gold plans.
- Medical and emergency-contact form capture during membership onboarding.
- Membership payment tracking for Cash and GCash, including reference data and proof-of-payment uploads.
- Membership renewal requests with approval workflows and updated expiry dates.
- Walk-in client registration, editing, archiving, restoration, and date-based reporting.
- Profile updates, password changes, email verification, OTP signup, and password-recovery flows.

### Fitness programming

- Default meal-plan catalog with search and category/type filters.
- Custom meal plans assigned to members, with mobile completion tracking.
- Default workout-program catalog with search and category/type filters.
- Custom workout programs and exercise assignments for individualized training.
- Exercise completion endpoints for mobile progress tracking.
- Instructor management and instructor-to-appointment relationships.
- Member goals and fitness competitions with web and mobile access.

### Operations and administration

- RFID registration and attendance logging with time-in/time-out records.
- Appointment booking, approval, decline, cancellation, proof-of-payment viewing, and archived-record management.
- Equipment and machine inventory with quantities, dates, defect records, soft deletion, and restoration.
- Stock-item and sale-item management for gym retail inventory.
- Announcements with descriptions and optional PDF attachments.
- Web and mobile feedback collection, read/unread handling, archiving, and moderation.
- Expense recording with category/date filters and archived-record management.
- Dashboard metrics for active members, walk-ins, appointments, attendance, inventory, staff, revenue, expenses, birthdays, expiring memberships, and recent activity.
- PDF report generation for memberships, appointments, walk-ins, inventory, defects, sales, and expenses.

## Tech Stack

### Backend

- PHP 8.1+
- Laravel 10
- Laravel Eloquent ORM
- Laravel Breeze authentication scaffolding
- Laravel Sanctum/API token support
- Laravel middleware for authentication, email verification, throttling, CSRF protection, and custom role authorization
- Guzzle HTTP client
- Barryvdh Laravel DOMPDF for generated reports

### Frontend

- Blade templates and Laravel layouts/components
- HTML, CSS, and JavaScript
- Tailwind CSS with `@tailwindcss/forms`
- Alpine.js
- Bootstrap and Font Awesome assets used by the administrative views
- Axios

### Database and persistence

- MySQL (the provided `.env.example` uses `DB_CONNECTION=mysql`)
- Laravel migrations for users, memberships, payments, renewals, medical forms, appointments, instructors, attendance/RFID, fitness plans, inventory, feedback, announcements, notifications, goals, competitions, and expenses
- Eloquent relationships and soft deletes for recoverable operational records
- Laravel sessions, cache, filesystem storage, and queued/failed-job tables

### Build and development tools

- Composer
- npm
- Vite 4 with `laravel-vite-plugin`
- PostCSS and Autoprefixer
- PHPUnit 10
- Laravel Pint
- Laravel Sail (optional containerized development)

## System Architecture & Workflows

FitDroid follows Laravel's MVC structure:

1. **Routes** in `routes/web.php` serve the authenticated browser portal and public landing pages. Resource routes connect operational modules to their controllers. `routes/auth.php` handles login, registration, email verification, OTP verification, and password reset flows.
2. **Controllers** in `app/Http/Controllers` validate requests, coordinate Eloquent models, handle uploads, apply role-specific workflows, and return Blade views or JSON responses.
3. **Models and migrations** define the relational domain. A pending membership is the central member record and links to medical forms, membership payments, renewals, custom meal/workout/exercise records, appointments, and mobile activity. Equipment and machines link to their defect records; stock items link to sales; instructors link to appointments.
4. **Views** in `resources/views` provide the public FitDroid pages, authenticated dashboard, CRUD forms/lists, archived-record screens, settings/profile pages, authentication screens, mobile-facing administration screens, and PDF templates.
5. **Role middleware** limits portal modules: Admins have broad administrative access; Cashiers focus on attendance, walk-ins, inventory, sales, announcements, and expenses; Instructors manage fitness programming, instructors, goals, competitions, and appointments.
6. **Mobile API workflows** under `/api/mobile/*` support account creation/login, OTP and recovery, member profiles, membership requests, medical forms, payments/renewals, appointments, RFID attendance, meal/workout/exercise completion, goals, competitions, feedback, announcements, and notifications. Authenticated endpoints use the configured API guard.
7. **Reporting** uses controller-level filters and Barryvdh DOMPDF to render Blade report templates and download PDF files. Public-disk storage is used for uploaded announcement files, payment proofs, and profile images.

### Typical business workflows

- **New member:** A mobile client submits a membership request and medical form, uploads payment information, and waits in the pending queue. Staff approve or decline the request; approval assigns a start date and calculates expiry based on membership type.
- **Renewal:** An approved member submits a Cash or GCash renewal. Staff review the request and proof of payment; approval updates the membership type and expiry date and records the payment.
- **Training:** Instructors maintain reusable meal plans, workout programs, and exercises, then create member-specific custom plans. Mobile clients retrieve assigned plans and submit completion updates.
- **Attendance:** Staff register an RFID, scan members in the attendance workflow, and review attendance records from the web portal or mobile API.
- **Operations reporting:** Staff manage inventory, defects, sales, expenses, appointments, walk-ins, and memberships, filter records by date where supported, and download PDF reports.

## Installation & Setup Guide

### Requirements

- PHP 8.1 or newer
- Composer
- Node.js and npm
- MySQL
- Git

### 1. Clone the repository

```bash
git clone https://github.com/Jerome-Principe/Web-App-Capstone1.git
cd Web-App-Capstone1
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create and configure the environment file

macOS/Linux:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Update `.env` with the local MySQL database and mail settings. The default database configuration expects:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Create the configured database before migrating.

### 5. Generate the application key and prepare storage

```bash
php artisan key:generate
php artisan storage:link
```

### 6. Create the database schema and optional sample data

```bash
php artisan migrate
php artisan db:seed
```

The project includes `DefaultUserSeeder`, `SampleDataSeeder`, and `NotificationSeeder` through `DatabaseSeeder`. If a clean rebuild is required, use `php artisan migrate:fresh --seed` only in a disposable development database.

### 7. Start the Laravel application

In one terminal:

```bash
php artisan serve
```

The application is available at `http://127.0.0.1:8000` unless Laravel reports a different port.

### 8. Start the Vite development server

In a second terminal:

```bash
npm run dev
```

For a production asset build:

```bash
npm run build
```

Configure SMTP or a local mail catcher such as Mailpit if testing OTP, verification, or recovery emails. Uploaded files and generated links require the storage link from step 5.

## License & Credits

This project is released under the **MIT License**, consistent with the project dependency configuration. See the `license` field in `composer.json` for the declared license.

Built as a developer portfolio/capstone project by **Jerome Principe**.

Core open-source credits:

- Laravel Framework and Laravel Breeze
- Laravel Sanctum
- Barryvdh Laravel DOMPDF and Dompdf
- Vite, Tailwind CSS, Alpine.js, Axios, Bootstrap, and Font Awesome
