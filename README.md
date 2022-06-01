# # FOOTBALL CLUB MANAGER

    Php 8.1
    Symfony 6
    Composer 2


## Prerequisitos
    Docker version 20.10.15, build fd82621
    Docker Compose version v2.5.0


## Install

- Crear contenedores de Docker:
	docker compose up -d --build 

- Ir al contenedor de symfony y ejecutar composer.
	docker compose exec server bash
 	symfony composer require symfony/runtime

- Crear BBDD para testing:
	symfony console doctrine:database:create --env=test
	symfony console doctrine:schema:update --force  --env=test

- Ejecutar testing:
	composer test
		Las fixtures serán generadas de forma automática cada vez que se ejecuten los test y purgadas al finalizar.

- Ejecutar phpstan:
    composer phpstan


## Options

Acceso a servicios:
	web: http://127.0.0.1:8101/
	phpMyAdmin: http://127.0.0.1:8102/
	
Acceder al server de BBDD:
	docker exec -it lfp_api_2022-db bash


## Todo
    Desacoplar la infraestructura 
    Colección de Postman