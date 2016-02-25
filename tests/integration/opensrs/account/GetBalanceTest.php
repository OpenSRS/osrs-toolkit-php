<?php

use opensrs\account\GetBalance;

/**
 * @group account 
 * @group GetBalance
 */
class integrationGetBalanceTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'accountGetBalance';
    protected $getBalance;
    protected $responseData;

    public function setUp()
    {
       $this->getBalance = new GetBalance('array', array());
       $this->responseData = $this->getBalance->resultFullRaw;
    }

    
    /**
     * Response should return a 200 
     * 
     */
    public function testResponseSuccess()
    {
        // response code exists 
        $this->assertTrue(array_key_exists('response_code', $this->responseData));

        // respose code is 200
        $this->assertEquals($this->responseData['response_code'], '200');
    }

    /**
     * Response sshould have a balance
     * 
     */
    public function testResponseHasBalance()
    {
        // attributes array exists
        $this->assertTrue(array_key_exists('attributes', $this->responseData));

        // has balance
        $this->assertTrue(array_key_exists('balance', $this->responseData['attributes']));
    }

    /**
     * Response should have a hold balance
     *
     */
    public function testResponesHasHoldBalance()
    {
        // attributes array exists
        $this->assertTrue(array_key_exists('attributes', $this->responseData));

        // has hold balance
        $this->assertTrue(array_key_exists('hold_balance', $this->responseData['attributes']));
    }
}
