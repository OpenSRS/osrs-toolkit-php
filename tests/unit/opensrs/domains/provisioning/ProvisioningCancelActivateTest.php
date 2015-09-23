<?php

use opensrs\domains\provisioning\ProvisioningCancelActivate;

/**
 * @group provisioning
 * @group ProvisioningCancelActivate
 */
class ProvisioningCancelActivateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provCancelActivate';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * order_id: cookie to be deleted
             * domain: the .CA domain you want
             *   to cancel activation for
             */
            'order_id' => '',
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

        // sending request with order_id only
        $data->attributes->order_id = time();
        $ns = new ProvisioningCancelActivate('array', $data);

        $this->assertTrue($ns instanceof ProvisioningCancelActivate);

        // sending request with domain only -- CLASS NOT SET UP TO ACCEPT THIS AS VALID
        $data->attributes->domain = 'phptest'.time().'.ca';
        $ns = new ProvisioningCancelActivate('array', $data);
        $this->assertTrue($ns instanceof ProvisioningCancelActivate);
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
            '/(order_id|domain).*not.*defined/'
            );

        $ns = new ProvisioningCancelActivate('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsDomainAndOrderIdSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->order_id = time();

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/order_id and domain.*one call/'
            );

        $ns = new ProvisioningCancelActivate('array', $data);
    }
}
