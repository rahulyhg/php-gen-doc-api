<?php

// Use autoload
// require __DIR__.'/../../autoload.php';

// Or include classes
require_once(__DIR__.'/src/Builder.php');
require_once(__DIR__.'/src/Extractor.php');
require_once(__DIR__.'/tests/sample/Client.php');

use Zckrs\GenDocApi\Builder;

// Define classes to search annotations
$classes = array(
    'Zckrs\GenDocApi\Test\Client',
);

try {
    $builder = new Builder($classes,
        array(
            'output_file'  => 'index.html',
            'output_dir'   => __DIR__.'/web',
            'template_dir' => __DIR__.'/Resources/views',
            'asset_dir'    => __DIR__.'/Resources/assets',
        )
    );
    $builder->generate();
} catch (\Exception $e) {
    echo 'There was an error generating the documentation: ', $e->getMessage();
}
