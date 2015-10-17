README
======

Olapic - Location Test
----------------------

Simple RESTful mini WS with only one endpoint.

Requirements
------------

PHP 5.5+.

Installation
------------
```
$ git clone https://github.com/eacheble/locations-test.git
$ composer install
```

Running the WS locally
----------------------
```
$ php -S localhost:8080 -t . index.php
```

Running Symfony Tests
---------------------
```
$ vendor/bin/phpunit
```

Using the WS
------------

With the WS running locally you can:

```
$ curl -i -X GET -H "Content-type: application/json" -H "Accept: application/json"  "http://localhost:8080/locations/{id}"
```

where ``` {id} ``` is the instagram media id from which you want to extract the location information.

e.g:

```
$ curl -i -X GET -H "Content-type: application/json" -H "Accept: application/json"  "http://localhost:8080/locations/8"
```