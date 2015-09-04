<?php

use OpenSRS\domains\personalnames\PersonalNamesNameSuggest;
/**
 * @group personalnames
 * @group PersonalNamesNameSuggest
 */
class PersonalNamesNameSuggestTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persNameSuggest';

    protected $validSubmission = array(
        "data" => array(
            "func" => "persNameSuggest",

            /**
             * Required
             *
             * searchstring: The name whose availability
             * you want to check, ie: 'john smith'.
             */
            "searchstring" => "",
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->searchstring = "john smith";

        $ns = new PersonalNamesNameSuggest( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->searchstring = "john smith";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no fqdn sent
        unset( $data->data->searchstring );
        $ns = new PersonalNamesNameSuggest( 'array', $data );
    }
}
