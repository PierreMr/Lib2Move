# Lib2Move


## Command 

* `composer install`
* `npm install`
* `docker-compose up -d`

------

* `docker-compose exec lib2move bash`
	* `php bin/console d:s:u --force`
	* `php bin/console doctrine:fixtures:load`


## Webpack Setup

* `apt install curl`
* `curl -sL https://deb.nodesource.com/setup_10.x | bash`
* `apt install npm`
* `npm install sass-loader node-sass --dev`
* `npm install`

------

* `npm run encore dev --watch`


## DataFixtures

* [https://symfonycasts.com/screencast/doctrine-relations/fixture-references](https://symfonycasts.com/screencast/doctrine-relations/fixture-references)
* [https://github.com/fzaninotto/Faker](https://github.com/fzaninotto/Faker)
*
* ```php bin/console doctrine:schema:drop --force && bin/console doctrine:schema:update --force && bin/console doctrine:fixtures:load -n```
