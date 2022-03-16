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

## System requirements
- PHP >= 8.0
- Composer 1/2
- PostgreSQL 13
- PostGIS 3.1
- NodeJS 16
- zlib-dev
- libpng-dev
- libzip-dev
- PHP pdo extension
- PHP pdo_pgsql extension
- PHP gd extension
- PHP zip extension

The <a href="https://laravel.com/docs/9.x/deployment#server-configuration">Laravel documentation</a> describes how to deploy the application together with NGINX.

<br/>

## Installation
Copy `.env.example` to `.env` and update accordingly.

Run `php artisan key:generate` once to generate the `APP_KEY` within the `.env`.

Run `composer install`

Run `npm run prod`

<br/>

## Quick setup for local development
After you've cloned this repository you can easily serve this application through the following steps. The quick setup assumes that you already have access to Docker, Docker Compose andd NodeJS/NPM. The enviroment comes with NGINX, PHP 8 and Postgres 13 including the PostGIS extension enabled for geospatial storage. The database is made persisent through a Docker volume and can be found in `/docker/postgres/persistence`.

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

Inside the PHP container terminal session pull PHP packages:
```
composer install
```

<br/>

Inside the PHP container terminal session generate a Laravel APP_KEY:
```
php artisan key:generate
```

<br/>

Inside the PHP container terminal session run the migrations:
```
php artisan migrate
```

After downloading, bringing up and configuring the system it should be served on <a href="http://localhost:3000" target="_blank">http://localhost:3000</a>.

<br/>

## Search API
The Shop Directory Backend exposes an `GET` endpoint located at `/api/search`. It can be used to query the stored shops through various filters based on geometric data. An overview of the current supported filters:

<br/>

### Examples

Return 50 results per page:

```/api/search?filter[limit]=50```

<br/>

Search for shops that have a label that contains `crypto` within the city `Wels`.

```/api/search?filter[label]=crypto&filter[city]=wels```

<br/>

| Field         | Query                                                                                                                                                                               |
|---------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| city          | ?filter[city]=value                                                                                                                                                                 |
| country       | ?filter[country]=value                                                                                                                                                              |
| description   | ?filter[description]=value                                                                                                                                                          |
| email         | ?filter[email]=value                                                                                                                                                                |
| label         | ?filter[label]=value                                                                                                                                                                |
| street        | ?filter[street]=value                                                                                                                                                               |
| number        | ?filter[number]=value                                                                                                                                                               |
| website       | ?filter[website]=value                                                                                                                                                              |
| zip           | ?filter[zip]=value                                                                                                                                                                  |
| bounding box  | ?filter[bounding_box]=9.11332882031104,44.48818941267919,18.902147179686295,51.57665233202192<br>1st = SW longitude<br>2nd = SW Latitude<br>3rd = NE longitude<br>4th = NE Latitude |
| limit         | ?filter[limit]=value                                                                                                                                                                |
| digital_goods | ?filter[digital_goods]=value                                                                                                                                                        |

<br/>

## Import Salamantex Excel file

Make sure you've supplied a `GOOGLE_MAPS_GEOCODING_API_KEY` in the `.env`.

Place the Salamantex Excel file inside the `storage` folder and name it `salamantex.xlsx`.

Login with your credentials and go to `/import/salamantex`.