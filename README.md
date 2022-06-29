<h1 align="center">Laravel MongoDB REST API</h1>

## Requirements
Before setup the project, you need to install this : 
- **Docker Compose**

## Installation Guide
- Run `docker-compose up -d --build`
- Run `docker-compose exec app composer install`
- Run `docker-compose exec app npm install`
- Copy `env.example` to `.env`
- Copy `env.example` to `.env.testing` for unit testing
- Run `docker-compose exec app php artisan migrate:refresh --seed`
- Run `docker-compose exec app php artisan key:generate`
- For unit testing Run `docker-compose exec app php artisan test`

## URL 
- Web : `http://localhost:8080`
- DB / MongoDB : `http://localhost:27018`
- API Document : `http://localhost:8080/api/v1/documentation`
