# rest-trade-cars-testtask

### Справка по командам
```bash 
[user@workstation rest-trade-cars-testtask]$ make

Usage commands:
   make ps              Status containers.
   make logs            Showing all containers logs.
   make build           Building all containers.
   make start           Running docker containers.
   make stop            Stopping docker containers.
   make restart         Restart docker containers.
   make vendors         Install vendors. Usage `composer install -n` in app container.
   make migrations      Up database tables. Usage `php bin/console doctrine:migrations:migrate` in app container.
   make import-data     Import cars in database. Usage `php bin/console app:import-data /var/shared/cars.csv` in app container.
   make credit-program-generate Generate credit in database. Usage `php bin/console app:credit-program:generate` in app container.
   make app             Entering in application container.
   make redis           Entering a database container.
   make db              Entering a database container.
```

### Установка
1. Для поднятия контейра выполнить команды:
    - `make build` или `docker-compose build` - Сборка
    - `make start` или `docker-compose up -d` - Поднятие контейнера
2. Установка зависимостей выполнить команды:
    - `make vendors` или `docker-compose exec php-fpm composer install -n`
    - `make migrations` или `docker-compose exec php-fpm php bin/console doctrine:migrations:migrate -n`
3. Наполнить базу данных  выполнить команды:
    - `make import-data` или `docker-compose exec php-fpm php bin/console app:import-data /var/shared/cars.csv`
    - `make credit-program-generate` или `docker-compose exec php-fpm php bin/console app:credit-program:generate`