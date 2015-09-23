<?php

use opensrs\domains\bulkchange\BulkChange;

/**
 * @group bulkchange
 * @group BulkChange
 */
class BulkChangeTest extends PHPUnit_Framework_TestCase
{
    protected $change_types = array(
        'availability_check' => 'AvailabilityCheck',
        'dns_zone' => 'DnsZone',
        'dns_zone_record' => 'DnsZoneRecord',
        'domain_contacts' => 'DomainContacts',
        'domain_forwarding' => 'DomainForwarding',
        'domain_lock' => 'DomainLock',
        'domain_nameservers' => 'DomainNameservers',
        'domain_parked_pages' => 'DomainParkedPages',
        'domain_renew' => 'DomainRenew',
        'push_domains' => 'PushDomains',
        'whois_privacy' => 'WhoisPrivacy',
        );
    protected $validSubmission = array(
        'attributes' => array(
            'change_items' => '',
            'change_type' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     * @group bulkchangevalidsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->change_type = 'availability_check';
        $data->attributes->change_items = 'phptest'.time().'.com,'.
                                          'phptest'.time().'.net';

        $ns = new BulkChange('array', $data);

        $this->assertTrue($ns instanceof BulkChange);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing change_type' => array('change_type'),
            'missing change_items' => array('change_items'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->change_type = 'availability_check';
        $data->attributes->change_items = 'phptest'.time().'.com,'.
                                          'phptest'.time().'.net';

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new BulkChange('array', $data);
    }

    /**
     * Make sure class names are  generated from
     * each change_type correctly and that the
     * classes load without error
     * Correct values stored in $this->change_types
     * array, index is change_type, value is
     * expected class name.
     *
     * @group othertests
     */
    public function testLoadingChangeTypeClasses()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->attributes->change_type = 'availability_check';
        $data->attributes->change_items = 'phptest'.time().'.com,'.
                                          'phptest'.time().'.net';

        $ns = new BulkChange('array', $data, false, false);

        foreach ($this->change_types as $change_type => $class_name) {
            $changeTypeClassName = $ns->getFriendlyClassName($change_type);

            $this->assertTrue($changeTypeClassName == $class_name);

            $fullClassName = "opensrs\\domains\\bulkchange\\changetype\\$changeTypeClassName";
            $changeTypeClass = $ns->loadChangeTypeClass($change_type);

            $this->assertTrue($changeTypeClass instanceof $fullClassName);
        }
    }
}
