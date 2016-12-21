<?php

require_once('includes/config.php');

function get_timeago( $ptime ) {
    $estimate_time = time() - $ptime;

    if ( $estimate_time < 1 ) {
        return 'less than 1 second ago';
    }

    $condition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach ( $condition as $secs => $str ) {
        $d = $estimate_time / $secs;

        if ( $d >= 1 ) {
            $r = round( $d );
            return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}

if ($details == true) {

    if ($dbtype === 'pgsql') {
        $where = "date_part('year', created) = date_part('year', CURRENT_DATE)";
    } else {
        $where = "YEAR(created) = YEAR(CURDATE())";
    }

$sql = <<<SQL
    SELECT *
    FROM {$table}
    WHERE $where AND campaign = $campaign
SQL;

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
    	require_once('includes/pledges.php');
    }

} else {

    if ($dbtype === 'pgsql') {
        $where = "date_part('year', created) = date_part('year', CURRENT_DATE)";
    } else {
        $where = "YEAR(created) = YEAR(CURDATE())";
    }

$sql = <<<SQL
    SELECT amount
    FROM {$table}
    WHERE $where AND campaign = $campaign
SQL;

    if (!$result = $db->query($sql)) {
        die('There was an error running the query [' . $db->error . ']');
    } else {
        $total = '';
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $total = (int) $total + (int) $row['amount'];
        }
        require_once('includes/summary.php');
    }

}

?>