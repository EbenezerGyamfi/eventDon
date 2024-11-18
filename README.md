# Eventsdon 
[![Development CI](https://github.com/arkeselDev/eventsdon/actions/workflows/development.yml/badge.svg?branch=development)](https://github.com/arkeselDev/eventsdon/actions/workflows/development.yml)

[![Production CI](https://github.com/arkeselDev/eventsdon/actions/workflows/main.yml/badge.svg?branch=development)](https://github.com/arkeselDev/eventsdon/actions/workflows/main.yml)

## Set-up process
<br>

### Clone the repo
```
gh repo clone arkeselDev/eventsdon
```
or

```
git clone git@github.com:arkeselDev/eventsdon.git
```
<br>

### Install dependencies
```
composer install && npm install
```
<br>

### Create .env file
```
cp .env.example .env
```
<br>

### Generate application key
```
php artisan key:generate
```
<br>

### Edit .env 

<br>

### Migrate the database
```
php artisan migrate --seed
```
<br>



### Create Storage link
```
php artisan storage:link
```
<br>

### Create a cron job
```
* * * * * cd /path-to-the-project && php artisan schedule:run >> /dev/null 2>&1
```
<br>

### Launch application
```
php artisan serve
```
<br>

## Note
* You should use `.env.testing.example' as the base environment file when running tests locally