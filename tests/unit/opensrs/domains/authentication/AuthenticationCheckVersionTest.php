<?php

use OpenSRS\domains\authentication\AuthenticationCheckVersion;

/**
 * @group authentication
 * @group AuthenticationCheckVersion
 */
class AuthenticationCheckVersionTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'authCheckVersion';

    protected $validSubmission = '{"func":"authCheckVersion"}';

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( $this->validSubmission );

        $ns = new AuthenticationCheckVersion( 'array', $data );

        $this->assertTrue( $ns instanceof AuthenticationCheckVersion );
    }
}
