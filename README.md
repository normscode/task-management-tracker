# TaxTrack

A web-based tax management system for managing clients and tracking tax engagements.

TaxTrack was built as a personal project to strengthen my backend development skills using Laravel and to practice building a business-oriented application with database-driven workflows, RESTful APIs, AJAX interactions, and CRUD operations.

## Features

### Client Management
- Create and manage client records
- Store client contact information
- Categorize clients by entity type
- Manage client status
- Search and filter clients
- Archive clients using soft deletes

### Tax Engagement Management
- Create tax engagements for clients
- Track the type of tax service
- Assign tax years
- Set engagement start and due dates
- Track engagement status
- Add notes to engagements
- Search and filter engagements

### Dashboard
- View total clients
- View active clients
- View open tax engagements
- Display recently added clients
- Display upcoming tax engagements
- Highlight important engagement information

### Authentication
- User login and logout
- Session-based authentication
- Protected application routes

### Backend
- RESTful API endpoints
- Request validation
- Eloquent ORM relationships
- Database migrations
- Soft deletes
- Server-side data handling

### Frontend
- Bootstrap-based responsive interface
- Blade templates
- AJAX-powered CRUD interactions
- Bootstrap modals for forms
- Dynamic table updates without full-page reloads

---

## Tech Stack

| Technology | Purpose |
|------------|---------|
| PHP | Backend programming language |
| Laravel | Web framework |
| MySQL | Relational database |
| Eloquent ORM | Database interaction |
| Blade | Server-side templating |
| Bootstrap | UI and responsive design |
| jQuery | AJAX and frontend interactions |
| Docker | Development environment |
| Git | Version control |

---

## Application Structure

The application is organized around the main business entities of a tax management workflow:

```text
User
 │
 └── Authentication

Client
 │
 └── Tax Engagement
       ├── Service Type
       ├── Tax Year
       ├── Start Date
       ├── Due Date
       ├── Status
       └── Notes
