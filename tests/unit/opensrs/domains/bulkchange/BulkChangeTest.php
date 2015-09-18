<?php

use OpenSRS\domains\bulkchange\BulkChange;
/**
 * @group bulkchange
 * @group BulkChange
 */
class BulkChangeTest extends PHPUnit_Framework_TestCase
{
	protected $change_types = array(
		'availability_check' => 'Availability_check',
		'dns_zone' => 'Dns_zone',
		'dns_zone_record' => 'Dns_zone_record',
		'domain_contacts' => 'Domain_contacts',
		'domain_forwarding' => 'Domain_forwarding',
		'domain_lock' => 'Domain_lock',
		'domain_nameservers' => 'Domain_nameservers',
		'domain_parked_pages' => 'Domain_parked_pages',
		'domain_renew' => 'Domain_renew',
		'push_domains' => 'Push_domains',
		'whois_privacy' => 'Whois_privacy'
		);
    protected $validSubmission = array(
        'attributes' => array(
            'change_items' => '',
            'change_type' => '',
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( $this->validSubmission );

        $ns = new BulkChange( 'array', $data );

        $this->assertTrue( $ns instanceof BulkChange );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing change_type' => array('change_type'),
            'missing change_items' => array('change_items'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( $this->validSubmission );

        $data->data->domain_name = "phptest" . time() . ".com";

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new BulkChange( 'array', $data );
    }

    /**
     * Make sure class names are  generated from
     * each change_type correctly and that the
     * classes load without error
     * Correct values stored in $this->change_types
     * array, index is change_type, value is
     * expected class name
     *
     * @group othertests
     *
     * @return void
     */
    public function testLoadingChangeTypeClasses() {
        $data = json_decode( json_encode($this->validSubmission ) );

        $ns = new BulkChange( 'array', $data );

        foreach( $this->change_types as $change_type => $class_name ) {
        	$changeTypeClassName = $ns->getFriendlyClassName( $change_type );
	        $this->assertTrue( $changeTypeClassName == $class_name );
        	$ns->loadChangeTypeClass( $changeTypeClassName );
        }
    }
}
