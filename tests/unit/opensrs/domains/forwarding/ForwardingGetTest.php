<?php

use opensrs\domains\forwarding\ForwardingGet;

/**
 * @group forwarding
 * @group ForwardingGet
 */
class ForwardingGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdGet';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * bypass: relevant domain, required
             *   only if cookie is not sent
             */
            'cookie' => '',
            'bypass' => '',

            /*
             * Required
             *
             * domain: relevant domain
             */
            'domain' => '',
            ),
        );

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

        $data->cookie = md5(time());

        $ns = new ForwardingGet('array', $data);

        $this->assertTrue($ns instanceof ForwardingGet);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/(domain|cookie).*not defined/'
            );

        $ns = new ForwardingGet('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsCookieAndBypassSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';

        $this->setExpectedExceptionRegExp(
          'opensrs\Exception',
        '/.*cookie.*domain.*cannot.*one.*call.*/'
          );

        $ns = new ForwardingGet('array', $data);
    }
}
