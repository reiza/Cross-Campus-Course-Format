<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
require_once('./../../../../config.php');
global $CFG, $DB;

require_once($CFG->libdir.'/moodlelib.php');
require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');

$USER = FALSE;
$USER = $DB->get_record('user', array('id'=>$userid),'id, username, idnumber, firstname, lastname, email, institution, department, address, city, country, timezone');
if ($USER) {
	// custom logic for user result
}

header('Content-Type: application/json');
echo json_encode($USER);

?>
