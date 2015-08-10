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
}
