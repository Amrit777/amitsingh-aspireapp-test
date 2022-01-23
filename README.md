<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Pre Requisites

- Make sure to have composer on your system.
- Check the server requirement for the setup in your local machine in XAMPP or WAMP
    - PHP >= 7.3 
    - BCMath PHP Extension 
    - Ctype PHP Extension 
    - Fileinfo PHP extension 
    - JSON PHP Extension 
    - Mbstring PHP Extension 
    - OpenSSL PHP Extension 
    - PDO PHP Extension 
    - Tokenizer PHP Extension 
    - XML PHP Extension
- Create a DB for this project, copy the details which will be used in the installation process.

## Steps to follow to Install Laravel Project.

- First step is to, clone this project. (git clone https://github.com/Amrit777/amitsingh-aspireapp-test.git).
  Once cloning of the project is done. Go to root of this project and Open terminal to 
- Run Command "composer install"
- Open .env file and update your env file.
    <p>
    DB_DATABASE=YOUR_DATABASE_NAME </br>
    DB_USERNAME=YOUR_DATABASE_USERNAME or (root) </br>
    DB_PASSWORD=YOUR_DATABASE_PASSWORD or (empty) </br>
    </p>

Once done with the changes, Open terminal again to
- Run Command "php artisan setup:install"
- Run Command "php artisan serve" or ( "php artisan serve --port=8001" as my API collection is running on port 8001).

Now you are ready to run the API collection provided.

Admin Credentials:

Email: admin@yopmail.com
Password: Admin@123

User Credentials:

User 1: 
    Email: testing@yopmail.com
    Password: User@123

User 2: 
    Email: testing2@yopmail.com
    Password: User@123

User 3: 
    Email: testing3@yopmail.com
    Password: User@123

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Thank You!!!
