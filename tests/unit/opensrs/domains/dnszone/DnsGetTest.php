<?php

use OpenSRS\domains\dnszone\DnsGet;
/**
 * @group dnszone
 * @group DnsGet
 */
class DnsGetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'cookieDelete';

    protected $validSubmission = '{"func":"provSWregister","personal":{"first_name":"John","last_name":"Smith","org_name":"Tucows","address1":"96 Mowat Avenue","address2":"","address3":"","city":"Toronto","state":"ON","postal_code":"M6K 3M1","country":"CA","phone":"+1.4165350123","fax":"","email":"phptoolkit@tucows.com","url":"http:\/\/www.tucows.com","lang_pref":"en"},"cedinfo":{"contact_type":"owner","id_number":"Pasport number","id_type":"passport","id_type_info":"","legal_entity_type":"naturalPerson","legal_entity_type_info":"","locality_city":"","locality_country":"","locality_state_prov":""},"nexus":{"app_purpose":"","category":"","validator":""},"it_registrant_info":{"nationality_code":"","reg_code":"SGLMRA80A01H501E","entity_type":"1"},"au_registrant_info":{"registrant_name":"Registered Company Name Ltd","registrant_id":"99 999 999 999","registrant_id_type":"ABN","eligibility_type":"Registered Business","eligibility_id":"99999999","eligibility_id_type":"ACN","eligibility_name":"Don Marshall CTO"},"professional_data":{"authority":"Canadian Dental Associatio","authority_website":"http:\/\/www.cda-adc.ca","license_number":"123456789","profession":"Dentist"},"br_registrant_info":{"br_register_number":""},"data":{"affiliate_id":"","auto_renew":"0","ca_link_domain":"","change_contact":"","custom_nameservers":"1","custom_tech_contact":"0","custom_transfer_nameservers":"","cwa":"","dns_template":"","domain":"phptest1441136165.com","domain_description":"","encoding_type":"","eu_country":"gb","f_lock_domain":"1","f_parkp":"Y","f_whois_privacy":"1","forwarding_email":"","handle":"","isa_trademark":"0","lang":"en","lang_pref":"en","legal_type":"CCT","link_domains":"0","master_order_id":"","name1":"ns1.systemdns.com","name2":"ns2.systemdns.com","name3":"","name4":"","name5":"","owner_confirm_address":"","period":"1","premium_price_to_verify":"","rant_agrees":"","rant_no":"","reg_domain":"","reg_password":"abc123","reg_type":"new","reg_username":"phptest","sortorder1":"1","sortorder2":"2","sortorder3":"","sortorder4":"","sortorder5":""}}';
    /**
     * New NameSuggest should throw an exception if
     * data->domain is ommitted
     *
     * @return void
     */
    public function testValidateMissingDomainList()
    {
        $data = ( object ) array (
            'func' => $this->func,
            );

        $this->setExpectedException( 'OpenSRS\Exception' );
        $ns = new DnsGet( 'array', $data );
    }

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( $this->validSubmission );
        $data->data->domain = 'phptest'.time().'.com';

        $ns = new DnsGet( 'array', $data );

        $this->assertTrue( $ns instanceof DnsGet );
    }
}
