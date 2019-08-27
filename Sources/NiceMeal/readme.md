**SYSTEM REQUIREMENTS**  
PHP >= 7.1.3  
MySQL  
NodeJS  

**DEVELOPMENT MODE**  

_BUILD ADMIN THEME_  
cd resources/themes/metronic_v5.1.5/tools  
npm install  
gulp  

_COPY ADMIN THEME_  
npm install  
gulp copy:admin-theme  

_RUN WEB_  
php artisan key:generate
composer install  
npm install  
npm run dev  
php artisan migrate  
php artisan db:seed (optional)  
php artisan  

**PRODUCTION BUILD**  

_BUILD ADMIN THEME_  
cd resources/themes/metronic_v5.1.5/tools  
npm install  
gulp --prod  

_COPY ADMIN THEME_  
npm install  
gulp copy:admin-theme  

_COPY DISTRIBUTION_  
composer install  
npm install  
npm run prod  
gulp


**DEPLOY TO HEROKU**

- **PRODUCTION BUILD**
- Heroku account: contact Mr. Tuan B
- Backup database:
    - Go to https://dashboard.heroku.com/apps/nice-meal/resources
    - Select **ClearDB MySQL** to backup DB
- Update Environment:
    - Go to https://dashboard.heroku.com/apps/nice-meal/settings
    - Click button **Reveal Config Vars** to change config
- Install heroku cli: https://devcenter.heroku.com/articles/heroku-cli
- add **heroku respository** to git
    > $ git remote add heroku https://git.heroku.com/nice-meal.git
- verify remote repository list
    > $ git remote -v
- pull, commit, push code to **develop** branch
- checkout to **master** branch
    > $ git checkout master
- merge **develop** branch, commit and push code to heroku master
    > $ git merge develop \
    $ git commit -m "Commit Message"\
    $ git push origin master
    $ git push heroku master
- migrate database
    > $ heroku run php artisan migrate
- check logs:
    > $ heroku logs --app nice-meal


**USE ANGULARJS IN BLADE PHP**

* Create ng-controller name in blade file*
example: <div class="container" ng-controller="LocationShowController">
* Create Controller Js file in resources/assets/b2c-js
example locations/show.js
* Run npm run dev. Recommend 'npm run watch' to auto generate files  


**CREATE LOGIN WITH FACEBOOK**

* Create App at https://developers.facebook.com/
* Goto App dashboard then make configuration:
    * At Settings->Basic:
    - Fill App Domains: Example: localhost
    - Copy App ID and App Secret and save to .env.example and .env
        Example:
            FACEBOOK_CLIENT_ID=294150401228493
            FACEBOOK_CLIENT_SECRET=c5bb590473564be45e4e7ce3eebdf806

    * Goto PRODUCTS->Facebook Login->Settings
    - Fill Callback URIS
        Example: https://localhost/auth/facebook/callback
    - Copy Add callback URL to .env.example and .env
        Example:
            FACEBOOK_URL = https://localhost/auth/facebook/callback

    * Set STATUS FROM DEVELOPMENT TO LIVE

**BUILD APIS DOC**
- Check example in folder Http/Api/OrdersController
- When finish writing api doc, open command line and run: npm run apidoc
- Detail documentation: http://apidocjs.com

**NEW DATA AND MIGRATION 15/05/2019**
-php artisan migrate
-composer dump-autoload
-php artisan db:seed --class=NiceMinUserSeed
-php artisan db:seed --class=UserRoleSeeder

**NEW DISTRICT SEQUENCE DATA 20/05/2019**
-php artisan migrate
-composer dump-autoload
-php artisan db:seed --class=DistrictReseed
-php artisan db:seed --class=WardReseed

**NEW DISTRICT SEQUENCE DATA 21/05/2019**
-php artisan migrate
-composer dump-autoload
-php artisan db:seed --class=OptionSeeder

**DATA FOR COUNTRY TABLE 21/05/2019**
-php artisan migrate
-composer dump-autoload
-php artisan db:seed --class=CountrySeeder
