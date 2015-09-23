<?php

use opensrs\domains\provisioning\ProvisioningActivate;

/**
 * @group provisioning
 * @group ProvisioningActivate
 */
class ProvisioningActivateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provActivate';

    protected $validSubmission = array(
        'cookie' => '',

        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: the .DE domain you want
             *   to activate, required only if
             *   cookie is not sent
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

        $ns = new ProvisioningActivate('array', $data);

        $this->assertTrue($ns instanceof ProvisioningActivate);
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
            '/(cookie|domain).*not.*defined/'
            );

        $ns = new ProvisioningActivate('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsDomainAndCookieSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/cookie and domain.*one call/'
            );

        // setting cookie and domain in the
        // same request
        $data->attributes->domain = $data->cookie;
        $ns = new ProvisioningActivate('array', $data);
        // removing domain
        unset($data->attributes->domain);
    }
}
