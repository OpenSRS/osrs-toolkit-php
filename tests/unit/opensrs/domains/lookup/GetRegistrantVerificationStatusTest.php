<?php

use opensrs\domains\lookup\GetRegistrantVerificationStatus;
use opensrs\Exception;

class GetRegistrantVerificationStatusTest extends PHPUnit_Framework_TestCase
{
    /**
     * Should return a GetRegistrantVerificationStatus
     * as long as domain is set.
     */
    public function testValidSubmission()
    {
        $data = (object) array(
            'attributes' => (object) array(
                'domain' => 'google.com',
            ),
        );

        $request = new GetRegistrantVerificationStatus('array', $data);
        $this->assertTrue($request instanceof GetRegistrantVerificationStatus);

        $data = (object) array(
            'attributes' => (object) array(
            ),
        );
        $this->setExpectedException('Exception');
        $request = new GetRegistrantVerificationStatus('array', $data);
    }
}
