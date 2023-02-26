# PrimeIT - Global Fashion

## Docker config
Create network:
``docker network create --driver=bridge --subnet=172.18.0.0/16 --ip-range=172.18.0.0/24 --gateway=172.18.0.1 sync-network``

Create volume for db:
``docker volume create --driver local prime_data``

Install php dependencies:
``COMMAND="composer install" docker-compose -d --no-deps prime_composer``

Run containerse:
``docker-compose up -d --no-deps prime_app``
``docker-compose up -d --no-deps prime_db``

Nginx:
You could use localhost as target or the ``prime.test`` url with nginx configuration.
``docker-compose up -d --no-deps nginx``

## Database configuration
Use the following command to attach to container:
``docker exec -it prime_app /bin/bash``

Inside the container run the migrations:
``php artisan migrate``

Inside the container run the seeds to populate the database:
``php artisan db:seed``

## Requesting
Use the route ``prime.test/api/price`` as target for tests.
The route is waiting for a xhr request with the following fields:
- ``price``: that should contain the price;
- ``currency``: the currency string ('EUR' or 'DOL');
- ``size``: the name of the size;
- ``product``: the name of the product;
- ``category``: the name of the category.


## Considerations
The category is required for the route, but I do not use it on the code. I did this way because the product already have the relationship described into the model. Once that the names are uniques, will not be products with same name in two different categories.

Is not described into the challenge the rule for a request with a size without no price, but for a category with all sizes with same value where another size already have a price. This situation should not exists for the rules, but thinking in a large project, where categories could change, I implemented the verification for it blocking the update.

Taking the actual time, I exceeded the time of two hours by 10~15 minutes. This time was used to finish this README file.