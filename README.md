# Simple Task Management System

## Project Overview

Simple Task Management System is a web-based project developed for Web Programming II and Software Engineering Project. The system helps users manage their daily tasks in an organized way.

Users can create an account, log in, add tasks, edit tasks, delete tasks, and update task status. The system also includes an admin dashboard that allows the admin to view users and tasks.

## Technologies Used

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Object-Oriented Programming (OOP)
- PDO Database Connection

## Main Features

### User Features

- User registration
- User login
- View user dashboard
- Add new task
- Edit task
- Delete task
- Change task status
- Logout

### Admin Features

- Admin login
- Admin dashboard
- View users
- View tasks
- Manage system data

## Project Structure

The project contains the following main folders and files:

- `admin/` : Contains admin dashboard files.
- `assets/` : Contains CSS and design files.
- `classes/` : Contains PHP classes such as User and Task.
- `config/` : Contains database connection file.
- `index.php` : Home page.
- `login.php` : User and admin login page.
- `register.php` : User registration page.
- `dashboard.php` : User dashboard page.
- `add_task.php` : Add task page.
- `edit_task.php` : Edit task page.
- `delete_task.php` : Delete task functionality.
- `toggle_task.php` : Change task status functionality.
- `task_management.sql` : Database file.

## Database

The system uses a MySQL database named:

`task_management`

Main tables:

- `users`
- `tasks`

The database file is included in the project as:

`task_management.sql`

## How to Run the Project

1. Install XAMPP.
2. Start Apache and MySQL.
3. Copy the project folder to the `htdocs` folder.
4. Open phpMyAdmin.
5. Create a database named `task_management`.
6. Import the file `task_management.sql`.
7. Open the project in the browser using:

```text
http://localhost/TASK-MANAGEMENT-OOP/
Testing

The system was tested manually. The following tests were performed:

User login test
Add task test
Edit task test
Delete task test
Change task status test
Admin login test

All main tests were completed successfully.

Design Pattern Used

The project uses Object-Oriented Programming principles. The system separates the main logic into classes such as:

User.php
Task.php
Database.php

This makes the code more organized, reusable, and easier to maintain.

Author

Elham Raed Hasan
Student ID: 2320231793

Supervisor

Eng. Firas F. Al-Ijla
