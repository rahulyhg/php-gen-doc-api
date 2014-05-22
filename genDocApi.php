<?php

// Use autoload
// require __DIR__.'/../../autoload.php';

// Or include classes
require_once(__DIR__ . '/src/Builder.php');
require_once(__DIR__ . '/src/Extractor.php');
require_once(__DIR__ . '/src/Entity/OptionsBuilder.php');
require_once(__DIR__ . '/tests/sample/Client.php');

use Zckrs\GenDocApi\Builder;
use Zckrs\GenDocApi\Entity\OptionsBuilder;

// Define classes to search annotations
$classes = array(
    'Zckrs\GenDocApi\Test\Client',
);

// Options for the Builder. Please see Zckrs\GenDocApi\Entity\OptionsBuilder for available attributes.
$optionsBuilder = new OptionsBuilder();
$optionsBuilder->setApiName('My API');
$optionsBuilder->setApiDescription('That is my awesome API. And this is why you will fall in love with.');
$optionsBuilder->setOutputFile('index.html');
$optionsBuilder->setOutputDir(__DIR__.'/web');

try {
    $builder = new Builder($classes, $optionsBuilder);
    $builder->generate();
} catch (\Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}
