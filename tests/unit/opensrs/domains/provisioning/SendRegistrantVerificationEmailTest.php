<?php

use opensrs\domains\provisioning\SendRegistrantVerificationEmail;

class SendRegistrantVerificationEmailTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'domain' => ''
        ) 
    );

    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';

        $sendVerify = new SendRegistrantVerificationEmail('array', $data);

        $this->assertTrue($sendVerify instanceof SendRegistrantVerificationEmail);
    }
}
