```markdown
# 📦 Inventory Management System

A lightweight and efficient Inventory Management System built using CodeIgniter 4. This system enables businesses to manage stock, purchases, vendors, and reporting from a centralized dashboard.

## 🚀 Features

- ✅ Product & Category Management
- ✅ Unit of Measure (UOM) Mapping
- ✅ Purchase Entry & Vendor Tracking
- ✅ Invoice Generation
- ✅ Real-time Stock Updates
- ✅ Date-wise Summary & Filtering
- ✅ Role-based Access Control (Admin/User)
- ✅ Responsive Dashboard
- ✅ DataTables Integration with Export Options

## 🛠️ Tech Stack

- **Backend:** PHP 8+, CodeIgniter 4
- **Frontend:** Bootstrap 5, jQuery, DataTables
- **Database:** MySQL / MariaDB
- **Others:** Vanilla JS Datepicker, Moment.js

## 📁 Folder Structure

```

app/
├── Controllers/
├── Filters/
├── Models/
├── Views/
├── Config/
└── Helpers/
public/
├── assets/
└── index.php

````

## 🔐 User Roles

- **Admin**
  - Full access to all modules
  - Can manage users, vendors, purchases, and reports
- **User**
  - Can view stock and limited access to reports

## ⚙️ Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/skriptxadmin/Inventory-Management-System.git
   cd Inventory-Management-System
````

2. **Set up environment**

   * Copy `.env.example` to `.env` and update your DB credentials

     ```bash
     cp env .env
     ```

3. **Set writable permissions**

   ```bash
   chmod -R 775 writable/
   ```

4. **Run migrations (if using migration)**

   ```bash
   php spark migrate
   ```

5. **Serve locally**

   ```bash
   php spark serve
   ```

6. **Access the app**

   ```
   http://localhost:8080
   ```

## 🧪 Sample Admin Credentials

```txt
Username: administrator@example.com
Password: Password@123
```

🔗 **Live Demo:** [http://ims.skriptx.com/](http://ims.skriptx.com/)


*(Change credentials after first login.)*

## 📝 Customization

* Filters for `IsAdmin`, `Auth`, etc., are set in `app/Config/Filters.php`
* Default routes in `app/Config/Routes.php`
* Theme/CSS in `public/assets/`

## 📦 Deployment Notes (cPanel)

* Upload all files to `/public_html`
* Move `public/index.php` one level up and update:

  ```php
  require '../app/Config/Paths.php';
  ```
* Make sure `.env` and writable permissions are properly set

## 🧑‍💻 Author

Developed by [Alaksandar Jesus Gene AMS](https://github.com/your-username)

## 📄 License

This project is licensed under the MIT License.

```

---

Let me know if you want to include screenshots, a live demo link, or instructions specific to hosting on cPanel.
```
