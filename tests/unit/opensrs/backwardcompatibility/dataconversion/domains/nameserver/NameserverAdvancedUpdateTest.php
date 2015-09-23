<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverAdvancedUpdate;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverAdvancedUpdate
 */
class BC_NameserverAdvancedUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'cookie' => '',
            'domain' => '',
            'add_ns' => '',
            'assign_ns' => '',
            'op_type' => '',
            'remove_ns' => '',
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
        $data->data->cookie = md5(time());
        $data->data->add_ns = 'ns1.'.$data->data->domain.','.
                              'ns2.'.$data->data->domain;
        $data->data->assign_ns = 'ns3.'.$data->data->domain.','.
                              'ns4.'.$data->data->domain;
        $data->data->op_type = 'assign';
        $data->data->remove_ns = 'ns5.'.$data->data->domain.','.
                              'ns6.'.$data->data->domain;

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->cookie = $data->data->cookie;

        $shouldMatchNewDataObject->attributes = new \stdClass();
        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;

        // explode to an array as the dataconversion class
        // will send it back as an array
        $shouldMatchNewDataObject->attributes->add_ns = explode(',', $data->data->add_ns);

        // explode to an array as the dataconversion class
        // will send it back as an array
        $shouldMatchNewDataObject->attributes->assign_ns = explode(',', $data->data->assign_ns);

        $shouldMatchNewDataObject->attributes->op_type = $data->data->op_type;

        // explode to an array as the dataconversion class
        // will send it back as an array
        $shouldMatchNewDataObject->attributes->remove_ns = explode(',', $data->data->remove_ns);

        $ns = new NameserverAdvancedUpdate();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
