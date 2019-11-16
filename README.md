# Authentification OAuth / Roles
#### Backend API : Laravel 6 avec tests unitaires (PHPUnit)
#### Frontend : Vue.JS Quasar SPA

__Objectif :__  Mise en place d'une application web SPA (Single Page Application) avec un syst�me d'authentification (g�r� en backend par Laravel) utilisant le protocole OAuth et pouvant g�rer des droits d'acc�s suivant les utilisateurs

__R�sultats :__

- La s�curit� est fiable c�t� __Laravel__ (backend) : 
    - Une API en acc�s limit�e aux admins ne d�livrera pas de donn�es � un utilisateur non authentifi� ou d'un autre groupe

- Le s�curit� c�t� __Quasar__ (frontend) est plus l�g�re car les variables vuex (stock�e en LocalStorage) peuvent �tre modifi�es par l'utilisateur final en utilisant des outils de d�veloppements :
	- Le "group" peut ainsi �tre modifier de "standard" en "admin"
	- L'acc�s � la route Vue "/user" (normalement limit�e aux admins) sera alors possible tant qu'il n'y a pas d'appel � une API Laravel
		- La page sera une coquille vide car l'envoi de donn�es sera refus� par Laravel (error 403)
		- L'erreur 403 renvoy�e par Laravel sera automatiquement intercept�e par Quasar (axios.interceptors.response) et l'utilisateur sera d�connect�

*D�tail des fichiers modifi�s identifiables avec commentaires commen�ant par __[OAUTH] ou [ROLE]__*

### R�cup�ration sources :

	$ git clone https://ekergreis@bitbucket.org/ekergreis/secure_web_spa.git

### Backend : Laravel 6 API

| Requis |
| ------ |
| Apache |
| Base de donn�es (mySQL, ...) |
| Composer |

| Composants utilis�s |
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

    D�tail des fichiers � modifier identifiables avec commentaires commen�ant par __[OAUTH], [ROLE] ou [TESTS]__

- __Installation des packages requis apr�s r�cup�ration sources GIT :__

		$ cd laravel_auth
		$ composer install

##### Suite de l'installation :
	
Mise en place des tables

	$ php artisan migrate
	
G�n�rer les cl�s d'encryption n�cessaire � la g�n�ration des tokens

	$ php artisan passport:install

Configuration Virtual Host Apache (pour autoriser les requ�tes provenant du m�me host)

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

Pour cr�er les premiers utilisateurs dans la base mySQL :

- soit lancer le seeder Laravel pour cr�er 10 comptes dans la table "users" (mot de passe "123") : 

        php artisan db:seed	

- soit appeller l'API "signup" exemple au-dessus (avec Postman, Insomnia, ...)

### Frontend : Vue.JS Quasar SPA

| Requis |
| ------ |
| Node.JS |

| Composant utilis� |
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

	D�tail des fichiers � modifier identifiables avec commentaires commen�ant par __[OAUTH] ou [ROLE]__

- __Installation apr�s r�cup�ration sources GIT (installation des d�pendances par npm ) :__

    	$ cd frontend_auth
    	$ npm install

##### Suite de l'installation :

Fichiers configurables :

|Fichier|D�tail|
| ------ | ------ |
| src/config/auth.js | Fichier de configuration des url de base Laravel et des cl�s OAuth |
| src/api/routes.js  |  Fichier de d�finitions des chemins vers API Laravel  | 

__Lancer pour tests__

	$ quasar dev

__Lancer pour production__

	$ quasar build

L'arborescence et les fichiers � mettre en production sont g�n�r�s dans le dossier ./dist


# Enjoy !!!

*Auteur : Emmanuel Kergreis*