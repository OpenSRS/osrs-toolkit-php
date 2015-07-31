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
        processOpenSRS('array');
    }

    /**
     * Should give an exception when func does not exist
     * 
     */
    public function testloadFunctionNotFound()
    {
        $this->setExpectedException('PHPUNIT_Framework_Error');
        processOpenSRS('array', array('func' => 'xxx', 'data' => array()));
    }

    /**
     * processOpenSRS should return an object of 
     * the requested function name
     * 
     * @return void
     */
    public function testProcess()
    {
        $data = array(
            'func' => 'premiumDomain',
            'data' => array(
                'domain' => 'hockey.com',
                'selected' => '.com',
                'alldomains' => '.com'
            )
        );

        $this->assertInstanceOf(
            $data['func'],
            processOpenSRS('array', $data)
        );
    }
}
