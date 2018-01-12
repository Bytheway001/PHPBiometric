
# PHP Digital Biometrics

This is an app made for employees attendance management, using the Digital Persona u.Are.u 4500 under microsoft Windows

## Requirements:
 * Web server with PHP and Mysql Installed (If tested in localhost Xampp or Wampp would work perfectly)
 * Biometric Device u.Are.u 4500
 * Biometric SDK from https://flexcodesdk.com/
 * PC with microsoft windows (in this one we attach the biometric device)
## License
    MIT
## Usage
### Technical Setup:
    1.-Drop the files on a location reachable on your web server (For example: 127.0.0.1)

    2.- Inside the config folder, you will find "db_schema.sql", this is the blank database ready to use, load it into your Mysql server

    3.- If settings have been not set, you will have to configure them in order to get the software properly working, you will be redirected as soon as you access the application to the configuration page (Path '/install'), there you should set the following:
    
    * Company Name: The name of the organization using the software Ex: MyCompany
    * Code: ID number of the company Ex: 1234567
    * Domain: The main address to access your application Ex: https://mydomain.com
    * Port: In case you are using a specific port different from 80, please set this value, otherwise, leave it blank
    * Timezone: The timezone used in your actual location
    * BD Host: The database Host
    * Username: The database username
    * Password: The database password
    * Preffix: In case your database has a prefix, you can set it here

    4.- Save your settings and you will be redirected to the main page where you can login and make use of the system





