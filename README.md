# Student Management System

EduTrack Student Management Suite is a Laravel-based school management platform for student records, staff roles, courses, grades, dashboards, and attendance tracking. It is built as a practical demo application for administrators and teachers who need a clean way to manage core school operations from one place.

## Project Overview

EduTrack organizes daily school workflows around two main user roles:

- **Administrators** manage the operational data of the school, including students, grades, courses, teacher assignments, and staff accounts.
- **Teachers** access their dashboard and attendance tools for classroom tracking.

The app uses username-based authentication, role-aware navigation, Livewire-powered pages, and seeded demo data so the project can be reviewed quickly after setup.

## Core Features

### Authentication And Roles

- Username and password login.
- User registration for teacher accounts.
- Admin and teacher role separation.
- Automatic dashboard routing based on the authenticated user's role.
- Profile, password, appearance, and account settings.

### Dashboards

- Role-aware dashboard experience.
- Student totals and user totals.
- Teacher count for admin users.
- Present and absent attendance counts.
- Weekly attendance rate.
- Monthly attendance trend visualization.

### Student Management

- Add new students with first name, last name, age, and grade.
- Edit student details.
- Delete student records.
- View students with their assigned grade.

### Grade Management

- Create grades.
- Edit grade names.
- Delete grades.
- Use grades across students, courses, and attendance records.

### Course Management

- Create courses with a unique subject code.
- Add course names and descriptions.
- Assign courses to grades.
- Assign courses to teacher accounts.
- Edit and delete courses.
- Unassigned courses are supported when no teacher is selected.

### Staff Management

- Add staff accounts as administrators or teachers.
- Edit staff names, usernames, roles, and optional passwords.
- Delete staff accounts.
- Protect the current user from deleting their own account.
- Protect the system from deleting or demoting the last administrator.
- Automatically unassign courses when a teacher account is removed.

### Attendance Tracking

- Filter attendance by year, month, and grade.
- Explicit search button loads the attendance grid only after filters are selected.
- Edit attendance for each student and each day of the month.
- Supported statuses: present, absent, sick, and other.
- Mark all students for a specific day with one action.
- Export filtered attendance records to Excel.

## Demo Accounts

Run the database seeders, then use these local demo credentials:

| Role | Username | Password | Notes |
| --- | --- | --- | --- |
| Admin | `admin` | `password` | Full access to admin dashboard, students, grades, courses, staff, attendance, and settings. |
| Teacher | `teacher` | `password` | Teacher dashboard and attendance access. |
| Teacher | `ms-sokha` | `password` | Seeded teacher account assigned to demo courses. |
| Teacher | `mr-dara` | `password` | Seeded teacher account assigned to demo courses. |

These credentials are for local demonstration only.

## Tech Stack

- **PHP 8.2**
- **Laravel 12**
- **Livewire 4**
- **Livewire Volt**
- **Flux UI**
- **Tailwind CSS 4**
- **Vite**
- **SQLite**
- **Pest 3**
- **Laravel Excel**
- **Livewire Toaster**

## Data Model

EduTrack uses a small, focused data model:

| Model | Purpose |
| --- | --- |
| `User` | Stores staff login accounts, usernames, passwords, and roles. |
| `Grade` | Stores grade levels such as Grade 7, Grade 8, and Grade 9. |
| `Student` | Stores student names, ages, and assigned grade. |
| `Subject` | Stores course code, course name, description, grade, and assigned teacher. |
| `Attendance` | Stores daily attendance records by student, grade, date, status, and reason. |

## Access Map

| Area | Route | Access |
| --- | --- | --- |
| Home | `/` | Public |
| Login | `/login` | Guest |
| Teacher Dashboard | `/dashboard` | Teacher |
| Admin Dashboard | `/admin/dashboard` | Admin |
| Students | `/student-list` | Admin |
| Grades | `/grade/list` | Admin |
| Courses | `/courses` | Admin |
| Staff | `/staff` | Admin |
| Attendance | `/attendance` | Authenticated users |
| Settings | `/settings/profile` | Authenticated users |

## Local Setup

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Create the SQLite database file if it does not already exist:

```bash
touch database/database.sqlite
```

On Windows PowerShell, use:

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

Run migrations and seed the demo data:

```bash
php artisan migrate --seed
```

Start the full local development environment:

```bash
composer run dev
```

This starts the Laravel server, queue listener, and Vite development server together.

## Demo Walkthrough

1. Open the application in your browser.
2. Log in with the `admin` demo account.
3. Review the admin dashboard statistics.
4. Open Students and review, create, edit, or delete student records.
5. Open Grades and manage grade levels.
6. Open Courses and assign subjects to grades and teachers.
7. Open Staff and create or manage administrator and teacher accounts.
8. Open Attendance, choose a year, month, and grade, then search.
9. Update individual attendance statuses or mark all students for a day.
10. Export the filtered attendance records to Excel.
11. Log out and log in as `teacher` to review the teacher-facing workflow.

## Project Structure

| Path | Description |
| --- | --- |
| `app/Livewire` | Livewire components for dashboards, admin tools, teacher tools, and settings. |
| `app/Models` | Eloquent models for users, grades, students, subjects, and attendance. |
| `app/Http/Middleware` | Role-based middleware for admin and teacher access. |
| `app/Exports` | Excel export logic for attendance records. |
| `resources/views` | Blade and Livewire views, layouts, auth screens, and Flux UI templates. |
| `routes/web.php` | Main web routes for dashboards, management pages, attendance, and settings. |
| `routes/auth.php` | Authentication routes for login, registration, confirmation, and logout. |
| `database/migrations` | Database schema definitions. |
| `database/seeders` | Demo data for users, grades, students, subjects, and attendance. |
| `tests/Feature` | Feature tests for auth, dashboards, settings, students, courses, staff, and attendance. |

## Testing

Run the application test suite with:

```bash
php artisan test --compact
```

The project uses Pest for feature and unit tests. Existing coverage includes authentication behavior, dashboard rendering, student management, course management, staff safeguards, settings pages, and attendance grid behavior.

## Notes For Reviewers

- The project uses SQLite by default for quick local setup.
- Seeded attendance data is generated for the current month on weekdays.
- Passwords are hashed automatically by the `User` model.
- Email verification and password reset flows are intentionally absent because the app uses username-only authentication.
- Demo credentials are intended for local development and should be changed before any production-style deployment.
