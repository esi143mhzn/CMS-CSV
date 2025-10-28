
# Client Management System

A client management system that enables users to import client data from CSV files, automatically detect and highlight duplicate records, manage client information, and export data back to CSV format.

## Live Demo
**Hosted URL**: [https://pramishmaharjan.com.np/clients](https://pramishmaharjan.com.np/clients)

## Features

- **CSV Import:** Upload client data directly from CSV files.  
- **Duplicate Detection:** Automatically flags records with identical company name, email, and phone number.  
- **Client Management:** Edit and delete duplicate client records.  
- **CSV Export:** Export filtered or full client lists to CSV.  
- **Pagination & Filtering:** Easily navigate through large datasets.  
- **Error Handling:** Prevents invalid or incomplete imports.
- **Testing:** Unit and Feature tests to ensure data integrity and functionality.
- **API Endpoints:** RESTful API for integration with error handling and validation responses.

## Tech Stack

- **Framework:** Laravel 12  
- **Database:** MySQL  
- **Language:** PHP 8.2+  
- **Package Manager:** Composer  
- **Frontend:** Blade, Bootstrap5
- **Testing:** PHPUnit
- **Version Control:** Git

## Prerequisites

Ensure the following are installed on your system:

| Requirement | Recommended Version |
|--------------|----------------------|
| PHP | ≥ 8.2 |
| Composer | ≥ 2.x |
| MySQL | ≥ 8.x |

## Installation (Local Setup)

### Clone the Repository
```bash
git clone https://github.com/esi143mhzn/CMS-CSV.git
cd CMS-CSV 
```

### Install PHP Dependencies
```bash
composer install 
```

### Create Environment File
```bash
cp .env.example .env
```

### Configure Environment Variables
Update .env with your local settings:
```bash
APP_NAME="Client Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=client_management
DB_USERNAME=root
DB_PASSWORD=yourpassword
```
Generate the application key:
```bash
php artisan key:Generate
```

### Run Migration
```bash
php artisan migrate
```
Seed sample client data:
```bash
php artisan db:seed --class=ClientSeeder
```

### Run the Application
```bash
php artisan serve
```
Then visit to:
```bash
http://localhost:8000
```
**NOTE:** You will redirect to:
```bash
http://localhost:8000/clients
```

## CSV Import/Export Workflow

**Step 1**: After visiting http://localhost:8000, you will be automatically redirected to the **Clients** page:
```bash
http://localhost:8000/clients
```
**Step 2**: Use the **Import CSV** form on this page to upload your client data file.

**Step 3**: Once the import is complete, click the **Manage Duplicates** button to review duplicate records.
You will be redirected to:
```bash
http://localhost:8000/duplicate-records
```
Here you can **edit** and **delete** duplicate records.

**Step 4**: Return to the Clients page to view the updated client list by clicking **Back to Clients** button.
```bash
http://localhost:8000/clients
```
**Step 5**: Use the **Export CSV** option (with optional filters) to download client data anytime.

## Running Tests
Make sure it points to a separate test database, for example cms_test.

### 1. Setup Test DB
```bash
CREATE DATABASE cms_test;
cp .env .env.testing
```

### 2. Run Migrations
```bash
php artisan migrate --env=testing
```

### 3. Run All Tests
```bash
php artisan test
```

## API Documentation
The system provides RESTful API endpoints for integration.

You can import the Postman collection below to test APIs.

### Postman Collection
[Download API Collection](https://www.postman.com/security-engineer-48926611-6395143/workspace/client-management-system/collection/47036268-1aff1ebf-1a23-456c-b915-17e3f7331b16?action=share&creator=47036268)

## License

This project is open-sourced under the MIT License.

## Support

For technical issues or feature requests, please open an issue or contact the maintainer.

