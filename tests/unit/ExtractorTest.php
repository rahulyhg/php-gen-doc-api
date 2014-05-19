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
        $this->assertArrayHasKey('getClient', $annotations['Zckrs\GenDocApi\Test\Client']);

        $this->assertCount(
            6,
            $annotations['Zckrs\GenDocApi\Test\Client']['getClient'],
            'Number of annotation for the getClient method'
        );

        $this->assertCount(
            1,
            $annotations['Zckrs\GenDocApi\Test\Client']['getClient']['ApiDescription'],
            'Number of ApiDescription annotations for the getClient method'
        );

        $this->assertCount(
            1,
            $annotations['Zckrs\GenDocApi\Test\Client']['getClient']['ApiDescription'],
            'Number of ApiDescription annotations for the getClient method'
        );

        $this->assertArrayHasKey(
            'section',
            $annotations['Zckrs\GenDocApi\Test\Client']['getClient']['ApiDescription'][0],
            'The "section" attribute for getClient/ApiDescription annotation exists'
        );

        $this->assertArrayHasKey(
            'description',
            $annotations['Zckrs\GenDocApi\Test\Client']['getClient']['ApiDescription'][0],
            'The "description" attribute for getClient/ApiDescription annotation exists'
        );
    }

    public function testGetMethodAnnotations()
    {
        $annotations = $this->extractor->getMethodAnnotations('Zckrs\GenDocApi\Test\Client', 'getClient');

        $this->assertCount(6, $annotations, 'Number of getClient annotations');

        $this->assertArrayHasKey('ApiDescription', $annotations, 'getClient have an ApiDocumentation annotation');

        $this->assertArrayHasKey(
            'type',
            $annotations['ApiReturnObject'][0],
            'The "type" attribute for getClient/ApiReturnObject annotation exists'
        );


        $this->assertArrayHasKey(
            'nullable',
            $annotations['ApiParams'][0],
            'The "nullable" attribute for getClient/ApiDescription annotation exists'
        );
    }

    public function testGetMethodAnnotationsObjects()
    {
        $annotations = $this->extractor->getMethodAnnotationsObjects('Zckrs\GenDocApi\Test\Client', 'getClient');

        $this->assertCount(0, $annotations, 'Number of getClient object annotations');

    }
}
