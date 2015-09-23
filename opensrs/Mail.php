<?php

namespace opensrs;

defined('OPENSRSURI') or require_once dirname(__FILE__).'/openSRS_config.php';

class Mail
{
    protected $command = null;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    // Class functions
    public function makeCall($sequence)
    {
        $result = '';
        // Open the socket
        // $fp = fsockopen ($this->osrs_host, $this->osrs_port, $errno, $errstr, $this->osrs_portwait);
        $fp = pfsockopen(APP_MAIL_HOST, APP_MAIL_PORT, $errno, $errstr, APP_MAIL_PORTWAIT);

        if (!$fp) {
            throw new Exception("oSRS Error - $errstr ($errno)");            // Something went wrong
        }

        // Send commands to APP server
        for ($i = 0; $i < count($sequence); ++$i) {
            $servCatch = '';

            // Write the port
            $writeStr = $sequence[$i]."\r\n";
            $fwrite = fwrite($fp, $writeStr);
            if (!$fwrite) {
                throw new Exception('oSRS - Mail System Write Error, please check if your network allows connection to the server.');
            }

            $dotStr = ".\r\n";
            $fwrite = fwrite($fp, $dotStr);
            if (!$fwrite) {
                throw new Exception('oSRS - Mail System Write Error, please check if your network allows connection to the server.');
            }

                        // read the port rightaway
            // Last line of command has be done with different type of reading
            if ($i == (count($sequence) - 1)) {
                // Loop until End of transmission
                while (!feof($fp)) {
                    $servCatch .= fgets($fp, 128);
                }
            } else {
                // Plain buffer read with big data packet
                $servCatch .= fread($fp, 8192);
            }

            // Possible parsing and additional validation will be here
            // If error accours in the communication than the script should quit rightaway
            // $servCatch

            $result .= $servCatch;
        }

        //Close the socket
        fclose($fp);

        return $result;
    }

    public function parseResults($resString)
    {
        // Raw tucows result
        $resArray = explode(".\r\n", $resString);
        $resRinse = array();
        for ($i = 0; $i < count($resArray); ++$i) {                            // Clean up \n, \r and empty fields
            $resArray[$i] = str_replace("\r", '', $resArray[$i]);
            $resArray[$i] = str_replace("\n", ' ', $resArray[$i]);        // replace new line with space
            $resArray[$i] = str_replace('  ', ' ', $resArray[$i]);        // no double space - for further parsing
            $resArray[$i] = substr($resArray[$i], 0, -1);                // take out the last space
            if ($resArray[$i] != '') {
                array_push($resRinse, $resArray[$i]);
            }
        }
        $result = array(
            'is_success' => '1',
            'response_code' => '200',
            'response_text' => 'Command completed successfully',
        );
        $i = 1;
        // Takes the rinsed result lines and forms it into an Associative array
        foreach ($resRinse as $resultLine) {
            $okPattern = '/^OK 0/';
            $arrayPattern = '/ ([\w\-\.\@]+)\=\"([\w\-\.\@\*\, ]*)\"/';
            $errorPattern = '/^ER ([0-9]+) (.+)$/';

            // Checks to see if this line is an information line
            $okLine = preg_match($okPattern, $resultLine, $matches);

            if ($okLine == 0) {
                // If it's not an ok line, it's an error
                $err_num_match = 0;
                $err_num_match = preg_match($errorPattern, $resultLine, $err_match);

                // Makes sure the error pattern matched and that there isn't an error that has already happened
                if ($err_num_match == 1 && $result['is_success'] == '1') {
                    $result['response_text'] = $err_match[2];
                    $result['response_code'] = $err_match[1];
                    $result['is_success'] = '0';
                }
            } else {
                // If it's an OK line check to see if it's an Array of values
                $arrayMatch = preg_match_all($arrayPattern, $resultLine, $arrayMatches);
                if ($arrayMatch != 0) {
                    for ($j = 0;$j < $arrayMatch;++$j) {
                        if ($arrayMatches[1][$j] == 'LIST') {
                            $result['attributes'][strtolower($arrayMatches[1][$j])] = explode(',', $arrayMatches[2][$j]);
                        } else {
                            $result['attributes'][strtolower($arrayMatches[1][$j])] = $arrayMatches[2][$j];
                        }
                    }
                } else {

                    // If it's not an array line or an error it could be a table
                    $tableLines = explode(' , ', $resultLine);
                    if (count($tableLines) > 1) {
                        $tableLines[0] = str_replace('OK 0 ', '', $tableLines[0]);
                        $tableHeaders = explode(' ', $tableLines[0]);
                        $result['attributes']['list'] = array();
                        for ($j = 1;$j < count($tableLines);++$j) {
                            $values = explode('" "', $tableLines[$j]);
                            $k = 0;
                            foreach ($tableHeaders as $tableHeader) {
                                $result['attributes']['list'][$j - 1][strtolower($tableHeader)] = str_replace('"', '', $values[$k]);
                                ++$k;
                            }
                        }
                    }
                }
            }
            ++$i;
        }

        return $result;
    }

    public function getCommand($dataObject, $fields = null, $required = false)
    {
        $command = '';

        if (is_null($fields)) {
            if (isset($dataObject->attributes)) {
                if (isset($this->requiredFields['attributes'])) {
                    $command .= $this->getCommand($dataObject->attributes, $this->requiredFields['attributes'], true);
                }

                if (isset($this->optionalFields['attributes'])) {
                    $command .= $this->getCommand($dataObject->attributes, $this->optionalFields['attributes'], false);
                }
            }
        } else {
            // check required fields
            if (!empty($fields)) {
                foreach ($fields as $i => $field) {
                    if (is_array($field)) {
                        if (!isset($dataObject->$i)) {
                            if ($required) {
                                Exception::notDefined($i);
                            }
                        }
                        $command .= $this->getCommand($dataObject->$i, $field, $required);
                    } else {
                        if (!isset($dataObject->$field) || $dataObject->$field == '') {
                            if ($required) {
                                Exception::notDefined($field);
                            }
                        } else {
                            if (is_array($dataObject->$field)) {
                                $value = json_encode($dataObject->$field);
                            } else {
                                $value = $dataObject->$field;
                            }

                            $command .= " $field=$value";
                        }
                    }
                }
            }
        }

        return $command;
    }

    public function send($dataObject, $command = null)
    {
        $dataObject = $this->addAuthenticationInfo($dataObject);

        if ($command && $this->command) {
            $sequence = array(
                0 => 'ver ver="3.4"',
                1 => 'login user="'.$dataObject->attributes->admin_username.'" domain="'.$dataObject->attributes->admin_domain.'" password="'.$dataObject->attributes->admin_password.'"',
                2 => $this->command.$command,
                3 => 'quit',
            );
        } else {
            $sequence = array(
                0 => 'ver ver="3.4"',
                1 => 'login user="'.$dataObject->attributes->admin_username.'" domain="'.$dataObject->attributes->admin_domain.'" password="'.$dataObject->attributes->admin_password.'"',
                2 => 'quit',
            );
        }

        $tucRes = $this->makeCall($sequence);
        $arrayResult = $this->parseResults($tucRes);

        $base = new Base();

        // Results
        $this->resultFullRaw = $arrayResult;
        $this->resultRaw = $arrayResult;
        $this->resultFullFormatted = $base->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $base->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    }

    public function addAuthenticationInfo($dataObject)
    {
        if (!isset($dataObject->attributes->admin_username) || $dataObject->attributes->admin_username == '') {
            if (APP_MAIL_USERNAME == '') {
                Exception::notDefined('admin_username');
            } else {
                $dataObject->attributes->admin_username = APP_MAIL_USERNAME;
            }
        }

        if (!isset($dataObject->attributes->admin_password) || $dataObject->attributes->admin_password == '') {
            if (APP_MAIL_PASSWORD == '') {
                Exception::notDefined('admin_password');
            } else {
                $dataObject->attributes->admin_password = APP_MAIL_PASSWORD;
            }
        }

        if (!isset($dataObject->attributes->admin_domain) || $dataObject->attributes->admin_domain == '') {
            if (APP_MAIL_DOMAIN == '') {
                Exception::notDefined('admin_domain');
            } else {
                $dataObject->attributes->admin_domain = APP_MAIL_DOMAIN;
            }
        }

        return $dataObject;
    }
}
