# evalatore-frontend-
Aplication for Accreditation Library.

# Requirements
1. PHP 7.4 or higher
2. NPM version 6.14.12 or higher
3. Composer v1 or Higher

# How To Install
1. git clone git@github.com:Lektor-Media-Utama/evalatore-frontend.git
2. run composer install
3. copy .env.example and rename to .env
4. run php artisan key:generate
5. change API_BASE_URL to host API
6. run npm install & npm run dev
7. run php artisan serve for test

## ENV
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

API_BASE_URL=

```
