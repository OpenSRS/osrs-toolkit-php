<?php

require_once(__DIR__ . '/../../opensrs/openSRS_loader.php');

class openSRS_LoaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should give an exception when data is ommited 
     */
    public function testloadNoData()
    {
        $this->setExpectedException('PHPUNIT_Framework_Error');
        
        processOpenSRS('json', array());
    }
}
