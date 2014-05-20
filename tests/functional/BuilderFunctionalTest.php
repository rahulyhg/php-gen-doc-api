<?php

use Zckrs\GenDocApi\Builder;

class BuilderFunctionnalTest extends \PHPUnit_Framework_TestCase
{
    // Configuration
    protected $outputFolder = '/../../web/';
    protected $outputFile = 'index.html';

    /**
     * @var string  This variable contains the generated documentation. Empty is the doc is not generated.
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
        $this->assertContains('<title>php-gen-doc-api v1.4</title>', $this->docContent);
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
        try {
            $builder = new Builder(
                array(
                    'Zckrs\GenDocApi\Test\Client'
                ),
                array(
                    'output_file'  => $this->outputFile,
                    'output_dir'   => __DIR__ . $this->outputFolder,
                    'template_dir' => __DIR__ . '/Resources/views',
                    'asset_dir'    => __DIR__ . '/Resources/assets',
                )
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
