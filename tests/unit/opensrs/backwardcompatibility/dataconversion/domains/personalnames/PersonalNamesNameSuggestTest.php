<?php

use opensrs\backwardcompatibility\dataconversion\domains\personalnames\PersonalNamesNameSuggest;

/**
 * @group backwardcompatibility
 * @group dataconversion
 * @group cookie
 * @group BC_PersonalNamesNameSuggest
 */
class BC_PersonalNamesNameSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'searchstring' => '',
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

        $data->data->searchstring = 'john smith';

        $shouldMatchNewDataObject = new \stdClass();
        $shouldMatchNewDataObject->attributes = new \stdClass();

        $shouldMatchNewDataObject->attributes->searchstring = $data->data->searchstring;

        $ns = new PersonalNamesNameSuggest();
        $newDataObject = $ns->convertDataObject($data);

        $this->assertTrue($newDataObject == $shouldMatchNewDataObject);
    }
}
