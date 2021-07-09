<?php

use opensrs\domains\authentication\AuthenticationChangePassword;

/**
 * @group authentication
 * @group AuthenticationChangePassword
 */
class AuthenticationChangePasswordTest extends PHPUnit_Framework_TestCase
{
    protected $fund = 'authChangePassword';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required: one of 'cookie' or 'domain'
             *
             * cookie: authentication cookie
             *   * see domains\cookie\CookieSet
             * domain: the relevant domain (only
             *   required if 'cookie' is not sent)
             */
            'cookie' => '',
            'domain' => '',

            /*
             * Required
             *
             * The new password for the registrant
             */
            'reg_password' => '',
            ),
        );
    
    /**
     * @link http://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/
     * @link http://stackoverflow.com/questions/536584/non-random-salt-for-password-hashes/536756#536756
     * @param string $strPassword the users password
     * @param int $numAlgo A password algorithm constant denoting the algorithm to use when hashing the password. (http://php.net/manual/en/password.constants.php)
     * @param array $arrOptions An associative array containing options. See the password algorithm constants (above) for documentation on the supported options for each algorithm. If omitted, a random salt will be created and the default cost will be used.
     * @return string|bool Returns the hashed password, or FALSE on failure.
     */
    public function create_password_hash($strPassword, $numAlgo = 1, $arrOptions = array())
    {
        if (function_exists('password_hash')) {
            // php >= 5.5
            $hash = password_hash($strPassword, $numAlgo, $arrOptions);
        } else {
            $salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM);
            $salt = base64_encode($salt);
            $salt = str_replace('+', '.', $salt);
            $hash = crypt($strPassword, '$2y$10$' . $salt . '$');
        }
        return $hash;
    }

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

        $data->attributes->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->reg_password = $this->(md5(time()), PASSWORD_BCRYPT);

        $ns = new AuthenticationChangePassword('array', $data);

        $this->assertTrue($ns instanceof AuthenticationChangePassword);
    }

    /**
     * Data Provider for Invalid Submission test.
     */
    public function submissionFields()
    {
        return array(
            'missing reg_password' => array('reg_password'),
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

        $data->attributes->cookie = md5(time());
        $data->attributes->domain = 'phptest'.time().'.com';
        $data->attributes->reg_password = $this->create_password_hash(md5(time()), PASSWORD_BCRYPT);

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

        $ns = new AuthenticationChangePassword('array', $data);
    }
}
