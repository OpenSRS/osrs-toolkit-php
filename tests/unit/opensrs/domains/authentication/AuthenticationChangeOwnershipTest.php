<?php

use OpenSRS\domains\authentication\AuthenticationChangeOwnership;

/**
 * @group authentication
 * @group AuthenticationChangeOwnership
 */
class AuthenticationChangeOwnershipTest extends PHPUnit_Framework_TestCase
{
    protected $func = "authChangeOwnership";

    protected $validSubmission = array(
        "data" => array(
            "func" => "authChangeOwnership",

            /**
             * Required: one of 'cookie' or 'domain'
             *
             * cookie: authentication cookie
             *   * see domains\cookie\CookieSet
             * domain: the relevant domain (only
             *   required if 'cookie' is not sent)
             */
            "cookie" => "",
            "domain" => "",

            /**
             * Optional
             * If not submitted, only the domain(s)
             * identified by 'cookie' are moved
             * 
             * 0 = do not move all domains to new profile
             * 1 = move all domains to the new profile
             */
            "move_all" => "",

            /**
             * Required: both
             */
            "username" => "",
            "password" => "",
            
            /**
             * Optional
             * If included, user can change domain from
             * one profile to another (existing) profile.
             * If not included, username/password provided
             * are used to create a new profile
             */
            "reg_domain" => ""
            )
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $ns = new AuthenticationChangeOwnership( 'array', $data );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     */
    public function testInvalidSubmissionFieldsMissing() {
        $data = json_decode( json_encode($this->validSubmission) );
        $this->setExpectedException( 'OpenSRS\Exception' );


        // no password sent
        unset( $data->data->password );
        $ns = new AuthenticationChangeOwnership( 'array', $data );

        
        // no username sent
        unset( $data->data->username );
        $ns = new AuthenticationChangeOwnership( 'array', $data );

        
        // no cookie sent
        unset( $data->data->cookie );
        $ns = new AuthenticationChangeOwnership( 'array', $data );
    }
}
