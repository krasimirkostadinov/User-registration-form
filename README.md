# User registration form

__Description:__
This is task made by custom requirements. Implemented logic of user registration form with specific user related fields and form validations (server side and client side). They are reusable and can be extended in other project modules. I use a class autoloader by PSR-4 specification. Created class Helper for validations methods and options to be reusable. User class implements Interface with methods must implement.
For database connection i use my pre-ready class /models/Database.php with PDO driver.

If all fields are valid (server & client side) the user is saved in MySQL database with PDO connection.

Project information:
-------------
  I build custom PHP API, using Bootstrap 3.0, jQuery, Ajax and PHP-PDO for secure database connection. Escape dangerous tags and possible XSS attack.
  
Requirements:
-------------
  You need to have PHP 5.5.0 (because of some syntax used)
  - array notation []
  - password_hash() function

Installation:
-------------
  1. Download project ZIP file or clone it via GIT with command:
  
  __HTTPS__
  ```
  git clone https://github.com/krasimirkostadinov/User-registration-form.git
  ```
  
  __SSH__
  ```
  git clone git@github.com:krasimirkostadinov/User-registration-form.git
  ```
  2. Create MySQL database at your setup.
  3. Import "db_init.sql" file from project root folder to your database. This is initial database with nessesary fields.
  4. Configure virtualhost and set execute permission to project root folder (if Linux based).
  5. Please setup your project settings in ./config.php file.
    !important config settings:
    - HOST_PATH - host path (also URL) to your local project. It is used also for loading resource files.
  6. Set Database config files. I use separate DB class for connection at /models/Database.php. See $_cnf[] variable.
    - dbname - name your created database
    - username - user for database connection
    - password - user's password for database connection


Project preview:
----------------
  1. User form error state
  ![alt tag](/docs/error-registration.png?raw=true "Error state")

  2. User form successfull state
  ![alt tag](/docs/successfull-registration.png?raw=true "Successfull registration state")

Future improovements:
---------------------
  - Client side validations to be under every form field for better UX.
  - After first FALSE state, check validations on every „keyup“.
  - In server side validator implement checks for [required], [min_value_size], [max_value_size] size.
  - Check for unique email, before save. Every email should be unique value.
  - Login functionality.


