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
4. Download `ecommerce.sql` file under the project root and import to your `mysql` database. Setup your own database `name`, `username` and `password`.

5. Configure your CodeIgniter framework

   **application/config/config.php**
   ```
   $config['base_url'] = 'http://{server domain}/ecommerce/'
   $config['composer_autoload'] = FCPATH . '/vendor/autoload.php' or depends to your package folder installation.
   ```
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