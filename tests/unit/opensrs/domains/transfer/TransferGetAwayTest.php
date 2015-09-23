<?php

use opensrs\domains\transfer\TransferGetAway;

/**
 * @group transfer
 * @group TransferGetAway
 */
class TransferGetAwayTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferGetAway';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Optional
             *
             * domain: submit only if you
             *   want to check if a particular
             *   domain has been transferred
             *   away
             * gaining_registrar: search for
             *   transfers-away according to
             *   gaining registrar. accepts
             *   strings and wildcards (*)
             * limit: max number of domains to
             *   return per page. max 40
             * owner_confirm_from: search
             *   according to date from when
             *   the owner confirmed or denied
             *   the transfer
             * owner_confirm_to: search according
             *   to date prior to when owner
             *   confirmed or denied transfer
             * owner_request_from: search by date
             *   when email waas sent to requestor
             * owner_request_to: search according to
             *   when email was sent to request_address
             * page: determines which page to receive,
             *   page index starts at 0 (zero)
             * req_from: search according to date
             *   transfer notification was sent
             * req_to: search according to date up
             *   until transfer notification sent\
             * request_address: admin email at the
             *   time of notification. wildcards (*)
             *   accepted
             * status: search by status.
             *   allowed values:
             *     - pending_admin
             *     - pending_owner
             *     - pending_registry
             *     - completed
             *     - cancelled
             */
            'domain' => '',
            'gaining_registrar' => '',
            'limit' => '',
            'owner_confirm_from' => '',
            'owner_confirm_to' => '',
            'owner_request_from' => '',
            'owner_request_to' => '',
            'page' => '',
            'req_from' => '',
            'req_to' => '',

            'request_address' => '',
            'status' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown.
     *
     *
     * @group validsubmission
     */
    public function testValidSubmission()
    {
        $data = json_decode(json_encode($this->validSubmission));

        $ns = new TransferGetAway('array', $data);

        $this->assertTrue($ns instanceof TransferGetAway);
    }
}
