<?php

use opensrs\domains\authentication\AuthenticationCheckVersion;

/**
 * @group authentication
 * @group AuthenticationCheckVersion
 */
class AuthenticationCheckVersionTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'authCheckVersion';

    protected $validSubmission = array();

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $ns = new AuthenticationCheckVersion('array', $data);

        $this->assertTrue($ns instanceof AuthenticationCheckVersion);
    }
}
