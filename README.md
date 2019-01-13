## Framework
My first thought was to use jennifer, a simple PHP framework that I created, 
but then I decide to use Symfony because of it is one of the most popular and powerful framework in the industry.

## Prerequisites
In order to run the test, you will need the following software installed and be ready
- Git
- Composer
- Web server suit (WAMP, XAMP, LAMP)

## Setup
These are the steps to set up using WAMP:
#### 1. Clone the project

Go to WAMP web root directory (by default is 'C:\wamp\www\') and run the command
<pre>
$ git clone https://github.com/ngodinhloc/brighte-test.git
</pre>

#### 2. Install dependencies

cd to "brighte-test" directory, then run the command

<pre>
$ composer install
</pre>

#### 3. Create database

Start WAMP services and create a new database name "brighte_test". 
If you are not using default username and password (root and empty) then open ".env" and update "DATABASE_URL" to the correct username and password.

Run the the following command to create the table

<pre>
$ php bin/console doctrine:migrations:migrate 20190113224316
</pre>

#### 4. Create a virtual host for the project

Open "WAMP" service and create a virtual host name "brighte-test" pointing to "C:\wamp\www\brighte-test\public"
Make sure that you have Apache module "rewrite_module" on then you can access the project at

http://bright-test/product/list/

## Run test

cd to "C:\wamp\www\brighte-test\" and run the following command 

<pre>
$ php bin/phpunit
</pre>

## Time spent
- Set up the dev environment: 1 hour
- Coding: 4 hours
- UniTest: 1 hour

Total : 6 hours