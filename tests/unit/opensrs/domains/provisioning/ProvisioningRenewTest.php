<?php

use opensrs\domains\provisioning\ProvisioningRenew;

/**
 * @group provisioning
 * @group ProvisioningRenew
 */
class ProvisioningRenewTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'provRenew';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * auto_renew: flag indicating whether the
             *   domain sh9ould auto-renew. values:
             *     - 0 = no auto-renew
             *     - 1 = auto-renew enabled
             * currentexpirationyear: domain's current
             *   expiration year, format YYYY; must match
             *   data in the registry
             * domain: name of the domain to be renewed,
             *   domain must be registered and exist in
             *   both OpenSRS and the appropriate registry
             * handle: instructions for processing the order,
             *   overrides RSP's 'process immediately' setting
             *   values:
             *     - save = pend order for RSP's later
             *              approval
             *     - process = process order immediately
             * period: renewal period, from 1 to 10 years,
             *   may not exceed 10 years
             */
            'auto_renew' => '',
            'currentexpirationyear' => '',
            'domain' => '',
            'handle' => '',
            'period' => '',

            /*
             * Optional
             *
             * affiliate_id: ID that allows RSPs to track
             *   orders coming through various affiliates
             * f_parkp: enable Parked Pages Program. note
             *   enabling Parked Pages changes the nameservers
             *   of that domain. values:
             *     - Y = enable
             *     - N = do not enable
             *
             *   available for the following TLDs:
             *     .COM, .NET, .ORG, .INFO, .BIZ, .MOBI,
             *     .NAME, .ASIA, .BE, .BZ, .CA, .CC, .CO,
             *     .EU, .IN, .ME, .NL, .TV, .UK, .US,
             *     .WS, .XXX
             */
             'affiliate_id' => '',
             'f_parkp' => '',
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

        $data->attributes->auto_renew = 'Y';
        $data->attributes->currentexpirationyear = date('Y');
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->handle = 'save';
        $data->attributes->period = '1';

        $ns = new ProvisioningRenew('array', $data);

        $this->assertTrue($ns instanceof ProvisioningRenew);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing period' => array('domain'),
            'missing handle' => array('handle'),
            'missing domain' => array('domain'),
            'missing currentexpirationyear' => array('currentexpirationyear'),
            'missing auto_renew' => array('auto_renew'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes')
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->auto_renew = 'Y';
        $data->attributes->currentexpirationyear = date('Y');
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->handle = 'save';
        $data->attributes->period = '1';

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            "/$field.*not defined/"
            );

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new ProvisioningRenew('array', $data);
    }
}
