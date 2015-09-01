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
    
}
