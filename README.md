## Introduction
This framework is built on top of PHP Slim Framework 4, built similarly to Laravel but more customizable and probably has lesser deployment problems (at least in shared hosting).

## Installation
Clone this repository, create .env file with reference to .example.env file.

Composer is required to install dependencies. Run `composer install` to install dependencies.

## Deployment for shared hosting
1. Transfer the public files (/css, /js, index.php) into shared hosting's public folder.
2. Transfer the rest of the files into a separate folder that is placed in the shared hosting's root folder.
3. Edit the constant SERVER_ROOT_PATH in **bootstrap/app.php** according to where you placed the non-public files.
