<?php

use opensrs\Ops;

class OpsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should convert specials chars, & encode in utf8.
     */
    public function testQuoteXMLChars()
    {
        $ops = new Ops();
        $data = 'This is my & < > \' " string';
        $result = $ops->_quoteXMLChars($data);

        /// chars should be converted
        $this->assertEquals($result, 'This is my &amp; &lt; &gt; &apos; &quot; string');

        // should be utf8
        $this->assertTrue(mb_check_encoding($result, 'UTF-8'));
    }

    /**
     * Should return true for associative, and false for plain.
     */
    public function testIsAssoc()
    {
        $ops = new Ops();
        $no = array(1, 2, 3, 4);
        $yes = array('this' => 'is', 'associative');

        $this->assertFalse($ops->_is_assoc($no));
        $this->assertTrue($ops->_is_assoc($yes));
    }

    /**
     * Should convert php array to formmated xml.
     */
    public function testPhp2Xml()
    {
        $ops = new Ops();
        $data = array('convert' => 'this');
        $result = $ops->PHP2XML($data);

        $this->assertEquals($result, "  <data_block>\n   <dt_assoc>\n   <item key=\"convert\">this</item>\n   </dt_assoc>\n  </data_block>");
    }

    /**
     * Should convert php arrays to valid xml recursivly.
     */
    public function testConvertData()
    {
        $ops = new Ops();
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
     * Should convert php arrays to valid xml.
     */
    public function testEncode()
    {
        $ops = new Ops();
        $data = array('protocol' => '', 'action' => '', 'object' => '');

        $result = $ops->encode($data);

        $xml = XMLReader::xml($result);

        // The validate parser option must be enabled for 
        // this method to work properly
        $xml->setParserProperty(XMLReader::VALIDATE, true);

        // make sure this is xml
        $this->assertTrue($xml->isValid());
    }

    /**
     * should convert xml to php array.
     */
    public function testXml2Php()
    {
        $ops = new Ops();
        $data = array('convert' => 'this');

        // use our built in php to xml to test
        $result = $ops->PHP2XML($data);

        // converting back, they should be the same
        $this->assertSame($data, $ops->XML2PHP($result));
    }
}
