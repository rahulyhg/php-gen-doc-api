<?php

use Zckrs\GenDocApi\Extractor;

class ExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Zckrs\GenDocApi\Extractor
     */
    protected $extractor = null;

    public function setUp()
    {
        $this->extractor = new Extractor();
    }

    public function testGetClassAnnotations()
    {
        $annotations = $this->extractor->getClassAnnotations('Zckrs\GenDocApi\Test\Client');
        $this->assertCount(0, $annotations);
    }

    public function testGetAllClassAnnotations()
    {
        $annotations = $this->extractor->getAllClassAnnotations('Zckrs\GenDocApi\Test\Client');

        $this->assertCount(1, $annotations, 'Number of Client methods');
        $this->assertArrayHasKey('Zckrs\GenDocApi\Test\Client', $annotations);
        $this->assertArrayHasKey('get', $annotations['Zckrs\GenDocApi\Test\Client']);

        $this->assertCount(
            5,
            $annotations['Zckrs\GenDocApi\Test\Client']['get'],
            'Number of annotation for the get method'
        );

        $this->assertCount(
            1,
            $annotations['Zckrs\GenDocApi\Test\Client']['get']['ApiDescription'],
            'Number of ApiDescription annotations for the get method'
        );

        $this->assertCount(
            1,
            $annotations['Zckrs\GenDocApi\Test\Client']['get']['ApiDescription'],
            'Number of ApiDescription annotations for the get method'
        );

        $this->assertArrayHasKey(
            'section',
            $annotations['Zckrs\GenDocApi\Test\Client']['get']['ApiDescription'][0],
            'The "section" attribute for get/ApiDescription annotation exists'
        );

        $this->assertArrayHasKey(
            'description',
            $annotations['Zckrs\GenDocApi\Test\Client']['get']['ApiDescription'][0],
            'The "description" attribute for get/ApiDescription annotation exists'
        );
    }

    public function testGetMethodAnnotations()
    {
        $annotations = $this->extractor->getMethodAnnotations('Zckrs\GenDocApi\Test\Client', 'get');

        $this->assertCount(5, $annotations, 'Number of get annotations');

        $this->assertArrayHasKey('ApiDescription', $annotations, 'get have an ApiDocumentation annotation');

        $this->assertArrayHasKey(
            'type',
            $annotations['ApiReturnObject'][0],
            'The "type" attribute for get/ApiReturnObject annotation exists'
        );

    }

    public function testGetMethodAnnotationsObjects()
    {
        $annotations = $this->extractor->getMethodAnnotationsObjects('Zckrs\GenDocApi\Test\Client', 'get');

        $this->assertCount(0, $annotations, 'Number of get object annotations');

    }
}
