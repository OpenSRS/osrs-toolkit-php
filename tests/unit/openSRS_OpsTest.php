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

        $this->assertFalse($ops->_is_assoc($no));
        $this->assertTrue($ops->_is_assoc($yes));
    }

    /**
     * Should convert php array to formmated xml
     * 
     * @return void
     */
    public function testPhp2Xml()
    {
        $ops = new openSRS_ops;
        $data = array('convert' => 'this');
        $result = $ops->PHP2XML($data);
       
        $this->assertEquals($result, "  <data_block>\n   <dt_assoc>\n   <item key=\"convert\">this</item>\n   </dt_assoc>\n  </data_block>"); 
    }

    /**
     * Should convert php arrays to valid xml recursivly
     * 
     * @return void
     */
    public function testConvertData()
    {
        $ops = new openSRS_ops;
        $data = array('please' => 'convert', 'me');

        $result = $ops->_convertData($data);

        $xml = XMLReader::xml($result);

        // The validate parser option must be enabled for 
        // this method to work properly
        $xml->setParserProperty(XMLReader::VALIDATE, true);

        // make sure this is xml
        $this->assertTrue($xml->isValid());
    }

    /**
     * Should convert php arrays to valid xml
     * 
     * @return void
     */
    public function testEncode()
    {
        $ops = new openSRS_ops;
        $data = array('protocol' => '', 'action' => '', 'object' => '');

        $result = $ops->encode($data);

        $xml = XMLReader::xml($result);

        // The validate parser option must be enabled for 
        // this method to work properly
        $xml->setParserProperty(XMLReader::VALIDATE, true);

        // make sure this is xml
        $this->assertTrue($xml->isValid());
    }
}
