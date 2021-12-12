<p align="center">
<img src="https://raw.githubusercontent.com/nimiq/designs/master/logo/RGB/colored/png/nimiq_logo_rgb_horizontal.png" />
</p>

<br/>

<p align="center">
<img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Stable Version">
<img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
</p>

# Shop Directory Backend
The Shop Directory Backend is an application for serving and managing shops. This application also comes with an API endpoint for searching shops that have been imported or added. 

<br/>

## Quick setup for local development
After you've cloned this repository you can easily serve this application through the following steps. The quick setup assumes that you already have access to Docker, Docker Compose, Composer and NodeJS/NPM. The enviroment comes with NGINX, PHP 8 and Postgres 13 including the PostGIS extension enabled for geospatial storage. The database is made persisent through a Docker volume and can be found in `/docker/postgres/persistence`.

<strong>Note: this quick setup is meant for development purposes only. It doesn't come with proper database protection since no database password is necassary when the connection is coming from localhost.</strong>

<br/>

Copy a `.env`-file from the provided example. All the fields are already in place for local development:
```
cp .env.example .env
```

<br/>

Pull NodeJs packages:
```
npm install
```

<br/>

Pull PHP packages:
```
composer install
```

<br/>

Build dashboard files in development mode:
```
npm run dev
```

<br/>

Build all the necassary images and bring the system up:
```
docker-compose up
// OR start containers detached
docker-compose up -d 
```

<br/>

Start a new terminal session in the PHP container:
```
./terminal.sh php
```

<br/>

Inside the PHP container terminal session generate an Laravel APP_KEY:
```
php artisan key:generate
```

<br/>

Inside the PHP container terminal session run the migrations:
```
php artisan migrate
```

After downloading, bringing up and configuring the system it should be served on <a href="http://localhost:3000" target="_blank">http://localhost:3000</a>.