<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
require_once($CFG->dirroot. '/course/format/uwishared/crypto.php');
$course = course_get_format($course)->get_course();

$z = new CryptoForUWISharedCourse();

$redirectUrl = "https://my.open.uwi.edu/goto/sharedcourses/debug.php?z=" .$z->wrap($course);
if (is_siteadmin()) {
	echo '<a href="' . $redirectUrl . '">this is a test</a>';
} else {
	redirect($redirectUrl);
}

?>