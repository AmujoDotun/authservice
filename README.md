# Installation

Run Composer install
Create db and edit your .env file to corresponed with your data
run php artisan generate:key
Run php artisan migrate


# To power the app
Run php -S localhost:8000 -t public


# Testing the endpoints

# registration endpoint

localhost:8000/api/register

```json
 params:{
     "name": "Dotun",
    "email": "dotun@gmail.com",
    "password": "dotun"
    
}
```


# Login endpoint

localhost:8000/api/login
```json
 params:{
    "email": "dotun@gmail.com",
    "password": "dotun"
    
}
```






