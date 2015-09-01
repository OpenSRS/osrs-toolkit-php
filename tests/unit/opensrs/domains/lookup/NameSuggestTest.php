<?php

use OpenSRS\domains\lookup\NameSuggest;

class NameSuggestTest extends PHPUnit_Framework_TestCase
{
    /**
     * New NameSuggest should throw an exception if 
     * data->domain is ommitted 
     * 
     * @return void
     */
    public function testValidateMissingDomain()
    {
        $data = (object) array (
            'func' => 'lookupNameSuggest',
            'data' => (object) array (
                // 'domain' => 'hockey.com'
                ),
            );

        $this->setExpectedException('OpenSRS\Exception');
        $ns = new NameSuggest('array', $data);
    }

    /**
     * Get TLD function should return either the selected tlds,
     * or a default set
     * 
     * @return void
     */
    public function testGetTlds()
    {
        // get included default tlds
        $data = (object) array (
            'func' => 'lookupNameSuggest',
            'data' => (object) array (
                'domain' => 'hockey.com',
                ),
            );



        // test default tlds
        $ns = new NameSuggest('array', $data);
        $expectedResult = array(
            "lookup" => array(
                "tlds" => $ns->defaulttld_allnsdomains
                ),
            "suggestion" => array(
                "tlds" => $ns->defaulttld_alllkdomains
                )
            );
        $this->assertTrue($expectedResult == $ns->getTlds());



        // get selected tlds, specify only lookup tlds
        $data->data->nsselected = '.com';
        $ns = new NameSuggest('array', $data);
        $expectedResult = array(
            "lookup" => array(
                "tlds" => array( '.com' )
                ),
            "suggestion" => array(
                "tlds" => $ns->defaulttld_alllkdomains
                )
            );
        $this->assertTrue($expectedResult == $ns->getTlds());
        // unset test value
        unset($data->data->nsselected);




        // get selected tlds, specify suggestion tlds
        $data->data->alllkdomains = '.com;.net';
        $ns = new NameSuggest('array', $data);
        $expectedResult = array(
            "lookup" => array(
                "tlds" => $ns->defaulttld_allnsdomains
                ),
            "suggestion" => array(
                "tlds" => array( '.com', '.net' )
                )
            );
        $this->assertTrue($expectedResult == $ns->getTlds());
        // unset test value
        unset($data->data->alllkdomains);




        // get selected tlds, specify both lookup and suggestion tlds
        $data->data->nsselected = '.org';
        $data->data->alllkdomains = '.com;.net';
        $ns = new NameSuggest('array', $data);
        $expectedResult = array(
            "lookup" => array(
                "tlds" => array( '.org' )
                ),
            "suggestion" => array(
                "tlds" => array( '.com', '.net' )
                )
            );
        $this->assertTrue($expectedResult == $ns->getTlds());
        // unset test value
        unset($data->data->nsselected);
        unset($data->data->alllkdomains);
    }
}
