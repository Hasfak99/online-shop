# Online Shop - Premium Online Shop

A full-stack e-commerce application built with **Core PHP** and **MySQL**, following the 3-Tier Architecture. This project demonstrates advanced database management skills including stored procedures, triggers, views, and normalization.

## 🚀 Features

### 👤 Presentation Layer (Tier 1)
- **Modern UI**: Glassmorphism design system ("Online Shop Depth") built with HTML and Vanilla CSS.
- **Responsive Layout**: Fully functional on desktop and mobile.
- **Interactive Elements**: Real-time role selection, hover effects, and smooth transitions.

### ⚙️ Application Layer (Tier 2)
- **Authentication**: Secure multi-role login (Admin and User) with password hashing (BCRYPT).
- **CRUD Operations**: Admin panel to manage products and categories.
- **Shopping Flow**: User-side product browsing, cart management, and transactional checkout.
- **Validation**: Strict server-side validation on all forms.

### 📊 Data Layer (Tier 3)
- **3NF Schema**: 5 related tables optimized for data integrity.
- **Automation**: Triggers to handle stock prevention and automatic revenue calculation.
- **Performance**: Strategic indexing on search and relationship columns.
- **Logic**: Stored procedures for complex multi-table updates.

---

## 🛠️ Setup Instructions

1. **Database Setup**:
   - **Automatic (Recommended)**: Open your browser and go to `http://localhost/online-shop/setup_db.php`. This will create the database and import everything automatically.
   - **Manual**: Create a database named `online_shop` in MySQL and execute the SQL files in `sql/` in order (`schema`, `logic`, `data`).

2. **Web Server**:
   - Place the project folder in your local server directory (e.g., `htdocs` for XAMPP).
   - Configure your database credentials in `includes/db.php`.

3. **Login Credentials**:
   - **Admin**: `admin` / `password123`
   - **User**: `john_doe` / `password123`

---

## 📈 MySQL Implementation Details

| Feature | Description |
|---------|-------------|
| **Stored Procedures** | `sp_place_order` (Transactions), `sp_update_stock`, `sp_get_dashboard_stats`. |
| **Triggers** | `tr_after_order_item_insert` (Revenue auto-calc), `tr_prevent_negative_stock`. |
| **Views** | `v_sales_by_category` (Revenue analytics), `v_low_stock_report`. |
| **Indexes** | Applied on `products(name)` and `orders(user_id)`. |
| **Normalization** | All tables designed in **3rd Normal Form (3NF)**. |

---

## 👥 Team Contribution Table

| Name | Role | Contribution |
|------|------|--------------|
| Your Name | Full-Stack Developer | Database design, PHP Logic, UI/UX implementation. |
| Partner Name | Database Architect | ER Diagram, Normalization, SQL scripts. |

---

## 📝 Academic Information
**Institution**: UNIVERSITY OF VOCATIONAL TECHNOLOGY  
**Module**: Technology PHP and MySQL  
**Submission**: GitHub Link + PDF Document
