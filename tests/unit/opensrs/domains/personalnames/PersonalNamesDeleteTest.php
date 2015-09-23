<?php

use opensrs\domains\personalnames\PersonalNamesDelete;

/**
 * @group personalnames
 * @group PersonalNamesDelete
 */
class PersonalNamesDeleteTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'persDelete';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: perosnal names domain
             *   to be deleted
             */
            'domain' => '',
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

        $data->attributes->domain = 'john.smith.net';

        $ns = new PersonalNamesDelete('array', $data);

        $this->assertTrue($ns instanceof PersonalNamesDelete);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing domain' => array('domain'),
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

        $data->attributes->domain = 'john.smith.net';

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

        $ns = new PersonalNamesDelete('array', $data);
    }
}
