<?php
defined('MOODLE_INTERNAL') || die();

class format_uwishared_renderer extends plugin_renderer_base {

    public function display($course) {
        $courserenderer = $this->page->get_renderer('core', 'course');
        global $CFG;
        //print_r();die;
        require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');

        $course = course_get_format($course)->get_course();
        $package = new CryptoForUWISharedCourse();
        $param = substr(uniqid(),-1);

        $redirectUrl = "http://localhost/moodleone/auth/ocauth/acs.php?$param=" . $package->wrap($course);
        $output = '<a class="btn btn-lg btn-primary" style="margin:20px;color:#fff" href="' . $redirectUrl . '">Go to the shared course</a>';
        return $output;
    }
}
