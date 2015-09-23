<?php

use opensrs\backwardcompatibility\dataconversion\domains\personalnames\PersonalNamesUpdate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_PersonalNamesUpdate
 */
class BC_PersonalNamesUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'content' => '',
            'name' => '',
            'type' => '',
            'domain' => '',
            'forward_email' => '',
            'mailbox_type' => '',
            'password' => '',
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

        $data->data->domain = 'phptest'.time().'.com';
        $data->data->content = long2ip(time());
        $data->data->name = '@';
        $data->data->type = 'A';
        $data->data->forward_email = 'phptoolkit@tucows.com';
        $data->data->mailbox_type = 'MAILBOX';
        $data->data->password = 'password1234';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->dnsRecords = new \stdClass();
        $shouldMatchNewDataObject->attributes->mailbox = new \stdClass();

        $shouldMatchNewDataObject->attributes->dnsRecords->content =
            $data->data->content;
        $shouldMatchNewDataObject->attributes->dnsRecords->name =
            $data->data->name;
        $shouldMatchNewDataObject->attributes->dnsRecords->type =
            $data->data->type;

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        $shouldMatchNewDataObject->attributes->mailbox->forward_email =
            $data->data->forward_email;
        $shouldMatchNewDataObject->attributes->mailbox->mailbox_type =
            $data->data->mailbox_type;
        $shouldMatchNewDataObject->attributes->mailbox->password =
            $data->data->password;

        $ns = new PersonalNamesUpdate();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
