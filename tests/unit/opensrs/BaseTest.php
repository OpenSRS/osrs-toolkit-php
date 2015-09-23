<?php

use opensrs\Base;

class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testGetConfiguredTlds()
    {
        // get included default tlds
        $data = (object) array(
            'func' => 'premiumDomain',
            'data' => (object) array(
                'domain' => 'hockey.com',
            ),
        );

        $base = new Base();
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com', '.net', '.org') == $base->getConfiguredTlds());

        // get supplied default tlds
        $data->data->defaulttld = '.com;.net';

        $base = new Base();
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com', '.net') == $base->getConfiguredTlds());

        // get selected tlds
        $data->data->selected = '.com';

        $base = new Base();
        $base->setDataObject('array', $data);
        $this->assertTrue(array('.com') == $base->getConfiguredTlds());
    }

    /**
     * hasDomain should return true if the domain is set
     * and false if it is not set.
     */
    public function testHasDomain()
    {
        $data = (object) array(
            'data' => (object) array(
                'domain' => 'domain',
            ),
        );

        $base = new Base();
        $base->setDataObject('array', $data);
        $this->assertTrue($base->hasDomain());

        $base = new Base();
        $base->setDataObject('array', array());
        $this->assertFalse($base->hasDomain());
    }

    /**
     * getDomain should return the domain from the dataObject.
     */
    public function testGetDomain()
    {
        $data = (object) array(
            'data' => (object) array(
                'domain' => 'domain',
            ),
        );

        $base = new Base();
        $base->setDataObject('array', $data);
        $this->assertEquals($base->getDomain(), 'domain');
    }

    /**
     * Should return correct status of OpenSRS Base socket.
     */
    public function testIsConnected()
    {
        $base = new Base();

        // Should not be connected until we connect
        $this->assertFalse($base->is_connected());

        $this->invokeMethod($base, 'init_socket');

        // now we should be connected
        $this->assertTrue($base->is_connected());
    }

    /**
     * Init socket should either conect to a working host, or report an error.
     */
    // public function testInitSocket()
    // {
    //     $base = new Base();
    //
    //     // a working connection should return true
    //     $this->assertTrue($this->invokeMethod($base, 'init_socket'));
    //
    //     // a bad connection should produce an error 
    //     unset($base);
    //     $this->setExpectedException('PHPUNIT_Framework_Error');
    //     $base = new Base();
    //     $this->invokeMethod($base, 'init_socket', array('xxxxxx'));
    // }

    /**
     * Close socket should close openSRS base socket.
     */
    public function testCloseSocket()
    {
        $base = new Base();

        $this->invokeMethod($base, 'close_socket');

        $this->assertFalse($base->is_connected());
    }

    /**
     * Call a private method for a class.
     * 
     * @param mixed $object     object 
     * @param mixed $methodName methodName 
     * @param array $parameters parameters 
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
