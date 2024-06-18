## Imara TV Dashboard

This is the backend code for the [Imara TV](https://imara.tv).

## Requirements
- PHP 8.2+
- MySQL 8+
- Apache/Nginx Server
- Composer for PHP packages installation
- Node JS and NPM for js packages installation
- Git

## Setup & Installation

1. Clone git repo: `git clone https://github.com/ImaraTv/ImaraTV_Dashboard.git imaratv-dashboard`. This will clone the project into a directory named `imaratv-dashboard`
2. Navigate into the project directory
3. make storage folder writable
4. run `composer install` to install required php packages
5. copy `.env.example` to `.env`
6. edit the new `.env` to add database credentials and also update APP_URL and also LIVEWIRE_UPDATE_URL if necessary
7. run `php artisan key:generate` to generate app key
8. run `php artisan migrate` to migrate db tables
9. run `php artisan shield:super-admin` to create admin user
10. run `php artisan shield:install` to install the roles and permissions
11. Navigate to installation url e.g http://localhost/imaratv-dashboard/login

## Troubleshooting

1. livewire.js error 404:
    - run `php artisan livewire:publish`
    - then run `php artisan cache:clear;php artisan config:clear;php artisan route:clear;php artisan view:clear;`

2. Trouble login in with error "THE POST METHOD IS NOT SUPPORTED FOR ROUTE LOGIN. SUPPORTED METHODS: GET, HEAD."
    - it means livewire.js is not getting loaded
    - run `php artisan vendor:publish --force --tag=livewire:assets`
    - then edit `routes/web.php` to set correct routes for Livewire:
    - NB: make sure that LIVEWIRE_UPDATE_URL in `.env` is correctly set
   ```
   Livewire::setScriptRoute(function ($handle) {
   return Route::get('/vendor/livewire/livewire.js', $handle);
   });

   Livewire::setUpdateRoute(function ($handle) {
   return Route::post(env('LIVEWIRE_UPDATE_URL'), $handle);
   });
   ```
   
