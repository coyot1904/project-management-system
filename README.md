# Project Management System

This is a Project Management System built using **PHP** with the **Laravel** framework for the backend and **HTML, CSS, and JavaScript** for the frontend. The system allows users to manage projects and associated tasks, providing the ability to create, read, update, and delete (CRUD) both projects and tasks. It uses a RESTful API for communication between the frontend and backend.

## Table of Contents

1. [Project Overview](#project-overview)
2. [Features](#features)
3. [Design Pattern Used](#design-pattern-used)
4. [Setup Instructions](#setup-instructions)
5. [How to Use](#how-to-use)
6. [API Endpoints](#api-endpoints)
7. [Frontend Interaction](#frontend-interaction)
8. [Code Structure](#code-structure)
9. [Testing](#testing)
10. [Future Enhancements](#future-enhancements)

## Project Overview

The Project Management System is designed to help users keep track of multiple projects and their tasks. Users can view a list of all projects, add new projects, and manage individual tasks within each project.

### Key Features:

-   **Projects**: Add, edit, view, and delete projects.
-   **Tasks**: Add, edit, view, and delete tasks associated with a specific project.
-   **User Authentication**: Basic user authentication using Laravel’s built-in system.
-   **Responsive Design**: The frontend UI is built with **Bootstrap**, making it responsive and user-friendly.

## Features

-   **CRUD Operations for Projects and Tasks**
-   **RESTful API Development**
-   **User Authentication**
-   **Frontend Interactivity with Vanilla JavaScript**
-   **Responsive Design with Bootstrap**

## Design Pattern Used

### Repository Pattern

The **Repository Pattern** was used to **abstract** the data access layer for Projects and Tasks. The repository pattern provides a cleaner way to manage data access, encapsulating the database queries within repository classes, which makes the application more maintainable and testable.

### Implementation Details:

-   `ProjectRepository` and `TaskRepository` were created to handle data access logic for projects and tasks.
-   The repositories were injected into the controllers using dependency injection.
-   This approach makes the code modular, easy to test, and promotes the separation of concerns.

### Benefits of the Repository Pattern:

-   **Improved Testability**: Easy to mock database operations for unit testing.
-   **Reduced Code Duplication**: Common database operations are handled within the repository.
-   **Separation of Concerns**: Keeps business logic separate from data access code.

## Setup Instructions

Follow these steps to set up the project on your local environment:

### Prerequisites:

-   PHP >= 7.4
-   Composer
-   Laravel 8.x or higher
-   MySQL or MariaDB
-   Node.js and npm (for frontend dependencies)

### Step 1: Clone the Repository

Clone the repository to your local machine using the following command:

```bash
git clone https://github.com/your-username/project-management-system.git
cd project-management-system
```

### Step 2: Install Dependencies

Run the following commands to install PHP and Node.js dependencies:

```bash
composer install
npm install
```

### Step 3: Configure Environment

Copy the example environment configuration file and update your environment settings:

```bash
cp .env.example .env
```

Modify the database details in the `.env` file as follows:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=MagicPort
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 4: Generate Application Key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### Step 5: Run Migrations and Seed the Database

Set up the database schema and seed initial data:

```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Serve the Application

Run the Laravel development server:

```bash
php artisan serve
```

Navigate to `http://127.0.0.1:8000` in your browser to view the application.

### Step 7: Running the Frontend

Go to the `/frontend` folder and open `index.html` in your browser to access the frontend UI.

## Testing

To ensure that the application is functioning as expected, a comprehensive set of unit and feature tests have been created. These tests cover the basic CRUD operations for both `Projects` and `Tasks`, as well as some additional use cases such as viewing all tasks for a specific project.

### Prerequisites for Testing

Ensure that your environment is set up correctly and you have migrated the test database:

```bash
php artisan migrate --env=testing
```

### Running Tests

Use the following command to run the tests:

```bash
php artisan test
```

### Test Coverage

The following areas are covered in the test suite:

1. **Project Tests**:

    - Create, update, and delete projects.
    - Retrieve a list of all projects.
    - Retrieve a single project by ID.

2. **Task Tests**:

    - Create, update, and delete tasks.
    - Retrieve a list of all tasks for a specific project.
    - Retrieve a single task by ID.

3. **Authentication and Permission Tests**:
    - Ensure only authorized users can create or delete projects and tasks.

The test results should be displayed in the console, indicating the success or failure of each test case.

## How to Use

-   After setting up the project, open the frontend UI by navigating to the `frontend` folder and opening the `index.html` file in your browser.
-   Use the interface to create, edit, and manage projects and tasks.
-   Use the search and filter options to view projects or tasks based on specific criteria.

## API Endpoints

**Project Routes**:

-   `GET /api/projects` - Retrieve a list of projects.
-   `POST /api/projects` - Create a new project.
-   `GET /api/projects/{id}` - Retrieve a single project.
-   `PUT /api/projects/{id}` - Update a project.
-   `DELETE /api/projects/{id}` - Delete a project.

**Task Routes**:

-   `GET /api/projects/{project_id}/tasks` - Retrieve a list of tasks for a specific project.
-   `POST /api/tasks` - Create a new task.
-   `GET /api/tasks/{id}` - Retrieve a single task.
-   `PUT /api/tasks/{id}` - Update a task.
-   `DELETE /api/tasks/{id}` - Delete a task.

## Code Structure

The project structure is organized as follows:

-   `app/` - Contains the core application files (controllers, models, etc.).
-   `routes/` - Defines the web and API routes.
-   `database/` - Contains migrations, seeders, and factories.
-   `tests/` - Contains the test files for unit and feature testing.
-   `frontend /` - Contains frontend assets (CSS, JavaScript, HTML).

## Future Enhancements

Some potential future improvements include:

-   Adding advanced filtering and sorting options.
-   Implementing user roles and granular permissions.
-   Introducing more interactive UI components.
