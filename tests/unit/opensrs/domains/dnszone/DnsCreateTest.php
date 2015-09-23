<?php

use opensrs\domains\dnszone\DnsCreate;

/**
 * @group dnszone
 * @group DnsCreate
 */
class DnsCreateTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'dnsCreate';

    protected $validSubmission = array(
        'attributes' => array(
            /*
             * Required
             *
             * domain: the domain for which you want
             *   to define DNS records
             */
            'domain' => '',

            /*
             * Optional
             *
             * dns_template: specify the name of the
             *   DNS template you want to use to enable
             *   DNS and assign initial records
             */
            'dns_template' => '',

            /*
             * Optional: DNS records
             *
             * List of record types defined for the
             * domain, each entry includes settings for
             * that record:
             *
             * 
             */
            // array of 'A' records to add
            'a' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // IPv4 address to point the
                    // above subdomain to
                    'ip_address' => '',
                    ),
                ),

            // array of 'AAAA' (IPv6) records
            // to add
            'aaaa' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // the IPv6 address to point
                    // the above subdomain to
                    'ipv6_address' => '',
                    ),
                ),

            // array of CNAME records to add
            'cname' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // FQDN of the domain that you
                    // want to access
                    'hostname' => '',
                    ),
                ),

            // array of MX records to add
            'mx' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // FQDN of the domain that you
                    // want to access
                    'hostname' => '',

                    // priority of the target host,
                    // lower value means more preferred
                    'priority' => '',
                    ),
                ),

            // array of SRV records to add
            'srv' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // FQDN of the domain that you
                    // want to access
                    'hostname' => '',

                    // priority of the target host,
                    // lower value means more preferred
                    'priority' => '',

                    // relative weight for records with
                    // the same priority
                    'weight' => '',

                    // the TCP or UDP port on which the
                    // service is found
                    'port' => '',
                    ),
                ),

            // array of TXT records to add
            'txt' => array(
                array(
                    // third level of the domain
                    // name, such as www or ftp
                    'subdomain' => '',

                    // comments that you want to
                    // include
                    'text' => '',
                    ),
                ),
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

        $data->attributes->domain = 'phptest'.time().'.com';

        $ns = new DnsCreate('array', $data);

        $this->assertTrue($ns instanceof DnsCreate);
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

        $data->attributes->domain = 'phptest'.time().'.com';

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

        $ns = new DnsCreate('array', $data);
    }
}
