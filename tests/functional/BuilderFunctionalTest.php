<?php

use Zckrs\GenDocApi\Builder;
use Zckrs\GenDocApi\Entity\OptionsBuilder;

class BuilderFunctionnalTest extends \PHPUnit_Framework_TestCase
{
    // Configuration
    protected $appName = 'Amazing API';
    protected $appDescription = 'This is a amazing API. I think... BTW, enjoy!';
    protected $outputFolder = '/../../web/';
    protected $outputFile = 'index.html';

    /**
     * @var string  This variable contains the generated documentation. Empty if the doc is not generated yet.
     */
    protected $docContent = '';

    protected function setUp()
    {
        $this->generateDoc();
        $this->getDocContent();
    }

    public function testGenerateDoc()
    {
        $this->assertFileExists(__DIR__ . $this->outputFolder . $this->outputFile);
        $this->assertContains(sprintf('<h2>%s</h2>', $this->appName), $this->docContent);
        $this->assertContains(sprintf('<p>%s</p>', $this->appDescription), $this->docContent);
        $this->assertContains('Client', $this->docContent);
        $this->assertContains('GET', $this->docContent);
        $this->assertContains('/api/clients/{id}', $this->docContent);
        $this->assertContains('Status code returned', $this->docContent);
    }

    /**
     * Generates the documentation based on sample classes
     */
    protected function generateDoc()
    {
        $builderOptions = new OptionsBuilder();
        $builderOptions->setApiName($this->appName);
        $builderOptions->setApiDescription($this->appDescription);
        $builderOptions->setOutputFile($this->outputFile);
        $builderOptions->setOutputDir(__DIR__ . $this->outputFolder);
        $builderOptions->setTemplateDir(__DIR__ . '/Resources/views');
        $builderOptions->setAssetDir(__DIR__ . '/Resources/assets');

        try {
            $builder = new Builder(
                array(
                    'Zckrs\GenDocApi\Test\Client'
                ),
                $builderOptions
            );
            $builder->generate();
        } catch (\Exception $e) {
            $this->fail(sprintf('There was an error generating the documentation: %s', $e->getMessage()));
        }
    }

    /**
     * Returns the sample document. Must be already generated.
     *
     * @see self::generateDoc()
     */
    protected function getDocContent()
    {
        $this->docContent = '';
        if (file_exists(__DIR__ . $this->outputFolder . $this->outputFile))
        {
            $this->docContent = file_get_contents(__DIR__ . $this->outputFolder . $this->outputFile);
        }
    }
}
