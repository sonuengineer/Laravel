# Task & Project Management System

This project is a **Full Stack Task & Project Management System** built with **Laravel (Backend)**, **Django (Microservice)**, and **React (Frontend)**.  
It supports **Admin** and **User** roles with **JWT-based authentication** and enforces strict task status rules at the backend level.

---

## Tech Stack

### Frontend
- React 18
- Vite
- Axios
- Context API
- Plain CSS
- JWT stored in localStorage

### Backend
- PHP 8.x
- Laravel
- MySQL
- JWT Authentication
- REST APIs

### Microservice
- Django (Python)
- Handles overdue task business rules

---

## Roles & Permissions

### Admin
- Create projects
- Create and assign tasks
- View all tasks
- Close overdue tasks

### User
- Login
- View only assigned tasks
- Update task status (rules enforced by backend)

---

## Task Rules (Mandatory – Enforced by Django)

- Tasks past due date and not marked as DONE become **OVERDUE**
- OVERDUE tasks cannot move back to WIP / IN_PROGRESS
- Only Admin can close OVERDUE tasks
- Rules are enforced even if frontend is bypassed

---

## Setup & Run (Local)

### 1️⃣ Clone Repository & Install Dependencies
```bash
git clone <repository-url>
cd backend
composer install

cp .env.example .env
php artisan key:generate


DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_password


php artisan migrate
php artisan db:seed


composer require tymon/jwt-auth
php artisan jwt:secret

php artisan serve

http://localhost:8000

```


##Authentication Flow
---
User logs in with username & password

Laravel validates credentials

JWT token is generated and returned

Frontend stores token in localStorage

Token is sent in Authorization header for all protected APIs

Django Integration (Overdue Task Rules)

Laravel communicates with a Django microservice to:

Identify overdue tasks

Validate task status transitions

Enforce business rules

###Architecture:

---
Laravel → Main API Gateway

Django → Rule Enforcement Service

##Key API Endpoints (Sample)
POST   /api/login
GET    /api/projects
POST   /api/projects
GET    /api/tasks
POST   /api/tasks
PUT    /api/tasks/{id}/status


All protected routes require JWT

###Notes
---
No signup functionality (users are pre-created)

All business rules are backend-enforced

Frontend cannot bypass overdue task restrictions

Designed for scalability and microservice architecture

Assignment-ready and production-structured
