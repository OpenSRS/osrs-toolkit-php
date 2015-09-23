<?php

use opensrs\backwardcompatibility\dataconversion\domains\lookup\GetDomainsContacts;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group lookup
 * @group BC_GetDomainsContacts
 */
class BC_GetDomainsContactsTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain_list' => '',
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

        $data->data->domain_list = 'phptest'.time().' .com,tsetphp'.time().'.com';

        $shouldMatchNewDataObject = new \stdClass();

        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain_list = explode(
            ',', $data->data->domain_list
            );

        $ns = new GetDomainsContacts();

        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
