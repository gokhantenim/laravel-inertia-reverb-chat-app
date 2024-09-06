
# Laravel inertia & reverb chat app demo

A real-time chat platform built using Laravel, Inertia.js, and Reverb for an engaging and dynamic communication experience. The application leverages Laravel's powerful backend capabilities to handle user authentication, chat room management, and message storage while utilizing Inertia.js for a seamless, single-page application (SPA) feel without the need for heavy JavaScript frameworks.


## Installation

First clone this repository.

```bash
git clone https://github.com/gokhantenim/laravel-inertia-reverb-chat-app.git chat-app
```

Go to the folder.

```bash
cd chat-app
```

Install Dependencies

```bash
composer install
```
```bash
npm install
```

Build

```bash
npm run build
```

### Prepare MySQL Server

```bash
docker compose up
```
Or, if you prefer to use your already installed MySQL server, simply update the database configurations in the .env file to match your server settings.

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=chatapp
  DB_USERNAME=admin
  DB_PASSWORD=123123
```

### Prepare Database

Create the tables
```bash
php artisan migrate
```

Create the sample users
```bash
php artisan db:seed
```

### Run 

Start the web socket server
```bash
php artisan reverb:start
```

Start the web server
```bash
php artisan serve
```
