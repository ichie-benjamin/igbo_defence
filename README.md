## IGBO DEFENCE BACKEND PROJECT SETUP


This is a laravel project, it connects to wordpress DB 
to fetch posts

### Backend SETUP
* git pull origin master
* cd to the project root
* composer install
* cp .env.example .env
* setup the db credentials, also confirm the db credentials of the wordpress site in config/database.php
* php artisan migrate
* php artisan db:seed
* Default login can be found in Database seeder

##  DOCUMENTATION
the postman documentation is located at /data folder of the project

## Admin
The project is built to connect to the wordpress db, all post management is done from wordpress admin access
The admin area of the laravel project is for basic upload of premium vendors
and cant be accessed at /login

