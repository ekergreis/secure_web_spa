# Authentification OAuth / Roles
#### Backend API : Laravel 6 avec tests unitaires (PHPUnit)
#### Frontend : Vue.JS Quasar SPA

__Objectif :__  Mise en place d'une application web SPA (Single Page Application) avec un système d'authentification (géré en backend par Laravel) utilisant le protocole OAuth et pouvant gérer des droits d'accès suivant les utilisateurs

__Résultats :__

- La sécurité est fiable côté __Laravel__ (backend) : 
    - Une API en accès limitée aux admins ne délivrera pas de données à un utilisateur non authentifié ou d'un autre groupe

- Le sécurité côté __Quasar__ (frontend) est plus légère car les variables vuex (stockée en LocalStorage) peuvent être modifiées par l'utilisateur final en utilisant des outils de développements :
	- Le "group" peut ainsi être modifier de "standard" en "admin"
	- L'accès à la route Vue "/user" (normalement limitée aux admins) sera alors possible tant qu'il n'y a pas d'appel à une API Laravel
		- La page sera une coquille vide car l'envoi de données sera refusé par Laravel (error 403)
		- L'erreur 403 renvoyée par Laravel sera automatiquement interceptée par Quasar (axios.interceptors.response) et l'utilisateur sera déconnecté

*Détail des fichiers modifiés identifiables avec commentaires commençant par __[OAUTH] ou [ROLE]__*

### Récupération sources :

	$ git clone https://ekergreis@bitbucket.org/ekergreis/secure_web_spa.git

### Backend : Laravel 6 API

| Requis |
| ------ |
| Apache |
| Base de données (mySQL, ...) |
| Composer |

| Composants utilisés |
| ------ |
| laravel/passport |
| fzaninotto/faker |
| doctrine/dbal |

#####  Mode Installation :

- __Installation from scratch :__

    	$ laravel new laravel_auth
    	$ cd laravel_auth
    	$ composer require laravel/passport
    	$ composer require fzaninotto/faker

    Détail des fichiers à modifier identifiables avec commentaires commençant par __[OAUTH], [ROLE] ou [TESTS]__

- __Installation des packages requis après récupération sources GIT :__

		$ cd laravel_auth
		$ composer install

##### Suite de l'installation :
	
Mise en place des tables

	$ php artisan migrate
	
Générer les clés d'encryption nécessaire à la génération des tokens

	$ php artisan passport:install

Configuration Virtual Host Apache (pour autoriser les requêtes provenant du même host)

    <VirtualHost *:80>
		DocumentRoot "<CheminVersLaravel>/laravel_auth/public"
		ServerName www.laravel_auth.local
		<Directory <CheminVersLaravel>/laravel_auth/>
			AllowOverride All
			Require all granted
			
			Header set Access-Control-Allow-Origin "*"
			Header set Access-Control-Allow-Methods "*"
			Header set Access-Control-Allow-Headers "X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding"
		</Directory>
	</VirtualHost>

##### Tests :	
	
Tests API avec un logiciel tel que Postman ou Insomnia
Exemple avec "signup" API (ajout d'un utilisateur)
    
    POST http://www.laravel_auth.local/api/signup 
    Headers :
        Content-Type: application/json
        X-Requested-With: XMLHttpRequest
    JSON :
        {
    	"name": "Manu",
    	"email": "e.kergreis@test.fr",
    	"password": "12345",
    	"password_confirmation": "12345"
        }

Pour créer les premiers utilisateurs dans la base mySQL :

- soit lancer le seeder Laravel pour créer 10 comptes dans la table "users" (mot de passe "123") : 

        php artisan db:seed	

- soit appeller l'API "signup" exemple au-dessus (avec Postman, Insomnia, ...)

### Frontend : Vue.JS Quasar SPA

| Requis |
| ------ |
| Node.JS |

| Composant utilisé |
| ------ |
| Quasar (Vue.JS) |
| axios |
| Vue-Router |
| Vuex |
| vuex-persistedstate |

#####  Mode Installation :

- __Installation from scratch :__

	Installer quasar-cli et modifier manuellement les fichiers :

		$ npm install quasar-cli
		$ quasar init frontend_auth
		$ npm install vuex-persistedstate

	Détail des fichiers à modifier identifiables avec commentaires commençant par __[OAUTH] ou [ROLE]__

- __Installation après récupération sources GIT (installation des dépendances par npm ) :__

    	$ cd frontend_auth
    	$ npm install

##### Suite de l'installation :

Fichiers configurables :

|Fichier|Détail|
| ------ | ------ |
| src/config/auth.js | Fichier de configuration des url de base Laravel et des clés OAuth |
| src/api/routes.js  |  Fichier de définitions des chemins vers API Laravel  | 

__Lancer pour tests__

	$ quasar dev

__Lancer pour production__

	$ quasar build

L'arborescence et les fichiers à mettre en production sont générés dans le dossier ./dist


# Enjoy !!!

*Auteur : Emmanuel Kergreis*