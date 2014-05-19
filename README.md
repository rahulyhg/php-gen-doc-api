php-gen-doc-api
==========

Generate documentation for php API based application. No dependency. No framework required.

* [Preview](#preview)
* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Options](#options)
* [Annotations](#annotations)
* [Custom output html](#custom-output-html)
* [Known issues](#known-issues)
* [Acknowledgment](#acknowledgment)

### <a id="preview"></a>Preview

### <a id="requirements"></a>Requirements

You just need ```PHP >= 5.3.2```.

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
###<a id="usage"></a>Usage
######Create an genDocApi.php file in your project root folder as follow :
```php
<?php

// Use autoload
require __DIR__.'/../../autoload.php';

// Or include classes
// require_once(__DIR__.'/src/Builder.php');
// require_once(__DIR__.'/src/Extractor.php');
// require_once(__DIR__.'/example/User.php');
// require_once(__DIR__.'/example/Document.php');

use Zckrs\GenDocApi\Builder;

$classes = array(
    'Controller\GetController',
);

try {
    $builder = new Builder($classes,
        array(
            'output_file'  => 'index.html',
            'output_dir'   => __DIR__.'/../web',
            'template_dir' => __DIR__.'/Resources/views',
            'asset_dir'    => __DIR__.'/Resources/assets',
        )
    );
    $builder->generate();
} catch (\Exception $e) {
    echo 'There are an error when generating the documentation : ', $e->getMessage();
}

```
#####Then, execute it via CLI :
```php
$ php genDocApi.php
```
### <a id="options"></a>Options
#####**output_file**
The name of the generated file (default : ```index.html```).
#####**output_dir**
The directory to store the html file (default : ```/web```).
#####**template_dir**
The directory to store the views (default : ```/src/Resources/views```).
You can override each view. See [how to extend output HTML](#extend)
#####**asset_dir**
The directory to store the assets (default : ```/src/Resources/assets```).
You can override each asset. See [how to extend output HTML](#extend)

### <a id="annotations"></a>Annotations
Here is the list of annotations available so far :

#####**@ApiDescription(section="...", description="...")**
*Argument :*

```section``` : section which stores the method documentation
```description``` : description of the method

*Example :*

```php
    /**
     * @ApiDescription(section="User", description="Get information about user")
     */
    public function getUser() {}

    /**
     * @ApiDescription(section="Document", description="Get a document")
     */
    public function getDocument() {}
```

#####**@ApiMethod(type="(get|post|put|delete")**
*Argument :*

```type``` : type of HTTP request

*Example :*

```php
    /**
     * @ApiMethod(type="GET")
     */
    public function getUser() {}
```

#####**@ApiRoute(name="...")**
*Argument :*

```route``` : url to call api

*Example :*

```php
    /**
     * @ApiRoute(name="/document/get/{id}")
     */
    public function getDocument() {}
```

#####**@ApiParams(name="...", type="...", nullable=(true|false), description="...", sample="...")**
*Argument :*

```name``` : name of param

```type``` : primitive types

```nullable``` : param is required or not

```description``` : a short description

```sample``` : example value

*Example :*

```php
    /**
     * @ApiParams(name="id", type="integer", nullable=false, description="Unique ID document", sample="123456")
     */
    public function getDocument() {}
```

#####**@ApiReturnRootSample(sample="{ ... }")**
*Argument :*

```sample``` : describes format of root JSON node (use simple quote in JSON sample)

*Example :*

```php
    /**
     * @ApiReturnRootSample(sample="{ 'documentID': documentObject }")
     */
    public function getDocument() {}
```

#####**@ApiReturnObject(section="...", name="...", type="...", desc="...", note="...", link="...")**
*Argument :*

```section``` : property describes belongs to section

```name``` : name of property

```type``` : primitive type

```desc``` : a short description

```note``` : define a note for user

```link``` : create a anchor link to another section


*Example :*

```php
    /**
     * @ApiReturnObject(section="documentObject", name="title", type="string", desc="Title of document.")
     * @ApiReturnObject(section="documentObject", name="authors", type="array", desc="A array of authors.", note="Exist if not empty", link="authorObject")
     *
     * @ApiReturnObject(section="authorObject", name="id", type="integer", desc="ID author.")
     * @ApiReturnObject(section="authorObject", name="username", type="string", desc="Username author.")
     */
    public function getDocument() {}
```

### <a id="custom-output-html"></a>Custom output HTML
##### What includes in default layout :

 - Bootstrap v3.1.1
 - jQuery v1.10.2
 - Google Code Prettify

##### How to custom:

 1. Create a main directory for views.
 2. Define ```template_dir``` in ```genDocApi.php```.
 3. Put custom view with same model tree. [details](https://github.com/zckrs/php-gen-doc-api/wiki/Details--views)
 4. Each view contains some ```{{ variables }}```

### <a id="knownissues"></a>Known issues
If you have some problems or improvements, [contact me](https://github.com/zckrs/php-gen-doc-api/issues) via GitHub.

### <a id="acknowledgment"></a>Acknowledgment
This project is inspired by [Calinrada's php-apidoc](https://github.com/calinrada/php-apidoc) based on Swagger  and use Extractor.php written by [Eriknyk](https://github.com/eriknyk/Annotations/blob/master/Annotations.php)
