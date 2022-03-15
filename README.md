# Symfony API

## Install project
In your terminal (at the root of the project):

1. `composer install` || `composer update`
2. Open and run database server (laragon, wamp, xamp, mamp ...)
3. `php bin/console doctrine:database:create`
4. `php bin/console make:migration`
5. `php bin/console doctrine:migrations:migrate`
6. Run the symfony server with the command: `symfony server:start` || Open project with laragon, mamp, xamp, wamp...  
  **/!\ If you does'nt use symfony CLI or your domain is different of "127.0.0.1:8000", replace domain in VUEJS app /!\** =>  assets/vue/{files} => `domain: "127.0.0.1:8000/"`

In new terminal (in parallel):
1. `yarn install`
2. Build js/scss files with the command: `yarn run watch` ! This will rebuild a file build with each new change, no need to re-run the command.


## Set up application for user(s)

1. Go on **/post-film** page
2. Fill in the fields and validate. **/!\ Adding a movie will not work if you upload files other than .jpeg, .jpg or .png /!\**
3. Go on home page and you can see your movie(s) ! Click on them to view them individually.

## Get the API documentation
1. Go to   
  `127.0.0.1:{port}/api` || `http://localhost:8000/api`  
2. Get all resources available from entities

## Add new Entity and retrieve it in API doc
1. Run in terminal at the root `php bin/console make:entity ${name}`
2. Follow instructions
3. After finishing and creating the entity, run: `php bin/console make:migration`
4. After that, run: `php bin/console doctrine:migrations:migrate`
5. And then, in the specified Entity file add theses lines:
  - ```use ApiPlatform\Core\Annotation\ApiResource;
    use ApiPlatform\Core\Annotation\ApiFilter;
    use Symfony\Component\Serializer\Annotation\Groups;```
