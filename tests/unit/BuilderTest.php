<?php

use Zckrs\GenDocApi\Builder;
use Zckrs\GenDocApi\Entity\OptionsBuilder;

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
        $layout = $this->builder->getAsset('css/css.css');

        $this->assertContains('body {', $layout);
    }

    public function testGenerate()
    {
        $builderOptions = new OptionsBuilder();
        $builderOptions->setApiName('testApp');
        $builderOptions->setOutputDir('build');
        $builderOptions->setOutputFile('test.html');

        $this->builder = new Builder(array('Zckrs\GenDocApi\Test\Client'), $builderOptions);

        $this->builder->generate();

        $this->assertFileExists('build/test.html');
    }

    /**
     * @expectedException \Exception
     */
    public function testCantCreateDirectory()
    {
        $builderOptions = new OptionsBuilder();
        $builderOptions->setApiName('testApp');
        $builderOptions->setOutputDir('/test');

        $this->builder = new Builder(array('Zckrs\GenDocApi\Test\Client'), $builderOptions);

        $this->builder->generate();
    }

    /**
     * @expectedException \Exception
     */
    public function testCantSaveTheContent()
    {
        $builderOptions = new OptionsBuilder();
        $builderOptions->setApiName('testApp');
        $builderOptions->setOutputDir('build/test');
        $builderOptions->setOutputFile('test.html');

        if (!file_exists($builderOptions->getOutputDir())) {
            mkdir($builderOptions->getOutputDir(), 0600, TRUE);
        }
        $this->builder = new Builder(array('Zckrs\GenDocApi\Test\Client'), $builderOptions);

        $this->builder->generate();
    }
}
