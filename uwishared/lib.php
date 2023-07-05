<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 *  Format base class.
 *
 * @package     format_uwishared
 * @copyright   2023 UWI OC
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/format/lib.php');

class format_uwishared extends core_courseformat\base {

    public function uses_indentation(): bool {
        return false;
    }

    /**
     * Returns the information about the ajax support in the given source format.
     *
     * The returned object's property (boolean)capable indicates that
     * the course format supports Moodle course ajax features.
     *
     * @return stdClass
     */
    public function supports_ajax() {
        $ajaxsupport = new stdClass();
        $ajaxsupport->capable = true;
        return $ajaxsupport;
    }

     public function get_view_url( $section, $options = array( ) ) {
        return null;
    }

    public function extend_course_navigation( $navigation, navigation_node $node ) {
    }

    public function get_default_blocks( ) {
        return array(
             BLOCK_POS_LEFT => array( ),
            BLOCK_POS_RIGHT => array( )
        );
    }

    public function course_format_options( $foreditform = false ) {
        $baseurl  = get_config( 'format_uwishared' )->smiurl;
        $sc       = array( );
        $json     = download_file_content( $baseurl . '/sharedcourses.php' );
	$jsondata = (array) json_decode( $json );

        if ( $jsondata ) {
            foreach ($jsondata as $key => $value) {
                $sc[$value->idnumber] = $value->fullname . ' / XRN: ' . $value->idnumber;
            }
        }

        static $courseformatoptions = false;

        if ( $courseformatoptions === false ) {
            $courseformatoptions = array(
                 'smicourseid' => array(
                     'default' => '',
                    'type' => PARAM_TEXT
                )
            );
        }

        if ( $foreditform && !isset( $courseformatoptions['smicourseid']['label'] ) ) {
            $courseformatoptionsedit = array(
                 'smicourseid' => array(
                     'label' => new lang_string( 'smicourseid', 'format_uwishared' ),
                    'help' => 'smicourseid',
                    'help_component' => 'format_uwishared',
                    'element_type' => 'select',
                    'element_attributes' => array(
                         $sc
                    )
                )
            );
            $courseformatoptions     = array_merge_recursive( $courseformatoptions, $courseformatoptionsedit );
        }
        return $courseformatoptions;
    }

    public function page_set_course( moodle_page $page ) {
    }

}

