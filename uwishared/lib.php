<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package format_uwishared
 * @copyright OC Dev Team
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined( 'MOODLE_INTERNAL' ) || die( );

require_once( $CFG->dirroot . '/course/format/lib.php' );

class format_uwishared extends format_base {

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
