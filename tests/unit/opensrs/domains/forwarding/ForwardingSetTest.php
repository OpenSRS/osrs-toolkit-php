<?php

use opensrs\domains\forwarding\ForwardingSet;

/**
 * @group forwarding
 * @group ForwardingSet
 */
class ForwardingSetTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'fwdSet';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required: 1 of 2
             *
             * cookie: cookie to be deleted
             * domain: relevant domain, required
             *   only if cookie is not sent
             */
            'cookie' => '',
            'domain' => '',

            /*
             * Required
             *
             * subdomain: third level domain such as
             *   www or ftp, ie: if you specify www
             *   visitors to example.com are redirected
             *   to www.example.com. max 128 chars
             *   * note: although this parameter is required,
             *           its value can be null
             */
            'subdomain' => '',

            /*
             * Optional
             *
             * description: short description of
             *   your website, max 255 characters,
             *   only takes effect if masked=1
             * destination_url: full address of
             *   the website to forward to (complete
             *   domain or IP address), max 200 chars
             * enabled: determines whether domain
             *   forwarding is in effect
             *   0 = turn off forwarding
             *   1 = turn on forwarding
             * keywords: descriptive keywords that a
             *   visitor might use when searching for
             *   your website, comma separated
             * masked: determines the destination
             *   website address appears in the browser
             *   address field
             *   0 = display destination address
             *   1 = show original domain address
             * title: text that you want to appear in
             *   the browser title bar, max 255 chars,
             *   only takes effect if masked=1
             */
            'description' => '',
            'destination_url' => '',
            'enabled' => '',
            'keywords' => '',
            'masked' => '',
            'title' => '',
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

        $data->cookie = md5(time());
        $data->attributes->subdomain = 'null';

        $ns = new ForwardingSet('array', $data);

        $this->assertTrue($ns instanceof ForwardingSet);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing subdomain' => array('subdomain'),
            );
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing($field, $parent = 'attributes', $message = null)
    {
        $data = json_decode(json_encode($this->validSubmission));

        $data->cookie = md5(time());
        $data->attributes->subdomain = 'null';

        $this->setExpectedException('opensrs\Exception');

        if (is_null($message)) {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$field.*not defined/"
              );
        } else {
            $this->setExpectedExceptionRegExp(
              'opensrs\Exception',
              "/$message/"
              );
        }

        // clear field being tested
        if (is_null($parent)) {
            unset($data->$field);
        } else {
            unset($data->$parent->$field);
        }

        $ns = new ForwardingSet('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsCookieAndBypassSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        // assign_ns request
        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->subdomain = 'null';

        $this->setExpectedExceptionRegExp(
            'opensrs\Exception',
            '/.*cookie.*domain.*cannot.*one.*call.*/'
            );

        $ns = new ForwardingSet('array', $data);
    }
}
