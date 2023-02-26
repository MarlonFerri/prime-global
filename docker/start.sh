#!/bin/bash
set -e

ROLE=${CONTAINER_ROLE:-APP}

echo "CONTAINER_ROLE: $ROLE"

echo "==================PROJECT VARIABLES=================="
echo "Verifying project environment variables..."
if [[ ! -f '/var/www/.env' ]]; then
  echo "You need to provide the .env"
  exit 1;
else
  echo "The app env variables are ok!"
fi
echo "==================PHP DEPENDENCIES=================="
echo "Verifying PHP dependencies..."
if [[ ! -d '/var/www/vendor' ]]
then
  echo "You need to create the PHP dependencies. Commands:"
  echo "1. COMMAND=\"composer install\" docker-compose up --no-deps composer"
  exit 1
else
  echo "The PHP dependencies are ok!";
fi

echo "==================DATABASE CONNECTION=================="
while ! mysqladmin ping -h"$DB_MYSQL_HOST" --silent; do
  echo "Waiting for database connection..."
  sleep 5
done

echo "Database is ready to start the application"


# echo "==================PASSPORT CONFIGURATION=================="
# php artisan passport:install

# echo "==================STORAGE LINK=================="
# php artisan storage:link

echo "==================Starting $ROLE=================="
php artisan serve --host=0.0.0.0 --port=8000

