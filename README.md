# Symfony API

## Install project
In your terminal (at the root of the project):

1. `composer install` || `composer update`
2. Open and run database server (laragon, wamp, xamp, mamp ...)
3. `php bin/console doctrine:database:create`
4. `php bin/console make:migration`
5. `php bin/console doctrine:migrations:migrate`
6. Run the symfony server with the command: `symfony server:start`  
  ***/!\ If you does'nt use symfony CLI, Open project with laragon, mamp, xamp, wamp...***

In new terminal (in parallel):
1. `yarn install`
2. Build js/scss files with the command: `yarn run watch` ! This will rebuild a file build with each new change, no need to re-run the command.


## Set up application for user(s)

1. Go on **/post-film** page
2. Fill in the fields and validate. ***/!\ Adding a movie will not work if you upload files other than .jpeg, .jpg or .png***
3. Go on home page and you can see your movie(s) ! Click on them to view them individually.

## Get the API documentation
1. Go to   
  `127.0.0.1:{port}/api` || `http://localhost:{port}/api`  
2. Get all resources available from entities

## Add new Entity and retrieve it in API doc
1. Run in terminal at the root `php bin/console make:entity ${name}`
2. Follow instructions
3. After finishing and creating the entity, run: `php bin/console make:migration`
4. After that, run: `php bin/console doctrine:migrations:migrate`
5. And then, in the specified Entity file add theses lines:
   - In use bloc
   ```
    use ApiPlatform\Core\Annotation\ApiResource;
    use Symfony\Component\Serializer\Annotation\Groups;
   ```
   - In annotation before declaring class
   ```
    * @ApiResource(
    *   normalizationContext={"groups" = {"read"}},
    *   denormalizationContext={"groups" = {"write"}}
    * )
   ```
   - For each entry in class (private ${..}) adds this annotation line to specify if it is a read, write ...
   ```
    * @Groups({"read"})
   ```
   OR
   ```
    * @Groups({"read", "write"})
   ```
6. Go to   
  `127.0.0.1:{port}/api` || `http://localhost:{port}/api` and see the new entity in API doc !

## JWT Token
### Generate private/public key and use
**!!! Create jwt folder in /config !!!**
1. Run `openssl genrsa -out config/jwt/private.pem -aes256 4096` in terminal (project root) to create Private token
2. Follow instructions and save your passphrase
3. Run `openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem` in terminal (project root) to create Public token
4. Follow instructions with same passphrase
5. Create .env.local file at the root of the project and write:
    ```
      ###> lexik/jwt-authentication-bundle ###
      JWT_PASSPHRASE=your_pass_phrase
      ###< lexik/jwt-authentication-bundle ###
    ```
