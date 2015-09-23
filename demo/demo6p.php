<?php


if (isset($_POST['function'])) {
    require_once '../opensrs/openSRS_loader.php';

    $callstring = '';

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $searchstring = $firstname.' '.$lastname;

    $callArray = array(
        'func' => $_POST['function'],
        'data' => array('searchstring' => $searchstring),
        );

    $callstring = json_encode($callArray);
    // Open SRS Call -> Result
    $osrsHandler = processOpenSRS('json', $callstring);
    $json_out = $osrsHandler->resultFormatted;

    if (isset($json_out)) {
        echo '<table>';
        $json_a = json_decode($json_out, true);

        $counter = 0;
        foreach ($json_a[suggestion][items] as $item) {
            if ($item[status] == 'available') {
                $domain = preg_replace("/\./", '@', $item[domain], 1);
                if ($counter == 0) {
                    echo '<p id="available"><strong>'.$domain.'</strong> is available.</p>';
                    echo '<h2>Available Email Addresses</h2>';
                }
                $temp = ($counter % 2) + 1;
                echo '<tr class="listLine'.$temp.'";"><td>'.$domain.'</td><td>'.$item[status].'</td></tr>';
                ++$counter;
            }
            if ($counter == 20) {
                break;
            }
        }
        echo '</table>';
    }
}
