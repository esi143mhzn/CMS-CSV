
# Client Management System

Client management system that enables users to import client data from CSV files, automatically detect and highlight duplicate records, manage client information, and export data back to CSV format.

## Features

- **CSV Import:** Upload client data directly from CSV files.  
- **Duplicate Detection:** Automatically flags records with identical company name, email, and phone number.  
- **Client Management:** Edit and delete duplicate client records.  
- **CSV Export:** Export filtered or full client lists to CSV.  
- **Pagination & Filtering:** Easily navigate through large datasets.  
- **Error Handling:** Prevents invalid or incomplete imports.

## Tech Stack

- **Framework:** Laravel 12  
- **Database:** MySQL  
- **Language:** PHP 8.2+  
- **Package Manager:** Composer  
- **Frontend:** Blade, Bootstrap5

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
DB_PASSWORD=
```
Generate the application key:
```bash
php artisan key:Generate
```

### Run Migration
```bash
php artisan migrate
```

### Run the Application
```bash
php artisan serve
```
Then visit to:
```bash
http://localhost:8000
```

## CSV Import/Export Workflow

**Step 1**: Navigate to Client Import page via link below. 
```bash
http://localhost:8000/import
```
**Step 2**: Upload your CSV file.

**Step 3**: Navigate to Duplicate Clients  via link below.
```bash
http://localhost:8000/duplicate-records
```
Here you can edit and delete duplicate records.

**Step 4**: Navigate to Client reports via link below.
```bash
http://localhost:8000/Clients
```
**Step 5**: Export clients anytime via Export CSV with filter option.

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

## License

This project is open-sourced under the MIT License.

## Support

For technical issues or feature requests, please open an issue or contact the maintainer.

