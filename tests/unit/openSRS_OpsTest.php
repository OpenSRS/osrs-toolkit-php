<?php

require_once(__DIR__ . '/../../opensrs/openSRS_loader.php');

class openSRS_OpsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should convert specials chars, & encode in utf8
     * 
     * @return void
     */
    public function testQuoteXMLChars()
    {
        $ops = new openSRS_ops;
        $data = 'This is my & < > \' " string';
        $result = $ops->_quoteXMLChars($data);

        /// chars should be converted
        $this->assertEquals($result, 'This is my &amp; &lt; &gt; &apos; &quot; string');

        // should be utf8
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    /**
     * Should return true for associative, and false for plain
     * 
     * @return void
     */
    public function testIsAssoc()
    {
        $ops = new openSRS_ops;
        $no = array(1, 2, 3, 4);
        $yes = array('this' => 'is', 'associative');

        $this->assertfalse($ops->_is_assoc($no));
        $this->assertTrue($ops->_is_assoc($yes));
    }
}
