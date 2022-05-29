Simple Booking System

this project uses Lumen framwework for docs please check[ https://lumen.laravel.com/docs/9.x ](https://lumen.laravel.com/docs/9.x/installation)
<h1>Installing</h1>
<ol>
<li> Clone the repo </li>
<li> copy the .env.example to a .env file </li>
<li> install dependecies through</li>
    
```
composer update
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
 
    
<li> open another termihnal and run the queue worker</li>

```
php artisan queue:work
```
</ol> 
<hr>
<h1> Testing </h1> 
<ol>
<li> running the tests ( ps run the seed command after running the test because it removed the data from database after it finishes )  </li>
    
 ```
    vendor/bin/phpunit
 ``` 
    
<li>
for manual testing import this postman collection in your postman app 
https://github.com/hossammohammed72/booktrip/blob/2fb971fda8e79902ab92f530e4a9fff9385e91b5/BookTrip.postman_collection.json

</li>
</ol>
<h1> Database design </h1>


![Untitled Diagram drawio](https://user-images.githubusercontent.com/20538134/170732642-bc9b3a8a-4ca4-4849-a599-e76c15e7df7d.png)



Description: We are offering trips between two cities (no stops in between) with a limited
number of spots on each trip. Any customer can reserve one (or more) spot(s), but once all
spots are reserved, the trip cannot accept any other reservation request unless a reserved
spot is cancelled and becomes available again.
