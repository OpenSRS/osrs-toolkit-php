<?php

require_once __DIR__.'/../../opensrs/openSRS_loader.php';
require_once __DIR__.'/../../opensrs/openSRS_base.php';
require_once __DIR__.'/../../opensrs/openSRS_ops.php';

class openSRS_BaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should return correct status of OpenSRS Base socket.
     */
    public function testIsConnected()
    {
        $base = new openSRS_base();

        // Should not be connected until we connect
        $this->assertFalse($base->is_connected());

        $this->invokeMethod($base, 'init_socket');

        // now we should be connected
        $this->assertTrue($base->is_connected());
    }

    /**
     * Init socket should either conect to a working host, or report an error.
     */
    public function testInitSocket()
    {
        $base = new openSRS_base();

        // a working connection should return true
        $this->assertTrue($this->invokeMethod($base, 'init_socket'));

        // a bad connection should produce an error 
        unset($base);
        $this->setExpectedException('PHPUNIT_Framework_Error');
        $base = new openSRS_base();
        $this->invokeMethod($base, 'init_socket', array('xxxxxx'));
    }

    /**
     * Close socket should close openSRS base socket.
     */
    public function testCloseSocket()
    {
        $base = new openSRS_base();

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
