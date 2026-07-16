# John Doe fitness instructor

A Laravel + Livewire template for fitness professionals.

## Features

- Through the CMS, the admin can :
- post blog posts, create categories and tags
- post clients' stories with pictures
- create payed plans
- create "testimonials" section
- create "offers" section
- receive emails 

## Tech Stack

| Layer       | Technology                           |
|-------------|--------------------------------------|
| Backend     | PHP 8.4, Laravel 13                  |
| Frontend    | Livewire 4, Flux UI                  |
| Auth        | Laravel Fortify                      |
| Storage     | S3 (via Flysystem)                   |

## Requirements

- PHP ^8.4
- Composer
- Node.js & npm
- PostgreSQL

## Getting Started

Clone the repo, then run the bundled setup script — it installs dependencies, creates your `.env`, generates the app key, runs migrations, and builds frontend assets:

```bash
composer setup
```

Or step by step:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

Then start the dev environment (server, queue listener, and Vite, all at once):

```bash
composer dev
```

## Environment Variables

Configure your `.env` with at least:

```env
DB_CONNECTION=mysql
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
```
