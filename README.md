# Checklist
Lumen API

## Setup
1. Clone this repo, `git clone https://github.com/budhilaw/checklist.git`
2. Composer install, `composer install`
3. Duplicate `.env.example` then setting it
4. Migrate database, `php artisan migrate:fresh`
5. Seed the database, `php artisan db:seed`
6. Start, `php -S localhost:8000 -t public`

## Auth (Basic Auth)
- username: `admin`
- password: `admin`
