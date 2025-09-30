Here’s a README.md draft tailored to your task requirements:

# 📩 Laravel Contact Us Page

This project implements a **Contact Us page** in Laravel with form validation, database storage, email notifications, and automated testing.

---

## 🔹 Features

- Contact form with fields:
  - **Name** (required, max 100 characters)
  - **Email** (required, valid email)
  - **Subject** (required, max 150 characters)
  - **Message** (required, max 2000 characters)
- Saves submitted messages into the `contacts` table.
- Sends email notification to the **admin** (email address configured via `.env`).
- Displays success/failure response to the user.

---

## 🔹 Requirements

- PHP >= 8.1  
- Laravel >= 10.x  
- MySQL or compatible database  
- Composer  
- Node.js (optional, for frontend styling with Vite)  

---

## 🔹 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-repo/laravel-contact.git
   cd laravel-contact


2. **Install dependencies**

composer install
npm install && npm run dev   # optional, for styling


3. **Set up environment variables**

Copy .env.example to .env and update values:

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Laravel Contact"
MAIL_ADMIN=admin@example.com


4. **Run migrations**

php artisan migrate


4. **php artisan serve**

Visit: http://localhost:8000/contact

🔹 License

This project is open-source and available under the Apache2 License.