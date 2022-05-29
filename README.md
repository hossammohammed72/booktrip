Simple Booking System

this project uses Lumen framwework for docs please check[ https://lumen.laravel.com/docs/9.x ](https://lumen.laravel.com/docs/9.x/installation)
<h1>Installing</h1>
<h4>
<ol>
<li> Clone the repo </li>
<li> copy the .env.example to a .env file </li>
<li> run </li>
 ```
 php artisan key:generate
 ```
    
to generate your key</li>
<li> instal dependecies through</li>
```
composer update
```
```
composer dump-autoload
```
<li> create a database with the same name in the .env file</li>
<li> run database migration and seeds </li>
```
php artisan migrate --seed
```
<li> serve the api </li>
```
php -S localhost:8000 -t public
```

database design : 



![Untitled Diagram drawio](https://user-images.githubusercontent.com/20538134/170732642-bc9b3a8a-4ca4-4849-a599-e76c15e7df7d.png)



Description: We are offering trips between two cities (no stops in between) with a limited
number of spots on each trip. Any customer can reserve one (or more) spot(s), but once all
spots are reserved, the trip cannot accept any other reservation request unless a reserved
spot is cancelled and becomes available again.
