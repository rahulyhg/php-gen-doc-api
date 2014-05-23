<?php

namespace Zckrs\GenDocApi\Test;

class Document
{
    /**
     * @ApiMethod(type="GET")
     * @ApiRoute(url="/api/documents/{id}")
     * @ApiDescription(section="Document", description="Get one document by ID")
     * @ApiParams(name="id", type="integer", nullable=false, description="The document ID", sample="6684516529217")
     * @ApiReturnRootSample(sample="{ 'nameDocument': documentObject }")
     *
     * @ApiReturnObject(section="documentObject", name="id", type="number", desc="A serie of 13 numbers.")
     * @ApiReturnObject(section="documentObject", name="title", type="string", desc="The title of document.", note="optional")
     * @ApiReturnObject(section="documentObject", name="content", type="string", desc="Content of document.")
     * @ApiReturnObject(section="documentObject", name="authors", type="array", desc="Array of authors.", link="authorObject")
     *
     * @ApiReturnObject(section="authorObject", name="firstname", type="string")
     * @ApiReturnObject(section="authorObject", name="lastname", type="string")
     *
     * @throws \Exception
     */
    public function get()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }

    /**
     * @ApiMethod(type="PUT")
     * @ApiRoute(url="/api/documents/put/{id}")
     * @ApiDescription(section="Document", description="Put a document.")
     * @ApiParams(name="id", type="integer", nullable=false, description="The document ID", sample="2489516529217")
     *
     * @throws \Exception
     */
    public function put()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }
}
