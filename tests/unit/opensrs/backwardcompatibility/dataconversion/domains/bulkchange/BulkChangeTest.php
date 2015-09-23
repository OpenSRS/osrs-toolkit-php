<?php

use opensrs\backwardcompatibility\dataconversion\domains\bulkchange\BulkChange;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_BulkChange
 */
class BC_BulkChangeTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'change_items' => '',
            'change_type' => '',

            'op_type' => '',

            'apply_to_locked_domains' => '',
            'contact_email' => '',
            'apply_to_all_reseller_items' => '',
            'apply_to_domains' => '',
            'dns_action' => '',
            'dns_template' => '',
            'only_if' => '',
            'force_dns_nameservers' => '',
            'dns_record_type' => '',
            'dns_record_data' => '',

            'type' => '',
            'personal' => '',

            'add_ns' => '',
            'remove_ns' => '',
            'assign_ns' => '',

            'period' => '',
            'let_expire' => '',
            'auto_renew' => '',
            'affiliate_id' => '',
            'gaining_reseller_username' => '',
            ),
        );

    /**
     * Valid conversion should complete with no
     * exception thrown.
     *
     *
     * @group validconversion
     */
    public function testValidDataConversion()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->data->change_items = 'phptest.com,phptest2.com';
        $data->data->change_type = 'dns_zone';

        $data->data->op_type = 'move_to_storefront';

        $data->data->apply_to_locked_domains = 'N';
        $data->data->contact_email = 'phptoolkit@tucows.com';
        $data->data->apply_to_all_reseller_items = 'N';
        $data->data->apply_to_domains = 'N';
        $data->data->dns_action = 'update';
        $data->data->dns_template = 'my-template';
        $data->data->only_if = 'N';
        $data->data->force_dns_nameservers = 'N';
        $data->data->dns_record_type = 'A';
        $data->data->dns_record_data = long2ip(time());

        $data->data->type = 'owner,admin,tech,billing';
        $data->personal = (object) array(
            'first_name' => 'Tikloot',
            'last_name' => 'Php',
            'country' => 'canada',
            );

        $data->data->add_ns = 'new-ns1.phptest.com,new-ns2.phptest.com';
        $data->data->remove_ns = 'ns1.phptest.net,ns2.phptest.net';
        $data->data->assign_ns = 'ns1.phptest.com,ns2.phptest.com';

        $data->data->period = '5';
        $data->data->let_expire = 'N';
        $data->data->auto_renew = 'N';
        $data->data->affiliate_id = time();
        $data->data->gaining_reseller_username = 'reseller2';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->change_items = explode(
            ',', $data->data->change_items
            );
        $shouldMatchNewDataObject->attributes->change_type = $data->data->change_type;

        $shouldMatchNewDataObject->attributes->op_type = $data->data->op_type;

        $shouldMatchNewDataObject->attributes->apply_to_locked_domains = $data->data->apply_to_locked_domains;
        $shouldMatchNewDataObject->attributes->contact_email = $data->data->contact_email;
        $shouldMatchNewDataObject->attributes->apply_to_all_reseller_items = $data->data->apply_to_all_reseller_items;
        $shouldMatchNewDataObject->attributes->apply_to_domains = $data->data->apply_to_domains;
        $shouldMatchNewDataObject->attributes->dns_action = $data->data->dns_action;
        $shouldMatchNewDataObject->attributes->dns_template = $data->data->dns_template;
        $shouldMatchNewDataObject->attributes->only_if = $data->data->only_if;
        $shouldMatchNewDataObject->attributes->force_dns_nameservers = $data->data->force_dns_nameservers;
        $shouldMatchNewDataObject->attributes->dns_record_type = $data->data->dns_record_type;
        $shouldMatchNewDataObject->attributes->dns_record_data = $data->data->dns_record_data;

        $shouldMatchNewDataObject->attributes->period = $data->data->period;
        $shouldMatchNewDataObject->attributes->let_expire = $data->data->let_expire;
        $shouldMatchNewDataObject->attributes->auto_renew = $data->data->auto_renew;
        $shouldMatchNewDataObject->attributes->affiliate_id = $data->data->affiliate_id;
        $shouldMatchNewDataObject->attributes->gaining_reseller_username = $data->data->gaining_reseller_username;

        $shouldMatchNewDataObject->attributes->contacts = array();

        $contact = new \stdClass();
        $contact->set = $data->personal;
        $contact->type = 'owner';
        $shouldMatchNewDataObject->attributes->contacts[] = $contact;
        unset($contact);

        $contact = new \stdClass();
        $contact->set = $data->personal;
        $contact->type = 'admin';
        $shouldMatchNewDataObject->attributes->contacts[] = $contact;
        unset($contact);

        $contact = new \stdClass();
        $contact->set = $data->personal;
        $contact->type = 'tech';
        $shouldMatchNewDataObject->attributes->contacts[] = $contact;
        unset($contact);

        $contact = new \stdClass();
        $contact->set = $data->personal;
        $contact->type = 'billing';
        $shouldMatchNewDataObject->attributes->contacts[] = $contact;
        unset($contact);

        $shouldMatchNewDataObject->attributes->add_ns = explode(
            ',', $data->data->add_ns
            );
        $shouldMatchNewDataObject->attributes->remove_ns = explode(
            ',', $data->data->remove_ns
            );
        $shouldMatchNewDataObject->attributes->assign_ns = explode(
            ',', $data->data->assign_ns
            );

        $ns = new BulkChange();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
