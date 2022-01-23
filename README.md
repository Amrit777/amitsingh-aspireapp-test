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
- Run Command "php artisan setup:install". (This is an artisan command which will do rest of the things.)
- Run Command "php artisan serve" or ( "php artisan serve --port=8001" as my API collection is running on port 8001).

Now you are ready to run the API collection provided.

## Work Flow:

User:

- Log In using API: http://localhost:8001/api/auth/login </br>
    User logs in to the system, using credentials, I am using passport authentication system. </br>
    On successfull login, Bearer token is generated, which is used to access further APIs.
- Role based Access have been used on the routes, via middleware.
- User applies for loan filling the details. API: http://localhost:8001/api/loan/apply
- On success of saving the application with status "Processing", the application goes to Admin.
- And it is visible in the Loan Application list (Only current users list will be displayed). API: http://localhost:8001/api/loan/list 
- This list can be filtered based on "status".

Admin:

- Log In http://localhost:8001/api/auth/login
    Admin logs in to the system, using credentials.
- Goes to list of Applications: http://localhost:8001/api/admin/loan/list
    - Can filter list based on status and users
    - params: </br>
        - "state_id" (optional): </br>
            - LOAN_PROCESSING = 1; </br>
            - LOAN_ADMIN_APPROVE = 2; </br>
            - LOAN_ADMIN_REJECT = 3; </br>
            - LOAN_REPAID = 4; </br>
        - user_id  (optional): Any user id can be passed and based on this particular users loan applications will be fetched.

- Approves/Rejects the Application: http://localhost:8001/api/admin/loan/change-status </br>
        -"state_id": </br>
            - LOAN_ADMIN_APPROVE = 2;</br>
            - LOAN_ADMIN_REJECT = 3;</br>

- On Approval of application, weekly repayment records have been generated for that particular loan application.
for eg;</br> Loan of amount: 6000 INR,</br> for a tenure of 10 weeks.</br>
We will generate, 10 week repayment records.</br>
Each week user have to pay 6000/10 ie; 600 INR.</br>
In the response I am also calculating "remaining balance" after each payment.</br>

User:

- Once a user's application is approved, it will be visible in his loan applications list as Approved Loan Application.
- On each approved loan application, user can check all his weekly repayments "Paid" Or "Pending" for that particular loan application.
    API: http://localhost:8001/api/loan/repayment
- User can pay his weekly repayments. API: http://localhost:8001/api/loan/repayment
- Here Im checking if the amount is exact or not as per weekly payment amount.
- On successfull payment, the status will be changed to "Paid".
- Once the user pays all the weekly repayments as per tenure, the loan status will be marked as "Paid" too.
    for eg: 600 INR paid for 10 weeks is complete, will mark the main loan application status to be "Repaid".
- In the loan repayments records, we have "payment date" as per week. If any user fails to pay, using this we can notify user about the payment as well in the future scope.


## Credentials:
As per Seeder data.

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
