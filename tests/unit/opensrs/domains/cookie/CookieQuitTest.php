<?php

use opensrs\domains\cookie\CookieQuit;
use opensrs\Request;

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
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data['func'] = $this->func;

        $ns = new CookieQuit('array', $data);

        $this->assertTrue($ns instanceof CookieQuit);
    }

    /**
     * Valid submission should complete with no
     * exception thrown. This test runs the call
     * through the RequestFactory.
     */
    public function testValidSubmissionRequestFatory()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data['func'] = $this->func;

        $request = new Request();
        $ns = $request->process('array', $data);

        $this->assertTrue($ns instanceof CookieQuit);
    }
}
