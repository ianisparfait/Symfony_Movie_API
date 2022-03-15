# Symfony API

## Install project
In your terminal (at the root of the project):

1. `composer install` || `composer update`
2. Open and run database server (laragon, wamp, xamp, mamp ...)
3. `php bin/console doctrine:database:create`
4. `php bin/console make:migration`
5. `php bin/console doctrine:migrations:migrate`
6. Run the symfony server with the command: `symfony server:start` || Open project with laragon, mamp, xamp, wamp...  
  **/!\ If you does'nt use symfony CLI, replace domain in VUEJS app /!\** =>  assets/vue/{files} => `domain: "127.0.0.1:8000/"`

In new terminal (in parallel):
1. `yarn install`
2. Build js/scss files with the command: `yarn run watch` ! This will rebuild a file build with each new change, no need to re-run the command.


## Set up application for use tests

1. Go on **/post-film** page
2. Fill in the fields and validate. **/!\ Adding a movie will not work if you upload files other than .jpeg, .jpg or .png /!\**
3. Go on home page and you can see your movie(s) ! Click on them to view them individually.
