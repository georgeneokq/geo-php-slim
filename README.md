## Introduction
This MVC framework is built on top of PHP Slim Framework 4, built similarly to Laravel but more customizable and probably has lesser deployment problems (at least in shared hosting).

It is configured to be able to use Eloquent ORM to deal with database operations, as well as bootstrap CSS and JS for faster front-end development.

## Installation
Clone this repository, create .env file with reference to .example.env file.

Composer is required to install dependencies. Run `composer install` to install dependencies.

## For local development
Run `php -S localhost:8000` in the root folder to start a local development server.

## Deployment for shared hosting
1. Transfer files in the `public` folder into shared hosting's public folder.
2. Transfer the rest of the files into a different folder that is not accessible to the public.
3. Edit the constant SERVER_ROOT_PATH in **bootstrap/app.php** according to where you placed the non-public server files.

## Deployment on Linux apache2 server
Run the following commands to enable URL rewriting:

`sudo a2enmod rewrite` to enable mod_rewrite module

`sudo service apache2 restart` to apply changes

Add the following code into `/etc/apache2/apache2.conf` file (Assuming your public files are hosted in `/var/www/html` directory):

```
<Directory "/var/www/html">
        AllowOverride All
        Order allow,deny
        Allow from all
</Directory>
```

Uploading files may result in a very large payload. It is recommended to increase the `upload_max_filesize` and `post_max_size` values in `php.ini` file.

```
; Maximum allowed size for uploaded files.
upload_max_filesize = 100M

; Must be greater than or equal to upload_max_filesize
post_max_size = 105M
```

When moving uploaded files in Linux, retrieve files from `$_FILES` superglobal and use `move_uploaded_file()` function to do move the files. Even though the `uploadedFile` objects returned by `$request->getUploadedFiles()` provide a convenient`moveTo()` method, it doesn't work in Linux (after spending a whole day tinkering around with user groups and permissions, this method still didn't work).

## DEVELOPMENT TIPS
This framework is very similar to Laravel - it is an MVC framework that uses 

Eloquent Models are defined in `App/Models` folder.

Controllers are defined in `App/Controllers` folder, where controllers should extend the base class `Controller`.

Middleware are defined in `App/Middleware` folder, where middleware should extend the base class `Middleware`.

Both the base classes `Controller` and `Middleware` include the `encode` method, a handy function which by default encodes an array into a JSON string which you can send back to the client as the response. Depending on how you want to send back the data, you may want to change the implementation of the `encode` method by overriding it in your controller or directly in the base class `Controller`.

Routes should be neatly separated into `routes/api.php` file and `routes/web.php` file depending on what kind of route you are declaring.

For routes, the `group()` method groups all the routes declared within its callback function with a prefix. For example, when declaring a route `login` under `$app->group('api', ...)`, the full route becomes `/api/login`.

Middleware can be attached to routes by calling the `add` method on groups, for example: `$group->group(...)->add(new AuthToken())`, where AuthToken is a class that extends the base Middleware class.

When rendering views, it is possible to pass variables into the view by calling `$this->view->render($response, $view_path, $variables)` (see the WebController class that has been included by default).

Most of the framework configuration is set up in `bootstrap/app.php` file. The templating engine can also be changed there, but you will have to import the class you need by yourself. The current template engine is Slim\Views\PhpRenderer.