<?php

use OpenSRS\Base;

class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testGetConfiguredTlds()
    {
        // get included default tlds
        $data = (object) array (
            'func' => 'premiumDomain',
            'data' => (object) array (
                'domain' => 'hockey.com',
            ),
        );

        $base = new Base;
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com', '.net', '.org') == $base->getConfiguredTlds());

        // get supplied default tlds
        $data->data->defaulttld = '.com;.net';

        $base = new Base;
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com', '.net') == $base->getConfiguredTlds());


        // get selected tlds
        $data->data->selected = '.com';

        $base = new Base;
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com') == $base->getConfiguredTlds());
    }

    /**
     * hasDomain should return true if the domain is set
     * and false if it is not set
     * 
     */
    public function testHasDomain()
    {
        $data = (object) array(
            'data' => (object) array(
                'domain' => 'domain'
            )
        );

        $base = new Base;
        $base->setDataObject('array', $data);
        $this->assertTrue($base->hasDomain());

        $base = new Base;
        $base->setDataObject('array', array());
        $this->assertFalse($base->hasDomain());
    }

    /**
     * getDomain should return the domain from the dataObject
     * 
     */
    public function testGetDomain()
    {
        $data = (object) array(
            'data' => (object) array(
                'domain' => 'domain'
            )
        );

        $base = new Base;
        $base->setDataObject('array', $data);
        $this->assertEquals($base->getDomain(), 'domain');
    }
}
