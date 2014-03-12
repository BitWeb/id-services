id-card
=======
[![Build Status](https://travis-ci.org/BitWeb/id-card.png?branch=master)](https://travis-ci.org/BitWeb/id-card)
[![Coverage Status](https://coveralls.io/repos/BitWeb/id-card/badge.png)](https://coveralls.io/r/BitWeb/id-card)

BitWeb plugin for Id Card authentication.

### Usage:

#### Adding lib
```sh
php composer.phar require bitweb/id-card
# (When asked for a version, type `1.*`)
```

or add 
```json
"require": {
  "bitweb/id-card": "1.*"
}
```
in composer.json

#### Integrating with apache

##### Add id-card folder into public
##### Should contain index.php with following contents:
```php
use IdCard\IdCardAuthentication;
chdir(dirname(__DIR__));

// Setup autoloading
include '../init_autoloader.php';

$loader->add('IdCard', '../vendor/');

session_start();

$redirectUrl = urldecode($_GET["redirectUrl"]);

$auth = new IdCardAuthentication();
if (!$auth->isSuccessful()){
	$redirectUrl = '/id-card/no-card-found';
}
else{
 	$_SESSION['idCardUser'] = serialize($auth->getUser());
}
$headerStr = 'Location: ' . $redirectUrl;

header($headerStr);
```
##### In same folder should exists .htaccess:
```
SSLVerifyClient require
SSLVerifyDepth 3
```
##### Now you link in application should point to this index.php with query parameter redirectUrl.


#### Adding id card support into dev
http://www.id.ee/public/Configuring_Apache_web_server_to_support_ID.pdf

Happy using
