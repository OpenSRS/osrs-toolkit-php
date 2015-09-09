<?php

use OpenSRS\domains\bulkchange\BulkTransfer;
/**
 * @group bulkchange
 * @group BulkTransfer
 */
class BulkTransferTest extends PHPUnit_Framework_TestCase
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
    protected $validSubmission = '{"func":"bulkSubmit","personal":{"first_name":"Claire","last_name":"Lam","org_name":"Tucows","address1":"96 Mowat Avenue","address2":"","address3":"","city":"Toronto","state":"ON","postal_code":"M6K 3M1","country":"CA","phone":"416-535-0123 x1386","fax":"","email":"clam@tucows.com","url":"http:\/\/www.tucows.com","lang_pref":"EN"},"data":{"registrant_ip":"","affiliate_id":"","reg_username":"clam","reg_domain":"","reg_password":"abc123","custom_tech_contact":"","handle":"","domain_list":"phptest.com,phptest2.com,phptest3.com","change_type":"availability_check","op_type":"export","custom_tech_contact":"clam@tucows.com"}}';

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( $this->validSubmission );

        $ns = new BulkTransfer( 'array', $data );

        $this->assertTrue( $ns instanceof BulkTransfer );
    }

    /**
     * Testing invalid submission should fail and
     * throw exception as required fields are missing
     *
     * @return void
     */
    public function testSubmissionMissingFields() {
        $data = json_decode( $this->validSubmission );
        unset( $data->data->reg_password );

        $this->setExpectedException( 'OpenSRS\Exception' );
        $ns = new BulkTransfer( 'array', $data );

        unset( $data->data->reg_username );
        $this->setExpectedException( 'OpenSRS\Exception' );
        $ns = new BulkTransfer( 'array', $data );

        unset( $data->data->domain_list );
        $this->setExpectedException( 'OpenSRS\Exception' );
        $ns = new BulkTransfer( 'array', $data );

        unset( $data->data->custom_tech_contact );
        $this->setExpectedException( 'OpenSRS\Exception' );
        $ns = new BulkTransfer( 'array', $data );
    }
}
