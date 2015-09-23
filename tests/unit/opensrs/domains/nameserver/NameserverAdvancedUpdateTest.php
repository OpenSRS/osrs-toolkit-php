<?php

use opensrs\domains\nameserver\NameserverAdvancedUpdate;

/**
 * @group nameserver
 * @group NameserverAdvancedUpdate
 */
class NameserverAdvancedUpdateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'nsAdvancedUpdt';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * bypass: relevant domain, required
             *   only if cookie is not set
             * op_type: 'assign' when submitting
             *   assign_ns, 'add_remove' when
             *   submitting 'add_ns' or 'remove_ns'
             */
            'cookie' => '',
            'bypass' => '',
            'op_type' => '',

            /*
             * Optional
             *
             * add_ns: list of nameservers to add
             *   * cannot be submitted in the same
             *     request as assign_ns
             * assign_ns: list of nameservers to assign
             *   * cannot be submitted in same request
             *     as add_ns or remove_ns
             * remove_ns: list of nameservers to remove
             *   * cannot be submitted in same request
             *     as assign_ns
             */
            'add_ns' => '',
            'assign_ns' => '',
            'remove_ns' => '',
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

        // assign_ns request
        $data->cookie = md5(time());
        $data->attributes->op_type = 'assign';
        $data->attributes->assign_ns = 'ns1.'.$data->attributes->bypass.';'.
                                 'ns2.'.$data->attributes->bypass;

        $ns = new NameserverAdvancedUpdate('array', $data);

        $this->assertTrue($ns instanceof NameserverAdvancedUpdate);

        // add_ns request
        $data->attributes->op_type = 'add_remove';
        $data->attributes->add_ns = $data->attributes->assign_ns;

        // unset data we don't need for
        // this request
        unset($data->attributes->assign_ns);

        $ns = new NameserverAdvancedUpdate('array', $data);

        $this->assertTrue($ns instanceof NameserverAdvancedUpdate);

        // remove_ns request
        $data->attributes->op_type = 'add_remove';
        $data->attributes->remove_ns = $data->attributes->add_ns;

        // unset data we don't need for
        // this request
        unset($data->attributes->add_ns);

        $ns = new NameserverAdvancedUpdate('array', $data);

        $this->assertTrue($ns instanceof NameserverAdvancedUpdate);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing op_type' => array('op_type'),
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

        // assign_ns request
        $data->cookie = md5(time());
        $data->attributes->op_type = 'assign';
        $data->attributes->assign_ns = 'ns1.'.$data->attributes->bypass.';'.
                                 'ns2.'.$data->attributes->bypass;

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

        $ns = new NameserverAdvancedUpdate('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsCookieAndDomainSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        // assign_ns request
        $data->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->op_type = 'assign';
        $data->attributes->assign_ns = 'ns1.'.$data->attributes->bypass.';'.
                                 'ns2.'.$data->attributes->bypass;

        $this->setExpectedExceptionRegExp(
          'opensrs\Exception',
        '/(cookie|domain).*cannot.*one.*call/'
          );

        $ns = new NameserverAdvancedUpdate('array', $data);
    }

    /**
     * Invalid submission should throw an exception.
     *
     *
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsNoCookieOrDomainSent()
    {
        $data = json_decode(json_encode($this->validSubmission));

        // assign_ns request
        $data->attributes->op_type = 'assign';
        $data->attributes->assign_ns = 'ns1.'.$data->attributes->bypass.';'.
                                 'ns2.'.$data->attributes->bypass;

        $this->setExpectedExceptionRegExp(
          'opensrs\Exception',
        '/(cookie|domain).*not.*defined/'
          );

        $ns = new NameserverAdvancedUpdate('array', $data);
    }
}
