## **Medkit 2 Migration: CodeIgniter 2.2.0 → CodeIgniter 3.1.13**  

## Overview
Medkit 2 is an upgraded version of the original Medkit application, migrated from CodeIgniter 2 to be compatible with PHP 8.2. 

Here’s a concise and well-structured GitHub description for your Medkit 2 migration project:  

---

This repository contains the upgraded version of **Medkit 2**, migrated from **CodeIgniter 2.2.0** to **CodeIgniter 3.1.13**, along with major improvements in security, performance, and compatibility.  

### **Key Enhancements**  
✅ **Upgraded PHP**: Transitioned from **PHP 5.4 to PHP 8.2**, ensuring better performance and security.  
✅ **Codebase Modernization**: Refactored to align with CodeIgniter 3’s architecture and best practices.  
✅ **Library Updates**: Integrated new **PDF and Excel processing libraries** for improved functionality.  
✅ **Enhanced Security**: Added **double-entry protection, CSRF protection, and secure session handling**.  
✅ **Performance Improvements**: Optimized database queries and error logging for better efficiency.  

### **Getting Started**  
1. Clone the repository:  
   ```bash
   git clone https://github.com/mikhaelfelian/p37-medkit-ci3.git
   ```
2. Install dependencies via Composer (if applicable).  
3. Configure `config.php`, `database.php`, and other necessary settings.  
4. Run database migrations and start the application.  

This migration ensures **long-term stability, improved security, and better maintainability**. 🚀  

---  

Let me know if you want to add more details or modify anything! 🔥

Updated from GitHub Repository: https://github.com/mikhaelfelian/p37-medkit-dev

## Features
- Full compatibility with PHP 8.2
- Improved security features
- Enhanced user interface with AdminLTE 3
- Optimized database operations
- Toast notifications for better user experience

## Requirements
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

## Installation
1. Clone the repository
2. Configure your database settings in `database/database.php`
3. Import the database schema from `database/database.sql`
4. Access the application through your web browser

## Migration Notes
This version includes significant changes from the original CodeIgniter 2 codebase:
- Updated deprecated functions and methods
- Replaced removed features with modern alternatives
- Enhanced form validation and security measures
- Improved error handling and logging

## Contributors
- Mikhael Felian Waskito - mikhaelfelian@gmail.com (contributed 01/03/2025)
- Alfian Hari Susatya - https://github.com/alfianharisusatya

## License
<small>This project is licensed under the MIT License - see the LICENSE file for details.</small>
-----------------------------------------------------------------------
# 🚀 Deployment Guide – Esensia SIMRS

## 📦 Overview

This project uses **GitHub Actions** for **Continuous Integration & Deployment (CI/CD)** to the production server `simrs.esensia.co.id`.

Deployment is manually triggered via the **"Actions > Deploy to Production"** menu in GitHub.

## 🌐 Environment

| Environment               | Description                |
|---------------------------|---------------------------|
| `dev.esensia.co.id`       | Testing environment for Alfian |
| `simrs.esensia.co.id`     | Main production server          |

---

## ⚙️ Workflow: Deploy to Production

This workflow runs in `workflow_dispatch` mode, which can be manually triggered from GitHub.

### 🔢 Input Parameters

| Input Name | Description |
|------------|-----------|
| `mode`     | Deploy mode. Options: `commit-all`, `commit-sha`, `revert-all`, `revert-sha` |
| `ref`      | Commit SHA or branch name (example: `main` or `e6a1b1d`). Used only if mode is `commit-sha` or `revert-sha` |

---

## 🚦 Mode Explanations

### ✅ `commit-all`
Deploy all latest changes from the `main` branch.

### ✅ `commit-sha`
Deploy based on a specific commit (SHA commit).  
Example: `e6a1b1d`  
📌 Use this if you only want to push a specific commit.

### 🔄 `revert-all`
Revert the last commit on the production server.

### 🔄 `revert-sha`
Checkout back to a specific commit (for manual rollback).  
Example: `e6a1b1d`

------

## 🧪 Suggested Workflow

1. **Developer commits to `main` branch or others**.
2. **Deploy to `dev.esensia.co.id` (automatic)**.
3. **Testing by Alfian**.
4. If testing passes, **run the "Deploy to Production" workflow**:
   - Choose mode `commit-all` or `commit-sha`.
   - Press `Run Workflow`.

---

## 👤 CI/CD Users

| Name            | Role                    | Contact                                |
|-----------------|-------------------------|----------------------------------------|
| Mikhael Felian  | Main Programmer         | mikhaelfelian@gmail.com                |
| Alfian Hari     | Contributor / QA Tester | https://github.com/alfianharisusatya   |


