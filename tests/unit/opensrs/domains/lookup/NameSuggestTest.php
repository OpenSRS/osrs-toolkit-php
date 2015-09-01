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


        // get selected tlds
        $data->data->nsselected = '.com';
        $ns = new NameSuggest('array', $data);
        $this->assertTrue(array('.com') == $ns->getTlds('nsselected'));
        // unset test value
        unset($data->data->nsselected);

        // test default nsselected
        $ns = new NameSuggest('array', $data);
        $this->assertTrue($ns->defaulttld_nsselected == $ns->getTlds('nsselected'));


        // get lookup choice check
        $data->data->lkselected = '.com';
        $ns = new NameSuggest('array', $data);
        $this->assertTrue(array('.com') == $ns->getTlds('lkselected'));
        // unset test value
        unset($data->data->lkselected);


        // test default lkselected
        $ns = new NameSuggest('array', $data);
        $this->assertTrue($ns->defaulttld_lkselected == $ns->getTlds('lkselected'));


        // Get Default Name Suggestion Choices For No Form Submission
        $data->data->allnsdomains = '.com';
        $ns = new NameSuggest('array', $data);
        $this->assertTrue(array('.com') == $ns->getTlds('allnsdomains'));
        // unset test value
        unset($data->data->allnsdomains);


        // test default allnsdomains
        $ns = new NameSuggest('array', $data);
        $this->assertTrue($ns->defaulttld_allnsdomains == $ns->getTlds('allnsdomains'));


        // Get Default Lookup Choices For No Form Submission
        $data->data->alllkdomains = '.com';
        $ns = new NameSuggest('array', $data);
        $this->assertTrue(array('.com') == $ns->getTlds('alllkdomains'));
        // unset test value
        unset($data->data->alllkdomains);


        // test default alllkdomains
        $ns = new NameSuggest('array', $data);
        $this->assertTrue($ns->defaulttld_alllkdomains == $ns->getTlds('alllkdomains'));
    }
}
