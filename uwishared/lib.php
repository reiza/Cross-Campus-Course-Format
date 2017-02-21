<?php
/**
* @package   format_uwishared
* @copyright OC Dev Team
*/
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot. '/course/format/lib.php');

class format_uwishared extends format_base {

  public function get_view_url($section, $options = array()) {
    return null;
  }

  public function extend_course_navigation($navigation, navigation_node $node) { }

  public function get_default_blocks() {
    return array(
      BLOCK_POS_LEFT => array(),
      BLOCK_POS_RIGHT => array()
    );
  }


  public function course_format_options($foreditform = false) {
    $baseUrl = get_config('format_uwishared')->smiurl;
    $sc = array();
    $json = download_file_content($baseUrl.'/sharedcourses.php');
    $jsonData = (array) json_decode($json);

    if($jsonData){
      foreach ($jsonData as $key => $value) {
        $sc[$key]=$value->fullname . ' / XRN: ' . $value->idnumber;
      }
    }


    static $courseformatoptions = false;
    if ($courseformatoptions === false) {
      $courseformatoptions = array(
        'smicourseid' => array(
          'default' => '',
          'type' => PARAM_TEXT,
        )
      );
    }

    if ($foreditform && !isset($courseformatoptions['smicourseid']['label'])) {
      $courseformatoptionsedit = array(
        'smicourseid' => array(
          'label' => new lang_string('smicourseid', 'format_uwishared'),
          'help' => 'smicourseid',
          'help_component' => 'format_uwishared',
          'element_type' => 'select',
          'element_attributes' => array(
            $sc
          ),
        )
      );
      $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
    }
    return $courseformatoptions;
  }

  public function page_set_course(moodle_page $page) {
    global $CFG, $COURSE;
    require_once($CFG->dirroot. '/course/format/uwishared/tool/crypto.php');
    $baseUrl = get_config('format_uwishared')->smiurl;

    $course = course_get_format($COURSE)->get_course();
    $package = new CryptoForUWISharedCourse();
    $param = substr(uniqid(),-1);

    $redirectUrl = $baseUrl ."/auth/ocauth/acs.php?$param=" . $package->wrap($course);
    if (!is_siteadmin()) {
      redirect($redirectUrl);
    }
  }

}
