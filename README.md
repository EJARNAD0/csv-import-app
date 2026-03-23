# CSV Transaction Import App

A simple Laravel application for uploading CSV files containing transaction data, parsing them, and displaying the results in a clean, filterable table.

## Features

- Upload CSV files through a web form
- Parse CSV data and store in MySQL database
- Display transactions in a responsive, filterable table
- Error handling for wrong file types, empty files, and duplicate entries
- Clean UI built with Tailwind CSS
- Responsive design for mobile and desktop

## Requirements

- PHP 8.4+
- Composer
- MySQL
- Node.js & npm (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd csv-import-app
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Copy environment file and configure:
```bash
cp .env.example .env
```

Edit `.env` to set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Build frontend assets:
```bash
npm run build
```

8. Start the development server:
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## Usage

1. Go to the homepage
2. Click "Choose File" to select a CSV file
3. Click "Upload CSV" to process the file
4. View the imported transactions in the table below
5. Use the search box to filter transactions by description, business, or category

## CSV Format

The CSV file should have the following headers:
- `date` (YYYY-MM-DD format)
- `description`
- `amount` (decimal)
- `business`
- `category`
- `transaction_type`
- `source`
- `status`

Example:
```csv
date,description,amount,business,category,transaction_type,source,status
2024-01-01,Test transaction 1,100.00,Test Business,Food,Debit,Bank,Completed
2024-01-02,Test transaction 2,50.00,Another Business,Transport,Credit,Card,Pending
```

## Error Handling

- **Wrong file type**: Only CSV and text files are accepted
- **Empty file**: Files with no content are rejected
- **Duplicate entries**: Transactions with the same date, description, and amount are skipped
- **Invalid data**: Rows with validation errors are skipped with error logging

## Technologies Used

- Laravel 13
- MySQL
- Tailwind CSS
- Laravel Excel (maatwebsite/excel)
- Vite (for asset compilation)
