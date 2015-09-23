<?php

use opensrs\backwardcompatibility\dataconversion\domains\nameserver\NameserverRegistryAdd;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_NameserverRegistryAdd
 */
class BC_NameserverRegistryAddTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'all' => '',
            'fqdn' => '',
            'tld' => '',
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

        $data->data->all = '0';
        $data->data->fqdn = 'phptest'.time().'.com';
        $data->data->tld = '.com,.net,.org';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->all = $data->data->all;
        $shouldMatchNewDataObject->attributes->fqdn = $data->data->fqdn;

        // explode to an array since that's how
        // DataConversion sends it back!
        $shouldMatchNewDataObject->attributes->tld = explode(
            ',',
            $data->data->tld
            );

        $ns = new NameserverRegistryAdd();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
