id-card
=======
[![Build Status](https://travis-ci.org/BitWeb/id-services.svg?branch=master)](https://travis-ci.org/BitWeb/id-services)
[![Coverage Status](https://img.shields.io/coveralls/BitWeb/id-services.svg)](https://coveralls.io/r/BitWeb/id-services?branch=master)

BitWeb plugin for Id Card authentication ang signing.

### Usage:

#### Adding lib
```sh
php composer.phar require bitweb/id-services
# (When asked for a version, type `1.0.*`)
```

or add following to composer.json

```json
"require": {
  "bitweb/id-services": "1.0.*"
}
```

#### Integrating with apache

##### Add id-card folder into your public folder
##### The folder should contain index.php with following contents:
```php
use BitWeb\IdCard\Authentication\IdCardAuthentication;

chdir(dirname(dirname(__DIR__)));

// Autoload classes
include 'vendor/autoload.php';
include 'init_autoloader.php';
Zend\Mvc\Application::init(require 'config/application.config.php');

$redirectUrl = urldecode($_GET["redirectUrl"]);

if (!IdCardAuthentication::isSuccessful()) {
    $redirectUrl = '/id-card/no-card-found';
} else {
    IdCardAuthentication::login();
}
$headerStr = 'Location: ' . $redirectUrl;

header($headerStr);
```
##### In same folder should exist .htaccess:
```
SSLVerifyClient require
SSLVerifyDepth 3
```
##### Now your link in application should point to this index.php with query parameter redirectUrl.


#### Adding id card support into development environment
http://www.id.ee/public/Configuring_Apache_web_server_to_support_ID.pdf

Happy using
