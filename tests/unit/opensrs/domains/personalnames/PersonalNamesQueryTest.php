<?php

use OpenSRS\domains\personalnames\PersonalNamesQuery;
/**
 * @group personalnames
 * @group PersonalNamesQuery
 */
class PersonalNamesQueryTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persQuery';

    protected $validSubmission = array(
        "data" => array(
            "func" => "persQuery",

            /**
             * Required
             *
             * domain: perosnal names domain
             *   to be queried
             */
            "domain" => "",

            /**
             * Optional
             * query_dns: request information about
             *   DNS settings
             * query_email: request information about
             *   associated email account
             *   * for both query_dns and query_email:
             *   0 = do not return (default)
             *   1 = return information wtih response
             */
            "query_dns" => "",
            "query_email" => ""
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

        $ns = new PersonalNamesQuery( 'array', $data );
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



        // no fqdn sent
        unset( $data->data->domain );
        $ns = new PersonalNamesQuery( 'array', $data );
    }
}
