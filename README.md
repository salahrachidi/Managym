# 🏋️‍♂️ Managym — Smart Gym Management Platform

A full-stack gym management and attendance tracking platform built with **Laravel**, **AJAX/jQuery**, and **Chart.js**.  
It centralizes member data, payments, coach assignments, and attendance tracking, with a future plan to integrate an **Arduino‑based entry system** for automated check‑ins.

---

## 🚀 Overview

**Managym** was developed as a modern, data‑driven gym management solution to streamline operations for small and medium fitness centers.  
It combines a clean dashboard interface, data visualization, and embedded IoT concepts to demonstrate both web and hardware integration.

---

## 🧰 Tech Stack

| Layer | Technologies |
|-------|---------------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript, jQuery, AJAX |
| **Backend** | Laravel (PHP Framework) |
| **Database** | SQLite (for local testing), MySQL (production) |
| **Data Visualization** | Chart.js |
| **Hardware (planned)** | Arduino + RFID / Fingerprint Sensor |
| **Development Tools** | Arduino IDE, Figma (UI), VSCode |

---

## ⚙️ Features

- 👥 **Member Management:** register, update, and manage members, packages, and payments.  
- 🧑‍🏫 **Coach Assignments:** link members to coaches, track performance and sessions.  
- 📊 **Dashboard Analytics:** visualize data through dynamic charts (members/month, gender ratio, status, etc.).  
- 💳 **Payment & Subscription Tracking:** monitor active and inactive memberships.  
- 🧾 **Automated Attendance System (Prototype):** powered by Arduino hardware (RFID/fingerprint).  
- 🧠 **Real-time Statistics:** built with Chart.js, updated via AJAX without page reload.  
- 🧩 **Flexible Architecture:** designed to scale or integrate with IoT devices.

---

## 🖼️ Screenshots (Dashboard & Modules)

> 📸 Below are key UI sections of the platform.

| Dashboard | Members | Coaches |
|------------|----------|----------|
| ![Dashboard Placeholder](screenshots/dashboard.png) | ![Members Placeholder](screenshots/members.png) | ![Coaches Placeholder](screenshots/coaches.png) |

| Packages | Payments | Statistics |
|-----------|-----------|-------------|
| ![Packages Placeholder](screenshots/packages.png) | ![Payments Placeholder](screenshots/payments.png) | ![Charts Placeholder](screenshots/charts.png) |

| Attendance | Settings | Login |
|-------------|-----------|--------|
| ![Attendance Placeholder](screenshots/attendance.png) | ![Settings Placeholder](screenshots/settings.png) | ![Login Placeholder](screenshots/login.png) |

> 🖼️ *You can place your 17 captured screenshots in a `/screenshots` folder to replace the placeholders above.*

---

## 🔌 Arduino Attendance System (Prototype)

The IoT subsystem uses an **Arduino UNO** (or compatible board) connected to:  
- **RFID reader** or **fingerprint sensor** for member authentication  
- **LCD module** for feedback display  
- **ESP8266 Wi‑Fi module** (optional) for data synchronization

📸 *Add your photos and videos here:*  
- ![Arduino Prototype Placeholder](hardware/arduino_prototype.jpg)  
- 🎥 *Demo Video Placeholder* (insert YouTube or file link here)

> 🧠 This system will mark member presence and send data directly to the Laravel backend via REST API endpoints.

---

## 🧪 Local Setup (Development)

```bash
# Clone the repository
git clone https://github.com/yourusername/managym.git
cd managym

# Install PHP dependencies
composer install

# Copy environment file and configure
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database (SQLite/MySQL in .env)
php artisan migrate --seed

# Run the development server
php artisan serve
```

---

## 🧠 Learning Outcomes

- Full‑stack development with Laravel & AJAX.  
- Real‑time chart rendering using Chart.js.  
- Database design for relational fitness data.  
- Hardware/software integration concepts with Arduino.  
- Agile iteration, version control, and UI design practice.

---

## 👨‍💻 Author

**Salaheddine Rachidi** — [@salahrachidi](https://github.com/salahrachidi)  
📧 *Insert your email or portfolio link here*

---

📚 *Project developed as part of my software engineering learning journey — combining web development and IoT automation.*
