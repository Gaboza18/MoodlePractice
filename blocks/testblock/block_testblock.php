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

/*
  제목: Block Plugin
  날짜: 22.08.08
  내용: 1. dash board 에서 test block 추가한다(admin 관리 포함)
        2. Site administration/Plugins/Blocks/test block/Show courses 체크시 강좌 내용 출력
        3. 미체크시 사용자 목록 출력한다
*/

/**
 * Form for editing HTML block instances.
 *
 * @package   block_testblock
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_testblock extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_testblock');
    }

    function has_config(){
        return true;
    }

    function get_content() {

        global $DB; // DB 연결

        if ($this->content !== NULL) {
            return $this->content;
        }

        // $userstring = ''; // 사용자 정보
        $content = ''; 

        $showcourses = get_config('block_testblock','showcourses');

        if($showcourses){

            /* 강좌 정보 출력 */
            $courses = $DB->get_records('course'); // 강좌 테이블의 정보 가져온다 $courses 변수에 담는다
        
            foreach($courses as $course){
                $content .= $course->fullname . '<br>';
            }
        }else{

            /* 사용자 정보 출력 */
            $users = $DB->get_records('user'); // user 테이블의 정보 가져온다 users 변수에 담는다

            foreach($users as $user){
                $content .= $user->firstname . ' ' . $user->lastname . '<br>';
            }
        }

        $this->content = new stdClass;
        $this->content->text = $content; 
        $this->content->footer = "이 구역은 footer 입니다.";

        return $this->content;
    }
}
