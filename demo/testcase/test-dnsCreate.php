<?php 

if (isset($_POST['function'])) {
    // Open SRS Call -> Result
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

    // Form data capture
    $formFormat = $_POST['format'];
    $a = $_POST['a'];
    $aaaa = $_POST['aaaa'];
    $cname = $_POST['cname'];
    $mx = $_POST['mx'];
    $srv = $_POST['srv'];
    $txt = $_POST['txt'];

    $callstring = '';
    $callArray = array(
        'func' => $_POST['function'],
        'data' => array(
            'domain' => $_POST['domain'],
            'DNS_template' => $_POST['dns_template'],
        ),
    );

    if (isset($a)) {
        $as = array();
        for ($i = 0; $i < count($a); ++$i) {
            if (!empty($a['ip_address'][$i]) && !empty($a['subdomain'][$i])) {
                array_push($as, array('ip_address' => $a['ip_address'][$i], 'subdomain' => $a['subdomain'][$i]));
            }
        }
        if (count($as) > 0) {
            $callArray['data']['a'] = $as;
        }
    }

    if (isset($aaaa)) {
        $aaaas = array();
        for ($i = 0; $i < count($aaaa); ++$i) {
            if (!empty($aaaa['ipv6_address'][$i]) && !empty($aaaa['subdomain'][$i])) {
                array_push($aaaas, array('ipv6_address' => $aaaa['ipv6_address'][$i], 'subdomain' => $aaaa['subdomain'][$i]));
            }
        }
        if (count($aaaas) > 0) {
            $callArray['data']['aaaa'] = $aaaas;
        }
    }

    if (isset($cname)) {
        $cnames = array();
        for ($i = 0; $i < count($cname); ++$i) {
            if (!empty($cname['subdomain'][$i]) && !empty($cname['hostname'][$i])) {
                array_push($cnames, array('subdomain' => $cname['subdomain'][$i], 'hostname' => $cname['hostname'][$i]));
            }
        }
        if (count($cnames) > 0) {
            $callArray['data']['cname'] = $cnames;
        }
    }

    if (isset($mx)) {
        $mxs = array();
        for ($i = 0; $i < count($mx); ++$i) {
            if (!empty($mx['priority'][$i]) && !empty($mx['subdomain'][$i]) && !empty($mx['hostname'][$i])) {
                array_push($mxs, array('priority' => $mx['priority'][$i], 'subdomain' => $mx['subdomain'][$i], 'hostname' => $mx['hostname'][$i]));
            }
        }
        if (count($mxs) > 0) {
            $callArray['data']['mx'] = $mxs;
        }
    }

    if (!empty($srv)) {
        $srvs = array();
        for ($i = 0; $i < count($srv); ++$i) {
            if (!empty($srv['subdomain'][$i]) && !empty($srv['hostname'][$i])) {
                array_push($srvs, array('port' => $srv['port'][$i], 'priority' => $srv['priority'][$i], 'subdomain' => $srv['subdomain'][$i], 'hostname' => $srv['hostname'][$i], 'weight' => $srv['weight'][$i]));
            }
        }
        if (count($srvs) > 0) {
            $callArray['data']['srv'] = $srvs;
        }
    }

    if (isset($txt)) {
        $txts = array();
        for ($i = 0; $i < count($txt); ++$i) {
            if (!empty($txt['text'][$i])) {
                array_push($txts, array('subdomain' => $txt['subdomain'][$i], 'text' => $txt['text'][$i]));
            }
        }
        if (count($txts) > 0) {
            $callArray['data']['txt'] = $txts;
        }
    }

    if ($formFormat == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($formFormat == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

    $osrsHandler = processOpenSRS($formFormat, $callstring);

    // Print out the results
    echo(' In: '.$callstring.'<br>');
    echo('Out: '.$osrsHandler->resultFormatted);
} else {
    // Format
    if (isset($_GET['format'])) {
        $tf = $_GET['format'];
    } else {
        $tf = 'json';
    }
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title></title>
	<meta name="generator" http-equiv="generator" content="Claire Lam" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en"/>
</head>
<body>

<form action="test-dnsCreate.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="DnsCreate">

	<table cellpadding="0" cellspacing="10" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">dns_template </span> <input type="text" name="dns_template" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%">
				<b>A</b> <br/>
				<span class="headLine">a_ip_address </span> <input type="text" name="a[ip_address][]" value="" class="frontBox"><br />
				<span class="headLine">a_subdomain </span> <input type="text" name="a[subdomain][]" value="" class="frontBox"><br />
				<span class="headLine">a_ip_address </span> <input type="text" name="a[ip_address][]" value="" class="frontBox"><br />
				<span class="headLine">a_subdomain </span> <input type="text" name="a[subdomain][]" value="" class="frontBox"><br />
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>AAAA</b> <br/>
				<span class="headLine">aaaa_ipv6_address </span> <input type="text" name="aaaa[ipv6_address][]" value="" class="frontBox"><br />
				<span class="headLine">aaaa_subdomain </span> <input type="text" name="aaaa[subdomain][]" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>CNAME</b> <br/>
				<span class="headLine">cname_hostname </span> <input type="text" name="cname[hostname][]" value="" class="frontBox"><br />
				<span class="headLine">cname_subdomain </span> <input type="text" name="cname[subdomain][]" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>MX</b> <br/>
				<span class="headLine">mx_priority </span> <input type="text" name="mx[priority][]" value="" class="frontBox"><br />
				<span class="headLine">mx_subdomain </span> <input type="text" name="mx[subdomain][]" value="" class="frontBox"><br />
				<span class="headLine">mx_hostname </span> <input type="text" name="mx[hostname][]" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>SRV</b> <br/>
				<span class="headLine">srv_priority </span> <input type="text" name="srv[priority][]" value="" class="frontBox"><br />
				<span class="headLine">srv_weight </span> <input type="text" name="srv[weight][]" value="" class="frontBox"><br />
				<span class="headLine">srv_subdomain </span> <input type="text" name="srv[subdomain][]" value="" class="frontBox"><br />
				<span class="headLine">srv_hostname </span> <input type="text" name="srv[hostname][]" value="" class="frontBox"><br />
				<span class="headLine">srv_port </span> <input type="text" name="srv[port][]" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>TXT</b> <br/>
				<span class="headLine">txt_subdomain </span> <input type="text" name="txt[subdomain][]" value="" class="frontBox"><br />
				<span class="headLine">txt_text </span> <input type="text" name="txt[text][]" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td><input value="Create DNS" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
