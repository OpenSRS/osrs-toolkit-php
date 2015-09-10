<?php

use OpenSRS\domains\cookie\CookieQuit;
/**
 * @group cookie
 * @group CookieQuit
 */
class CookieQuitTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'cookieQuit';

    // no additional parameters required
    // as quit action is not authenticated
    protected $validSubmission = array();

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $ns = new CookieQuit( 'array', $data );

        $this->assertTrue( $ns instanceof CookieQuit );
    }
}
