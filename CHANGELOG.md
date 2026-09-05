# 📋 Project Development Log: CashLoan Management System
**Framework:** Laravel 11 (Blade Stack) | **Database:** MySQL | **Duration:** 29 Aug 2026 – 05 Sep 2026

---

### =======================================================
### Session 1: Master Data Polish, UI Standardization & Auth
**Date:** 29 August 2026 | **Time:** 10:00 AM – 10:00 PM
### =======================================================

1. **Bug Fixes & Data Integrity:**
   - Fixed customer gender case-sensitivity bug on edit form using `strtolower()`.
   - Streamlined customer table columns (moved detailed address, DOB, and email to show view).
   - Fixed active navigation highlighting bug in sidebar across all resource routes.

2. **UI/UX & Design System:**
   - Unified `form.css`, `index.css`, `show.css`, and `dashboard.css` under the Corporate Slate theme.
   - Added 25 Cambodia Cities/Provinces dropdown for Customers & Employees.
   - Added standardized Department & Role/Position dropdowns for Employees.
   - Implemented search filter in `CategoryController` with clean filter bar UI.

3. **Testing & Seeding:**
   - Created `DummyDataSeeder` with 20 Khmer Customers & 15 Employees for pagination testing.
   - Pushed completed foundation to GitHub at 10:00 PM.

---

### =======================================================
### Session 2: Loan Engine Initiation & Role Permissions
**Date:** 30 August 2026 | **Time:** 08:00 AM – 12:30 PM
### =======================================================

1. **Core Loan Features (Part 2):**
   - Structured `LoanController` methods (`create`, `store`, `pending`, `approve`, `disburse`, `schedule`, `show`).
   - Created `loans/apply.blade.php` form with category dropdown, borrowing amount, rate, and term.
   - Created `loans/pending.blade.php` approval queue with secure POST form buttons.
   - Added null-coalescing operator (`$loan->category->name ?? 'General'`) for category safety.

2. **UX & System Automation:**
   - Implemented automated unique customer code generation (`CUST-dmy-His`).
   - Resolved MySQL 1406 data truncation error by removing dummy placeholder submissions.
   - Expanded role permissions in `web.php` and `LoanPolicy` so `loan_officer` can apply for walk-in branch loans.
   - Added styled flash success and error notification banners on Dashboard redirects.

---

### =======================================================
### Session 3: Admin Disbursement Action & Math Engine
**Date:** 30 August 2026 | **Time:** 2:30 PM – 4:00 PM
### =======================================================

1. **Loan Schedule & Math Engine (Part 3):**
   - Created `loan_schedules` table migration and `LoanSchedule.php` model.
   - Implemented `LoanCalculationService` with the **Reducing Balance Amortization Formula**:
     $$PMT = P \times \frac{r(1+r)^n}{(1+r)^n - 1}$$
   - Implemented `LoanController@disburse` with `DB::transaction()` to update status to `Disbursed` and generate 6 monthly installments.
   - Created `loans/schedule.blade.php` displaying the 6-month repayment table with monthly principal and interest breakdowns.
   - Pushed Part 2 & Part 3 core features to GitHub at 4:00 PM.

---

### =======================================================
### Session 4: Duplicate Protection & Unit Testing
**Date:** 31 August 2026 | **Time:** 1:00 PM – 2:00 PM
### =======================================================

1. **Financial Integrity & Double Payout Protection:**
   - Created `DisburseLoanRequest` Form Request to strictly prevent duplicate cash disbursement for the same loan contract.
   - Created Artisan command `php artisan loans:check-overdue` to automatically flag past-due installments.
   - Implemented `LoanAmortizationTest` Unit Test verifying $\sum \text{principal\_due} == \text{principal\_amount}$ (All tests passed green).

---

### =======================================================
### Session 5: Vector Icons & Dynamic Asset Paths
**Date:** 31 August 2026 | **Time:** 7:00 PM – 9:00 PM
### =======================================================

1. **UI Standardization:**
   - Replaced all text emojis with scalable vector Bootstrap Icons (`bi bi-...`).
   - Fixed broken relative image paths on nested routes using `{{ asset(...) }}` helper.
   - Standardized table action buttons (`View`, `Edit`, `Delete`, `Disburse`, `Schedule`) on a single line with `.table-actions`.

---

### =======================================================
### Session 6: Repayment Engine Initiation
**Date:** 31 August 2026 | **Time:** 11:00 PM – 12:30 AM
### =======================================================

1. **Repayment Module (Part 4):**
   - Created `repayments` table migration and `Repayment.php` model with audit foreign keys (`received_by`).
   - Created `RepaymentController.php` and `loans/repay.blade.php` view.
   - Structured `resources/views/dashboard/` directory for separated dashboard views.

---

### =======================================================
### Session 7: User Management, Overdue Dashboard & Security
**Date:** 01 September 2026 | **Time:** 7:00 PM – 1:00 AM
### =======================================================

1. **Dashboard Refactoring & Overdue Monitoring:**
   - Created `DashboardController.php` with real SQL KPI aggregate queries.
   - Moved main dashboard to `resources/views/dashboard/index.blade.php`.
   - Built `dashboard/overdue.blade.php` for Admin with pagination and days-late tracking.

2. **User Management CRUD:**
   - Created `UserController.php` and views (`users/index`, `create`, `edit`) for Admin role management.
   - Resolved role edit bug by adding `'role'` to `$fillable` in `User.php`.
   - Added self-deletion protection in `UserController@destroy`.
   - Added **Active Loan Deletion Shield** blocking deletion of customers with outstanding active debt.

3. **Customer Onboarding & Auth Redesign:**
   - Smart loan apply form: Auto-locks applicant identity for logged-in customers while showing a dropdown for staff.
   - Upgraded Breeze registration (`RegisteredUserController@store` & `register.blade.php`) to create `User` login and complete `Customer` record simultaneously in `DB::transaction()`.
   - Created `public/assets/css/crud/auth.css` for standalone, branded Login, Register, and Forgot Password cards.
   - Added customer data isolation so borrowers only see their personal contracts.

---

### =======================================================
### Session 8: Final Review, Seeders & Submission Package
**Date:** 05 September 2026 | **Time:** 1:00 PM – 3:00 PM
### =======================================================

1. **Final Polish & Demo Dataset:**
   - Standardized system logo (`AdminLTELogo.png`) in top navbar and sidebar.
   - Wiped test data and built comprehensive presentation seeders:
     - `CategorySeeder`: 8 loan products (Personal, SME, Agriculture, Solar, Education, etc.).
     - `DummyDataSeeder`: 20 Cambodian customers and 10 employees across 5 departments.
     - `DemoLoanSeeder`: 4 live demo contracts (1 Pending, 1 Approved, 1 Active Disbursed, 1 Overdue).
   - Created comprehensive project `README.md` with architecture diagrams and test cheat sheets.
   - Generated final `CHANGELOG.md` development log.