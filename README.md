# E-Commerce RESTful API

E-commerce project built with PHP CodeIgniter version 3.1.11. 

## Release Information

Currently the project is version 1 which is built to cover Wishlist and User Authentication modules.

## Requirements
- PHP 7.0 or above
- [CodeIgniter 3](https://codeigniter.com/userguide3/index.html)
- [Composer](https://getcomposer.org/doc/00-intro.md)

## Installation

1. Download or clone this repository to you server directory.
2. Use `composer` to download JSON Web Token (JWT) package from [Firebase/PHP-JWT](https://github.com/firebase/php-jwt):
```
composer require firebase/php-jwt
```
3. Use `composer` to download RESTful API package from [chriskacerguis
codeigniter-restserver](https://github.com/chriskacerguis/codeigniter-restserver):
```
composer require chriskacerguis/codeigniter-restserver
```
> The packages will be installed under the `vendor` folder created at your project root

5. Create a folder named `public` under project root and create sub folder named `ci_sessions` to store the codeigniter sessions file.

6. Configure your directory and path:

   **application/config/config.php**
   ```
   $config['base_url'] = 'http://{domain-name}/ecommerce/'; // depends to your server url
   $config['composer_autoload'] = FCPATH . '/vendor/autoload.php'; // depends to your package folder location
   $config['sess_save_path'] = FCPATH . 'public/ci_sessions'; // depends to your own folder location
   ```
7. Download `ecommerce.sql` file under the project root and import to your `mysql` database. Setup your own database `name`, `username` and `password`. Configure the database connection as follows: 

   **application/config/database.php**
   ```
   hostname = 'localhost' // database server host
   username = 'root' // database username
   password = 'root' // database password
   database = 'ecommerce' // database name
   ```

## Resources
- [CodeIgniter 3.1.11](https://codeigniter.com/userguide3/index.html)
- [Firebase/PHP-JWT](https://github.com/firebase/php-jwt)
- [RESTful API](https://github.com/chriskacerguis/codeigniter-restserver)