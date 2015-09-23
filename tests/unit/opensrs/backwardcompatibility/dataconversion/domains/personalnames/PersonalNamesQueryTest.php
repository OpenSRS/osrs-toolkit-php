<?php

use opensrs\backwardcompatibility\dataconversion\domains\personalnames\PersonalNamesQuery;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_PersonalNamesQuery
 */
class BC_PersonalNamesQueryTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'query_dns' => '',
            'query_email' => '',
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

        $data->data->domain = 'john.smith.net';
        $data->data->query_dns = '0';
        $data->data->query_email = '0';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->domain = $data->data->domain;
        $shouldMatchNewDataObject->attributes->query_dns = $data->data->query_dns;
        $shouldMatchNewDataObject->attributes->query_email = $data->data->query_email;

        $ns = new PersonalNamesQuery();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
