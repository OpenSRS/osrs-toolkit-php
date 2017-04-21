# Official OpenSRS PHP Toolkit

The purpose in building out these libraries is to help ease the implementation
of the OpenSRS API.  Not only does it give a starting point in developing an
application to allow for quick integration, but also incorporates new
communication markup languages such as JSON and YAML.  

## Support
Our support team will be able to help with general connectivity issues outlined
in: (http://domains.opensrs.guide/docs/troubleshooting)

If you find a bug in the sample provided with this toolkit, please contact
OpenSRS Support with the XML output and response. We will not, however, be able
to troubleshoot PHP configuration with your web host nor additional PHP code
that you developed. Should you require assistance on those matters, please work
with a website developer.

Requirements
------------

This PHP library currently supports data being passed in JSON and YAML (it is
also being extended to pass data in XML and Array format as well).

The OpenSRS PHP Tookit requires:

- PHP 5
- OpenSSL
- PEAR: http://pear.php.net/
- cURL: required for OMA
- php-curl: required for OMA - http://www.php.net/manual/en/book.curl.php 

NOTE:  It's best to use the PHP 5.3+ as json_encode and json_decode are standard
on that version and above. If an earlier version of PHP 5 is needed, the php-json
libraries at http://pecl.php.net/package/json will be required.

## Installation

```
composer require opensrs/osrs-toolkit-php 
```

## Configuration

To configure your OpenSRS API settings, copy the sample config file
[openSRS_config.php.template](https://github.com/OpenSRS/osrs-toolkit-php/blob/develop/opensrs/openSRS_config.php.template) and modify with
your own OpenSRS API settings.  Be sure to require your config before using.  For more details 
see the following section on Boostrapping.

For more detailed configuration information refer to 
(https://github.com/OpenSRS/osrs-toolkit-php/wiki/Configuration)

## Bootstrapping
You can bootstrap the OpenSRS toolkit by sourcing the composer autoloader, 
as well as your OpenSRS config file.  For example if you saved your OpenSRS 
config file as config/openSRS_config.php, you would bootstrap by running the
following:
```php
require_once('vendor/autoload.php');
require_once('config/openSRS_config.php');
```

## Using the toolkit
```php
require_once('vendor/autoload.php');
require_once('config/openSRS_config.php');

try {
    $request = new Request();
    $response = $request->process('array', $data);

    // dump raw results
    var_dump($response->resultRaw);

} catch (\OpenSRS\Exception $e){
    // handle exception(s)
}
```

Refer to the [OpenSRS API Documentation Page](http://www.opensrs.com/site/resources/documentation/api) for available requests & attributes.

## Backwards Compatibility
For pre v4.0.0 users, backwards compatibility has been included so you can continue
using the toolkit as you were before. 

```php
require_once ("your_root_path/opensrs/openSRS_loader.php");

$data = array (
    "func" => "lookupLookupDomain",
    "data" => array (
        "domain" => "google.com",
    )
);

$osrsHandler = processOpenSRS ("array", $data);

var_dump($osrsHandler);
```

## Documentation
[OpenSRS API Documentation Page](http://www.opensrs.com/site/resources/documentation/api)

[OpenSRS/osrs-toolkit-php Wiki](https://github.com/OpenSRS/osrs-toolkit-php/wiki)

