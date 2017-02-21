<?php
require_once('config.php');
require_once($CFG->libdir.'/moodlelib.php');

$sharedCoursesList = false;

$sql = "SELECT
          shortname, fullname, idnumber, visible
		    FROM
          {course} c
		    WHERE
          c.idnumber <> ''";

$sharedCoursesList = $DB->get_records_sql($sql);

header('Content-Type: application/json');
echo json_encode($sharedCoursesList);
