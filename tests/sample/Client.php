<?php

namespace Zckrs\GenDocApi\Test;

class Client
{
    /**
     * @ApiMethod(type="GET")
     * @ApiRoute(url="/api/clients")
     * @ApiDescription(section="Client", description="Get one client by ID")
     * @ApiReturnRootSample(sample="{ 'meta': metaObject, 'response': array[clientObject] }")
     *
     * @ApiReturnObject(section="metaObject", name="status", type="string", desc="Status code returned")
     * @ApiReturnObject(section="metaObject", name="msg", type="string", desc="Message to describe status code")
     *
     * @ApiReturnObject(section="clientObject", name="id", type="integer", desc="ID client")
     */
    public function get()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }

    /**
     * @ApiMethod(type="POST")
     * @ApiRoute(url="/api/clients/post/{id}")
     * @ApiDescription(section="Client", description="Post profile information")
     * @ApiParams(name="id", type="integer", nullable=false, description="The client ID")
     * @ApiParams(name="form", type="object", nullable=false, description="Form to modify client", sample="{ 'name':'ABCD', 'email':'abcd@gmail.com' }")
     * @ApiReturnRootSample(sample="{ 'nameClient': responseObject }")
     *
     * @ApiReturnObject(section="responseObject", name="id", type="integer", desc="")
     * @ApiReturnObject(section="responseObject", name="name", type="string", desc="You can use HTML <img alt='nyancat' width='40' height='28' src='http://24.media.tumblr.com/tumblr_lrzr21KKoO1qjngfmo1_400.gif'>")
     */
    public function post()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }

    /**
     * @ApiMethod(type="DELETE")
     * @ApiRoute(url="/api/clients/delete/{id}")
     * @ApiDescription(section="Client", description="Delete one client by ID")
     * @ApiParams(name="id", type="integer", nullable=false, description="The client ID")
     *
     * @ApiReturnObject(section="metaObject", name="status", type="string", desc="Status code returned")
     * @ApiReturnObject(section="metaObject", name="msg", type="string", desc="Message to describe status code")
     *
     * @ApiReturnObject(section="clientObject", name="id", type="integer", desc="ID client")
     */
    public function delete()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }

    /**
     * @ApiMethod(type="PUT")
     * @ApiRoute(url="/api/clients/delete/{id}")
     * @ApiParams(name="id", type="integer", nullable=false, description="The client ID")
     */
    public function put()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }

    public function noAnnotations()
    {
        throw new \Exception('Oh, this class is just here to perform functional tests!');
    }
}
