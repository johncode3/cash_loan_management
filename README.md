# Cash Loan Management System

A role-based cash loan management application built with Laravel, Blade, MySQL, and Vite. It supports customer and staff records, loan applications, approval and disbursement, repayment schedules, cashier repayments, and overdue monitoring.

## Current Features

### Authentication and roles

- Session authentication provided by Laravel Breeze.
- Role middleware registered as `role` in `bootstrap/app.php`.
- Supported roles: `admin`, `loan_officer`, `cashier`, and `customer`.
- `customer`, `loan_officer`, and `admin` can submit loan applications.
- `loan_officer` and `admin` can review and approve pending loans.
- `cashier` and `admin` can record repayments.
- `admin` can disburse loans, view overdue schedules, manage employees, and manage users.
- `admin`, `loan_officer`, and `cashier` can manage categories and customers.

### Loan workflow

The implemented loan status values are:

```text
Pending -> Approved -> Disbursed
```

- Customers can apply for loans online.
- Staff can submit walk-in applications for active customers.
- Loan applications store the customer, category, principal amount, interest rate, term, creator, and status.
- Approved loans can be disbursed by an administrator.
- Disbursement runs inside a database transaction and generates the repayment schedule.
- Loan details and installment schedules are available from the loan pages.

### Amortization and repayments

Schedules use a reducing-balance calculation with the monthly payment formula:

$$
\text{Monthly Payment} = P \times \frac{r(1+r)^n}{(1+r)^n - 1}
$$

Where `P` is the principal, `r` is the monthly interest rate as a decimal, and `n` is the number of months. The final installment adjusts the remaining principal after rounding.

- Schedule rows contain installment number, due date, principal due, interest due, total due, status, and paid date.
- Schedule statuses are `Pending`, `Paid`, and `Overdue`.
- Cashiers can record cash or another selected payment method.
- Payments are applied in order to unpaid schedules. Fully covered installments become `Paid`; a partially covered installment remains unpaid.
- Loan and repayment totals are shown on the loan detail page.

### Dashboards and administration

- Staff dashboard metrics include total disbursed, pending applications, overdue schedules, total collected, and customer count.
- Customers see their active loan, next payment, and remaining balance on the dashboard.
- Administrators have an overdue dashboard with search, pagination, and total overdue amount.
- CRUD screens are available for users, employees, customers, and categories.
- A `LoanPolicy` class exists for loan authorization rules, while route access is currently enforced through the `role` middleware.

## Technology Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 13.22, PHP 8.3+ |
| Authentication | Laravel Breeze 2.4 |
| Database | MySQL or MariaDB |
| Views | Blade templates |
| Frontend build | Vite 8, Tailwind CSS 3, Alpine.js |
| Icons | Bootstrap Icons |
| Testing | Pest 4 and PHPUnit |

The current development environment reports PHP 8.5. The Composer requirement is PHP `^8.3`.

## Database Structure

The application includes these main tables:

- `users`: authenticated accounts and roles.
- `customers`: borrower profiles with unique customer codes.
- `employees`: staff records, departments, positions, salaries, and status.
- `categories`: loan product categories.
- `loans`: customer loans, principal, interest rate, term, status, disbursement date, and creator.
- `loan_schedules`: generated installment breakdowns for each loan.
- `repayments`: payment amount, date, method, receiving user, loan, and schedule.

Relationships:

```text
customers 1 --- many loans
categories 1 --- many loans
loans 1 --- many loan_schedules
loans 1 --- many repayments
users 1 --- many loans (created_by)
users 1 --- many repayments (received_by)
```

## Main Routes

Run `php artisan route:list --except-vendor` to see the complete route table. Main application route names include:

| Area | Route names |
| --- | --- |
| Dashboard | `dashboard`, `dashboard.overdue` |
| Loans | `loans.index`, `loans.apply`, `loans.pending`, `loans.show`, `loans.schedule`, `loans.approve`, `loans.disburse` |
| Repayments | `repayments.create`, `repayments.store` |
| Customers | `customers.*` |
| Categories | `categories.*` |
| Employees | `employees.*` |
| Users | `users.*` |
| Profile | `profile.edit`, `profile.update`, `profile.destroy` |

Application routes are authenticated unless they are part of the Breeze authentication routes.

## Installation

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Configure the environment

Copy `.env.example` to `.env`, configure the database, and generate the application key:

```bash
php artisan key:generate
```

Example MySQL configuration:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cash_loan_management
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Create the database and seed demo data

```bash
php artisan migrate:fresh --seed
php artisan storage:link
```

`DatabaseSeeder` creates demo accounts, categories, customers, employees, and demo loans.

### 4. Build and run the application

```bash
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000` in a browser. During development, `composer run dev` starts the Laravel server, queue listener, and Vite together.

## Demo Accounts

All accounts seeded by `DatabaseSeeder` use the password `password123`.

| Role | Email | Main access |
| --- | --- | --- |
| Admin | `admin@loan.com` | Disbursement, overdue dashboard, employees, users |
| Loan officer | `officer@loan.com` | Applications and pending-loan approval |
| Loan officer | `officer2@loan.com` | Applications and pending-loan approval |
| Cashier | `cashier@loan.com` | Repayment recording |
| Cashier | `cashier2@loan.com` | Repayment recording |
| Customer | `customer@loan.com` | Own dashboard and loan application |

## Scheduled Overdue Check

The `loans:check-overdue` command marks pending installments whose due date has passed as `Overdue`.

Run it manually:

```bash
php artisan loans:check-overdue
```

The command is scheduled daily in `routes/console.php`. To run Laravel's scheduler locally, use:

```bash
php artisan schedule:work
```

## Testing

Run the complete test suite:

```bash
php artisan test
```

Current focused coverage includes:

- `tests/Unit/LoanAmortizationTest.php`: verifies principal totals for six- and twelve-month schedules.
- `tests/Feature/LoanAuthorizationTest.php`: verifies guest redirects, role restrictions, and administrator employee access.
- Laravel Breeze authentication, profile, password, registration, and email verification tests.

## Useful Commands

```bash
php artisan route:list --except-vendor
php artisan about
php artisan loans:check-overdue
php artisan test
npm run build
```
