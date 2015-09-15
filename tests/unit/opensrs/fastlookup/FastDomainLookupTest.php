<?php

use OpenSRS\fastlookup\FastDomainLookup;

class FastDomainLookupTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should throw an exception if domain is ommited
     * 
     */
    public function testMissingDomain()
    {
	    $data = (object) array (
		    "func" => 'fastDomainLookup',
		    "data" => (object) array (
		    )
	    );

        try {
            $fl = new FastDomainLookup('array', $data);

        } catch (Exception $e) {
            $this->assertTrue($e instanceof OpenSRS\Exception);
            $this->assertEquals(
                $e->getMessage(), 
                'oSRS Error - Search domain string not defined.'
            );
        }
    }

    /**
     * Should throw an exception if selected tlds is missing
     * 
     */
    public function testMissingSelected()
    {
	    $data = (object) array (
		    "func" => 'fastDomainLookup',
		    "data" => (object) array (
                'domain' => 'google.com'
		    )
	    );

        try {
            $fl = new FastDomainLookup('array', $data);

        } catch (Exception $e) {
            $this->assertTrue($e instanceof OpenSRS\Exception);
            $this->assertEquals(
                $e->getMessage(), 
                'oSRS Error - Selected domains are not defined.'
            );
        }
    }

    /**
     * Should throw an exception if all domains tlds is missing
     * 
     */
    public function testMissingAllDomains()
    {
	    $data = (object) array (
		    "func" => 'fastDomainLookup',
		    "data" => (object) array (
                'domain' => 'google.com',
                'selected' => '.com;.net',
                'allDomains' => '.com;.net;.org'
		    )
	    );

        try {
            $fl = new FastDomainLookup('array', $data);

        } catch (Exception $e) {
            $this->assertTrue($e instanceof OpenSRS\Exception);
            $this->assertEquals(
                $e->getMessage(), 
                'oSRS Error - All domain strinng not defined.'
            );
        }
    }
}
