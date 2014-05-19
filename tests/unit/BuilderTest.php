<?php

use Zckrs\GenDocApi\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Zckrs\GenDocApi\Builder
     */
    protected $builder = null;

    public function setUp()
    {
        $this->builder = new Builder(array('Zckrs\GenDocApi\Test\Client'));
    }

    public function testGetTemplate()
    {
        $layout = $this->builder->getTemplate('layout.html');

        $this->assertContains('php-gen-doc-api', $layout);
        $this->assertContains('Generated on', $layout);
    }

    public function testGetAsset()
    {
        $layout = $this->builder->getAsset('css.css');

        $this->assertContains('body {', $layout);
    }
}
