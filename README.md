# EvalPHP

#### This project is an e-commerce site offering pairs of shoes only in size 42.

## Setup:

```
apt install composer
composer install
```

For use our project you need to create a PHPMyAdmin database named "ecom" with no password,
you can anyway changes credentials config in 'e-com-php/App/Model/Config.php'.
Then you need to execute the 'ecom.sql' script in the PHPMyAdmin console of the database.

if you encounter an Error 404 by trying to access to the website loccally,
create a virtualhost pointing to the path of your local project with the name 'localhost'.

## OPTIONAL
If you want to fill the db with fake data you can execute the "setDB.php" script independently of the project (faker library is needed)

### Here is the link to the original repository:

```
https://github.com/Spikesito/e-com-php/tree/emileV2
```
