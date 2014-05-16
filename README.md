php-gen-doc-api
==========

Generate documentation for php API based application. No dependency. No framework required.

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Available Methods](#methods)
* [Preview](#preview)
* [Tips](#tips)
* [Known issues](#known-issues)
* [TODO](#todo)

### <a id="requirements"></a>Requirements

PHP >= 5.3.2

### <a id="installation"></a>Installation

The recommended installation is via compososer. Just add the following line to your composer.json:

```json
{
    ...
    "require": {
        ...
        "zckrs/php-gen-doc-api": "@dev"
    }
}
```

```bash
$ php composer.phar update
```
### <a id="usage"></a>Usage

```php
<?php

namespace Some\Namespace;

class User
{
    /**
     * @ApiDescription(section="User", description="Get information about user")
     * @ApiMethod(type="get")
     * @ApiRoute(name="/user/get/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="User id")
     * @ApiParams(name="data", type="object", sample="{'user_id':'int','user_name':'string','profile':{'email':'string','age':'integer'}}")
     * @ApiReturn(type="object", sample="{'transaction_id':'int','transaction_status':'string'}")
     */
    public function get()
    {

    }

    /**
     * @ApiDescription(section="User", description="Create's a new user")
     * @ApiMethod(type="post")
     * @ApiRoute(name="/user/create")
     * @ApiParams(name="username", type="string", nullable=false, description="Username")
     * @ApiParams(name="email", type="string", nullable=false, description="Email")
     * @ApiParams(name="password", type="string", nullable=false, description="Password")
     * @ApiParams(name="age", type="integer", nullable=true, description="Age")
     */
    public function create()
    {

    }
}
```

Create an genDocApi.php file in your project root folder as follow:


```php
# genDocApi.php
<?php

require __DIR__.'/vendor/autoload.php';

use Zckrs\GenDocApi\Builder;
use Zckrs\GenDocApi\Exception;

$classes = array(
    'Controller\GetController',
);

$output_dir = __DIR__.'/web/docs';
$output_file = 'index.html';

try {
    $builder = new Builder($classes, $output_dir, $output_file);
    $builder->generate();
} catch (Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}

```

Then, execute it via CLI

```php
$ php genDocApi.php
```

### <a id="methods"></a>Available Methods

Here is the list of methods available so far :

* @ApiDescription(section="...", description="...")
* @ApiMethod(type="(get|post|put|delete")
* @ApiRoute(name="...")
* @ApiParams(name="...", type="...", nullable=..., description="...", [sample=".."])
* @ApiReturn(type="...", sample="...")

### <a id="preview"></a>Preview

You can see a dummy generated documentation on http://zckrs.github.io/php-gen-doc-api/

### <a id="tips"></a>Tips

To generate complex object sample input, use the ApiParam "type=(object|array(object)|array)":

```php
* @ApiParams(name="data", type="object", sample="{'user_id':'int','profile':{'email':'string','age':'integer'}}")
```

### <a id="knownissues"></a>Known issues

I don't know any, but please tell me if you find something. PS: I have tested it only in Chrome !

### <a id="todo"></a>TODO

* Implemend "add headers" functionality for sandbox
* Implement options for JSONP
* Implement "add fields" option

