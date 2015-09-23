<?php

namespace opensrs\mail;

/**
 * @group mail
 * @group MailCreateDomainWelcomeEmail
 */
class CreateDomainWelcomeEmailTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'attributes' => array(
            'admin_username' => '',
            'admin_password' => '',
            'admin_domain' => '',
            'domain' => '',
            'welcome_text' => '',
            'welcome_subject' => '',
            'from_name' => '',
            'from_address' => '',
            'charset' => '',
            'mime_type' => '',
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

        $data->attributes->admin_username = 'phptest'.time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest'.time().'.com';
        $data->attributes->domain = 'new-'.$data->attributes->admin_domain;
        $data->attributes->welcome_text = 'Welcome';
        $data->attributes->welcome_subject = 'Welcome!';
        $data->attributes->from_name = 'Tikloot Php';
        $data->attributes->from_address = 'phptoolkit@tucows.com';
        $data->attributes->charset = 'UTF-8';
        $data->attributes->mime_type = 'text/plain';

        $ns = new CreateDomainWelcomeEmail('array', $data);

        $this->assertTrue($ns instanceof CreateDomainWelcomeEmail);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing admin_username' => array('admin_username'),
            'missing admin_password' => array('admin_password'),
            'missing admin_domain' => array('admin_domain'),
            'missing domain' => array('domain'),
            'missing welcome_text' => array('welcome_text'),
            'missing welcome_subject' => array('welcome_subject'),
            'missing from_name' => array('from_name'),
            'missing from_address' => array('from_address'),
            'missing charset' => array('charset'),
            'missing mime_type' => array('mime_type'),
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

        $data->attributes->admin_username = 'phptest'.time();
        $data->attributes->admin_password = 'password1234';
        $data->attributes->admin_domain = 'mail.phptest'.time().'.com';
        $data->attributes->domain = 'new-'.$data->attributes->admin_domain;
        $data->attributes->welcome_text = 'Welcome';
        $data->attributes->welcome_subject = 'Welcome!';
        $data->attributes->from_name = 'Tikloot Php';
        $data->attributes->from_address = 'phptoolkit@tucows.com';
        $data->attributes->charset = 'UTF-8';
        $data->attributes->mime_type = 'text/plain';

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

        $ns = new CreateDomainWelcomeEmail('array', $data);
    }
}
