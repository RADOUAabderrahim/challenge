# challenge

This is a symfony 4.2 project

To run this project you need PHP7.2 and composer:

- git clone https://github.com/RADOUAabderrahim/challenge.git

- cd challenge

- composer update

after composer download all bundle needed for symfony to work, you need to step-up configuration for database (dbname and dbusername) in ".env" file

create database using : 

- php bin/console doctrine:migrations:migrate

create fixtures (fake data) for test using 

- php bin/console doctrine:fixtures:load

- php bin/console server:run

User with admin role (ROLE_ADMIN):
- email : admin@gmail.com
- password : admin

With role : ROLE_USER:
- email : test@gmail.com
- password : test

Enjoy ;-)