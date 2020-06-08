## Framework
My first thought was to use Jennifer, a simple PHP framework that I created, 
but then I decide to use Symfony because of it is one of the most popular and powerful framework in the industry.


#### 1. Install dependencies

cd to "symfony-product" directory, then run the command

<pre>
$ composer install
</pre>

#### 2. Create database

Run the the following command to create the table

<pre>
$ php bin/console doctrine:migrations:migrate 20190113224316
</pre>

#### 3. Run test

cd to "symfony-product" directory and run the following command 

<pre>
$ php bin/phpunit
</pre>

## Time spent
- Set up the dev environment: 1 hour
- Coding: 4 hours
- UniTest: 1 hour

Total : 6 hours