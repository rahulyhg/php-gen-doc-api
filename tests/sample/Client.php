<?php

namespace Zckrs\GenDocApi\Test;

class Client
{
    /**
     * @ApiDescription(section="Client", description="Get one client by ID")
     * @ApiMethod(type="GET")
     * @ApiRoute(name="/api/clients/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="The client ID")
     * @ApiReturnRootSample(sample="{ 'meta': metaObject, 'response': array[responseObject] }")
     *
     * @ApiReturnObject(section="metaObject", name="status", type="string", desc="Status code returned")
     * @ApiReturnObject(section="metaObject", name="msg", type="string", desc="Message to describe status code")
     *
     * @ApiReturnObject(section="responseObject", name="msg", type="array", desc="A array of responseObject (cf section Content)")
     *
     * @throws \Exception
     */
    public function getClient()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }
}
