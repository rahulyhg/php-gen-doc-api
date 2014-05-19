<?php

// Use your autoload
// require __DIR__.'/vendor/autoload.php';

// Or include classe
require_once(__DIR__.'/src/Builder.php');
require_once(__DIR__.'/src/Extractor.php');
require_once(__DIR__.'/../../../../../src/Controller/GetController.php');

use Zckrs\GenDocApi\Builder;

$classes = array(
    'Controller\GetController',
);

try {
    $builder = new Builder($classes);
    $builder->generate();
} catch (\Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}
