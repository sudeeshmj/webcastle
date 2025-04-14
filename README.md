# Doctor Appointment Management System (Laravel)

A professional and modern web application built with Laravel to manage doctor schedules, appointments, and user interactions efficiently. This system includes features such as doctor scheduling, available slot checking, appointment booking with validation, and admin dashboards.

---
## 📌 Installation & Setup

### Prerequisites
- PHP 8.x
- MySQL
- Composer
- Laravel 11

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/sudeeshmj/webcastle.git
   cd webcastle
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up the environment variables:
   - Copy `.env.example` to `.env`:
     ```bash
     copy .env.example .env
     ```
   - Update the `.env` file with database credentials.

4. Generate key:
   ```bash
   php artisan key:generate
   ```

5. Run migration & seeder:
   ```bash
   php artisan migrate --seed
   ```
      
6. Link storage for image:
   ```bash
   php artisan storage:link
   ```
   
7. Start the development server:
   ```bash
   php artisan serve
   ```


