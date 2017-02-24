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

$sql = "SELECT
          u.username,
          c.shortname as 'remotecourseshortname',
          r.id as 'remoteroleid',
          r.name as 'remoterolename',
          r.shortname as 'remoteroleshortname',
          cfo.value as 'smicourseid'
        FROM
          {role_assignments} ra
        JOIN {user} u ON ra.userid = u.id
        JOIN {context} ctx ON ra.contextid = ctx.id
        JOIN {course} c ON ctx.instanceid=c.id
        JOIN {role} r ON ra.roleid=r.id
        JOIN {course_format_options} cfo
            ON      cfo.courseid=c.id
                AND cfo.name='smicourseid'
								WHERE u.username = ?";

$enrolment = $DB->get_records_sql($sql, array($userid));

if ($enrolment) {
  foreach ($enrolment as $user => $enrols) {
    $o->xrns[$enrols->smicourseid] = $enrols->remoteroleid;
  }
}

header('Content-Type: application/json');
echo json_encode($o);

?>
