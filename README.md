php-gen-doc-api
==========
[![Build Status](https://travis-ci.org/zckrs/php-gen-doc-api.svg?branch=master)](https://travis-ci.org/zckrs/php-gen-doc-api) [![Coverage Status](https://coveralls.io/repos/zckrs/php-gen-doc-api/badge.png?branch=master)](https://coveralls.io/r/zckrs/php-gen-doc-api?branch=master) [![Dependency Status](https://www.versioneye.com/php/zckrs:php-gen-doc-api/dev-master/badge.svg)](https://www.versioneye.com/php/zckrs:php-gen-doc-api/dev-master) [![Latest Stable Version](https://poser.pugx.org/zckrs/php-gen-doc-api/v/stable.svg)](https://packagist.org/packages/zckrs/php-gen-doc-api)

Generate documentation for PHP API with Annotations. No dependency. No framework required.

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

You can see a sample generated documentation based on class [Client](tests/sample/Client.php) on http://zckrs.github.io/php-gen-doc-api/

### <a id="requirements"></a>Requirements

No dependency. No framework required. [View on Packagist.org](https://packagist.org/packages/zckrs/php-gen-doc-api)

You just need ```PHP >= 5.3.2```.

### <a id="installation"></a>Installation

The recommended installation is via composer. Just add the following line to your composer.json:

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
* Duplicate the [genDocApi.php](genDocApi.php) file in your project root for example.
* Set [options](#options) in this new file.
* Execute it via CLI: `php genDocApi.php`
* You get a new HTML file. (With default options stored in web/index.html)

### <a id="options"></a>Options
##### apiName
The name of the current API, displayed at the top of the generated file (default: ```php-gen-doc-api```).
##### apiDescription
The description of the current API, displayed on the top of the generated file (default: no value).
##### outputFile
The name of the generated file (default: ```index.html```).
##### outputDir
The directory to store the html file (default: ```/web```).
##### templateDir
The directory to store the views (default: ```/src/Resources/views```).

You can override view. See [how to custom output HTML](#custom-output-html)
##### assetDir
The directory to store the assets (default: ```/src/Resources/assets```).

You can override asset. See [how to custom output HTML](#custom-output-html)

### <a id="annotations"></a>Annotations

* [@ApiDescription(section="...", description="...")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apidescriptionsection-description)
* [@ApiMethod(type="(get|post|put|delete")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apimethodtypegetpostputdelete)
* [@ApiRoute(name="...")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apiroutename)
* [@ApiParams(name="...", type="...", nullable=(true|false), description="...", sample="...")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apiparamsname-type-nullabletruefalse-description-sample)
* [@ApiReturnRootSample(sample="{ ... }")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apireturnrootsamplesample--)
* [@ApiReturnObject(section="...", name="...", type="...", desc="...", note="...", link="...")](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Annotations#apireturnobjectsection-name-type-desc-note-link)


### <a id="custom-output-html"></a>Custom output HTML
##### What includes in default [layout.html](src/Resources/views/layout.html):

 - Bootstrap v3.1.1
 - jQuery v1.10.2
 - Google Code Prettify

##### How to custom output HTML:

 1. Create a main directory for views.
 2. Define option ```template_dir``` in ```genDocApi.php```.
 3. Put custom view with same model tree. [Details Views](https://github.com/zckrs/php-gen-doc-api/wiki/Details--Views)
 4. Each view contains some ```{{ variables }}```

### <a id="knownissues"></a>Known issues
If you have some problems or improvements, [contact me](https://github.com/zckrs/php-gen-doc-api/issues) via GitHub.

### <a id="acknowledgment"></a>Acknowledgment
This project is inspired by [Calinrada's php-apidoc](https://github.com/calinrada/php-apidoc) based on Swagger and use Extractor.php written by [Eriknyk](https://github.com/eriknyk/Annotations/blob/master/Annotations.php)
