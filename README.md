# Laravel Assessment

This project is created on Laravel 8 and Vue 2.

## Project Description
This is a Film Catalog project where user can see the list of films and their details like release date, ticket price, country etc. Users also be able to register and login themselves. Authenticate users can add new films and also able to post comments for each film.

  

## Project Setup

After cloning a project. Run this command to insatall dependencies

```
composer install
```

After installing dependencies. Rename ".env.example" to ".env".


## Setup Database

create database with name **"innovative_assessment_db"** and run the follwing command.
```
php artisan migrate --seed
```
This command creates database tables and insert records.

  

## Run Project

  

Run project with the following commands.

```
php artisan serve
```