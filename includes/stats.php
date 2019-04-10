<?php

require_once( 'includes/config.php' );

function get_timeago( $ptime ) {
	$estimate_time = time() - $ptime;

	if ( $estimate_time < 1 ) {
		return 'less than 1 second ago';
	}

	$condition = array(
		12 * 30 * 24 * 60 * 60 => 'year',
		30 * 24 * 60 * 60      => 'month',
		24 * 60 * 60           => 'day',
		60 * 60                => 'hour',
		60                     => 'minute',
		1                      => 'second',
	);

	foreach ( $condition as $secs => $str ) {
		$d = $estimate_time / $secs;

		if ( $d >= 1 ) {
			$r = round( $d );
			return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
		}
	}
}

if ( true === $details ) {

	if ( 'pgsql' === $dbtype ) {
		$where = "date_part('year', created) = date_part('year', CURRENT_DATE)";
	} else {
		$where = 'YEAR(created) = YEAR(CURDATE())';
	}

	/* start details sql */
	$sql = <<<SQL
		SELECT *
		FROM {$table}
		WHERE $where AND campaign = $campaign
SQL;
	/* end details sql */

	if ( ! $result = $db->query( $sql ) ) {
		die( 'There was an error running the query [' . $db->error . ']' );
	} else {
		require_once( 'includes/pledges.php' );
	}
} else {

	if ( 'pgsql' === $dbtype ) {
		$where = "date_part('year', created) = date_part('year', CURRENT_DATE)";
	} else {
		$where = 'YEAR(created) = YEAR(CURDATE())';
	}

	/* start board amount sql */
	$sql = <<<SQL
		SELECT amount
		FROM {$table}
		WHERE $where AND campaign = $campaign
SQL;
	/* end board amount sql */
	if ( ! $result = $db->query( $sql ) ) {
		die( 'There was an error running the query: [' . $db->error . ']' );
	} else {
		$total = '';
		while( $row = $result->fetch( PDO::FETCH_ASSOC ) ) {
			$total = (int) $total + (int) $row['amount'];
		}

		if ( true === $board_show_count ) {
			/* start board count sql */
			$sql_count = <<<SQL
				SELECT COUNT(*)
				FROM {$table}
				WHERE $where AND campaign = $campaign
SQL;
			/* end board amount sql */
			if ( ! $count_result = $db->query( $sql_count ) ) {
				die( 'There was an error running the query [' . $db->error . ']' );
			} else {
				$count = $count_result->fetchColumn();
				if ( 1 === $count ) {
					$word = 'pledge';
				} else {
					$word = 'pledges';
				}
			}
		}

		if ( 'pgsql' === $dbtype ) {
			$orderby = 'ORDER BY RANDOM()';
		} else {
			$orderby = 'ORDER BY RAND()';
		}
		/* start names (not displayed yet) sql */
		$sql_name = <<<SQL
			SELECT name
			FROM {$table}
			WHERE $where AND campaign = $campaign and name_displayed = 0 $orderby DESC LIMIT 1
		SQL;
		/* end names (not displayed yet) sql */
		if ( true === $board_show_names ) {
			$name_row_count = $db->query( $sql_name )->rowCount();
			if ( 0 === $name_row_count ) {
				$showed_name = false;
				/* start names (all) sql */
				$sql_name = <<<SQL
					SELECT name
					FROM {$table}
					WHERE $where AND campaign = $campaign $orderby DESC LIMIT 1
				SQL;
				/* end names (all) sql */
				if ( ! $name_result = $db->query( $sql_name ) ) {
					die( 'There was an error running the query [' . $db->error . ']' );
				} else {
					$name = $name_result->fetchColumn();
				}
			} else {
				$showed_name = true;
				if ( ! $name_result = $db->query( $sql_name ) ) {
					die( 'There was an error running the query [' . $db->error . ']' );
				} else {
					$name = $name_result->fetchColumn();
				}
			}

			if ( true === $showed_name && isset( $name ) && '' !== $name ) {
				/* start update displayed value for name sql */
				$sql_showed_name = <<<SQL
				UPDATE {$table}
					SET name_displayed = '1'
					WHERE name = "$name"
				SQL;
				/* end update displayed value for name sql */
				if ( ! $result = $db->query( $sql_showed_name ) ) {
					die( 'There was an error running the query [' . print_r( $db->errorInfo() ) . ']' );
				}
			}
		}

		require_once( 'includes/summary.php' );

	}
}
