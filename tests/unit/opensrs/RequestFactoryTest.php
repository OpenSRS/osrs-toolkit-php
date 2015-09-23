<?php

use opensrs\RequestFactory;

class RequestFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * An unknown request should throw an error.
     */
    public function testBuildDefault()
    {
        $this->setExpectedException("opensrs\Exception");
        RequestFactory::build('', '', '');
    }

    public function testBuild()
    {
        // premium domain request should build us a PremiumDomain
        $data = (object) array(
            'func' => 'premiumDomain',
            'data' => (object) array(
                'domain' => 'google.com',
                'selected' => '.com;.net;.org',
                'alldomains' => '.com;.net;.org',
            ),
        );

        $pd = RequestFactory::build('premiumDomain', 'array', $data);
        $this->assertTrue($pd instanceof opensrs\domains\lookup\PremiumDomain);
    }
}
