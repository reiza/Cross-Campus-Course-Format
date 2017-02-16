<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
require_once('./../../../../config.php');

global $CFG, $DB;
require_once($CFG->libdir.'/moodlelib.php');
require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');

$enrolment = FALSE;
$o = new StdClass();
$o->username = $userid;
$o->xrns = array();

// missing role id
$sql = "SELECT cfo.value as xrn
		FROM {user} u
		  JOIN {user_enrolments} ua ON u.id=ua.userid
          JOIN {enrol} e ON ua.enrolid = e.id
          -- JOIN {course} c ON e.courseid = c.id
		  JOIN {course_format_options} cfo ON e.courseid = cfo.courseid
          WHERE u.username = ?
          AND cfo.name = 'm5mappingcourseid'";
$enrolment = $DB->get_records_sql($sql, array($userid));

if ($enrolment) {

	foreach ($enrolment as $key => $value) {
		$o->xrns[$value->xrn] = '5';
	}
}

header('Content-Type: application/json');
echo json_encode($o);


?>
