<?php

use OpenSRS\domains\personalnames\PersonalNamesDelete;
/**
 * @group personalnames
 * @group PersonalNamesDelete
 */
class PersonalNamesDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persDelete';

    protected $validSubmission = array(
        "data" => array(
            "func" => "persDelete",

            /**
             * Required
             *
             * domain: perosnal names domain
             *   to be deleted
             */
            "domain" => ""
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

        $data->data->domain = "john.smith.net";

        $ns = new PersonalNamesDelete( 'array', $data );

        $this->assertTrue( $ns instanceof PersonalNamesDelete );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "john.smith.net";

        $this->setExpectedException( 'OpenSRS\Exception' );



        // no domain sent
        unset( $data->data->domain );
        $ns = new PersonalNamesDelete( 'array', $data );
    }
}
