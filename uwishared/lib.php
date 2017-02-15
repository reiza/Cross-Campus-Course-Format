<?php
/**
 * This file contains main class for the course format UWI Shared Course
 *
 * @package   format_uwishared
 * @copyright OC Dev Team
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot. '/course/format/lib.php');

class format_uwishared extends format_base {

    /**
     * The URL to use for the specified course
     *
     * @param int|stdClass $section Section object from database or just field course_sections.section
     *     if null the course view page is returned
     * @param array $options options for view URL. At the moment core uses:
     *     'navigation' (bool) if true and section has no separate page, the function returns null
     *     'sr' (int) used by multipage formats to specify to which section to return
     * @return null|moodle_url
     */
    public function get_view_url($section, $options = array()) {
        return null;

	    if (!empty($options['navigation']) && $section !== null) {
            return null;
        }
        return new moodle_url('/course/view.php', array('id' => $this->courseid));
    }

    /**
     * Loads all of the course sections into the navigation
     *
     * @param global_navigation $navigation
     * @param navigation_node $node The course node within the navigation
     */
    public function extend_course_navigation($navigation, navigation_node $node) {
        // Social course format does not extend navigation, it uses social_activities block instead
    }

    /**
     * Returns the list of blocks to be automatically added for the newly created course
     *
     * @return array of default blocks, must contain two keys BLOCK_POS_LEFT and BLOCK_POS_RIGHT
     *     each of values is an array of block names (for left and right side columns)
     */
    public function get_default_blocks() {
        return array(
            BLOCK_POS_LEFT => array(),
            BLOCK_POS_RIGHT => array()
        );
    }

    /**
     * Definitions of the additional options that this course format uses for course
     *
     * social format uses the following options:
     * - numdiscussions
     *
     * @param bool $foreditform
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        static $courseformatoptions = false;
        if ($courseformatoptions === false) {
            $courseformatoptions = array(
                'm5mappingcourseid' => array(
                    'default' => '',
                    'type' => PARAM_TEXT,
                ),
                'm5mappingcampusid' => array(
                    'default' => '',
                    'type' => PARAM_TEXT,
                ),

            );
        }

        if ($foreditform && !isset($courseformatoptions['m5mappingcourseid']['label'])) {
            $courseformatoptionsedit = array(
                'm5mappingcourseid' => array(
                    'label' => new lang_string('m5mappingcourseid', 'format_uwishared'),
                    'help' => 'm5mappingcourseid',
                    'help_component' => 'format_uwishared',
                    'element_type' => 'select',
                    'element_attributes' => array(
                    	array(
                    		'XYZ123' => 'UWIS0001 Our First Shared Course',
	                    	'U230' => 'FOUN1101 Caribbean Civilisation',
		                    'U235' => 'MATH2002 Proofs and Analytical Methods',
							          'U238' => 'LAW3400 Advanced Law of Torts'
                    	)
                    ),
                ),
                'm5mappingcampusid' => array(
                    'label' => new lang_string('m5mappingcampusid', 'format_uwishared'),
                    'help' => 'm5mappingcampusid',
                    'help_component' => 'format_uwishared',
                    'element_type' => 'select',
                    'element_attributes' => array(
                    	array(
                    		'CAV' => 'Cave Hill',
	                    	'MON' => 'Mona',
		                    'OC' => 'Open Campus',
							'STA' => 'St. Augustine'
                    	)
                    ),
                )
            );
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }

    /**
     * Allows course format to execute code on moodle_page::set_course()
     *
     * This function is executed before the output starts.
     *
     * If everything is configured correctly, user is redirected from the
     * default course view page to the activity view page.
     *
     * "Section 1" is the administrative page to manage orphaned activities
     *
     * If user is on course view page and there is no module added to the course
     * and the user has 'moodle/course:manageactivities' capability, redirect to create module
     * form.
     *
     * @param moodle_page $page instance of page calling set_course
     */
    public function page_set_course(moodle_page $page) {
        global $CFG, $COURSE;
        require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');
        $baseUrl = get_config('format_uwishared')->m5url;

        $course = course_get_format($COURSE)->get_course();
        $package = new CryptoForUWISharedCourse();
        $param = substr(uniqid(),-1);

        //$redirectUrl = "https://my.open.uwi.edu/goto/sharedcourses/debug.php?$param=" . $package->wrap($course);
        $redirectUrl = $baseUrl ."/auth/ocauth/acs.php?$param=" . $package->wrap($course);
        if (!is_siteadmin()) {
        	redirect($redirectUrl);
        } else {
          //return $redirectUrl;
        }
    }

}
