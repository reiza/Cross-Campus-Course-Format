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
                    'default' => 'MONA',
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
                    'element_type' => 'text',
                ),
                'm5mappingcampusid' => array(
                    'label' => new lang_string('m5mappingcampusid', 'format_uwishared'),
                    'help' => 'm5mappingcampusid',
                    'help_component' => 'format_uwishared',
                    'element_type' => 'text',
                )
            );
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }
}
