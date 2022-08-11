<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * 
 * 날짜: 22.08.09
 * 내용: 메세지 종류에 따라 다른 폼으로 출력한다
 */
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
       
        $mform = $this->_form; // Don't forget the underscore! 

        $mform->addElement('text', 'messagetext', get_string('message_text', 'local_message')); // 메세지 종류
        $mform->setType('messagetext', PARAM_NOTAGS); // 메세지 내용
        $mform->setDefault('messagetext', get_String('enter_message','local_message')); // 메세지 입력칸 -> placehold 개념

        $choices = array(); // 메세지 종류 배열 선언
        
        $choices['0'] = \core\output\notification::NOTIFY_WARNING; // 경고 메세지
        $choices['1'] = \core\output\notification::NOTIFY_SUCCESS; // 성공 메세지
        $choices['2'] = \core\output\notification::NOTIFY_ERROR; // 에러 메세지
        $choices['3'] = \core\output\notification::NOTIFY_INFO; // 정보 메세지

        $mform->addElement('select', 'messagetype', get_string('message_type', 'local_message'), $choices);
        $mform->setDefault('messagetype','3');

        $this->add_action_buttons();
  
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}