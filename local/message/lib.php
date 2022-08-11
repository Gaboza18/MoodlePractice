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
 * @var stdClass $plugin
 * 
 * 날짜: 22.08.09
 * 내용: local_message 테이블 sql문 설정
 */

 function local_message_before_footer(){

     // die('hello'); // die() 함수는 메시지를 출력하고, 현재 스크립트를 종료한다.

     global $DB, $USER;
     // $messages = $DB->get_records('local_message'); // 로컬 메세지 테이블 레코드 가져온다
     
     $sql = "SELECT lm.id, lm.messagetext, lm.messagetype 
                FROM {local_message} lm 
                    LEFT OUTER JOIN {local_message_read} lmr ON lm.id = lmr.messageid
                        WHERE lmr.userid <> :userid OR lmr.userid IS NULL";

    $pararms = [
        'userid' => $USER->id,
    ];
    
    $messages = $DB->get_records_sql($sql, $pararms);

     foreach($messages as $message){

        $type = \core\output\notification::NOTIFY_INFO;

        if($message->messagetype === '0'){
            $type = \core\output\notification::NOTIFY_WARNING;
        }

        if($message->messagetype === '1'){
            $type = \core\output\notification::NOTIFY_SUCCESS;
        }

        if($message->messagetype === '2'){
            $type = \core\output\notification::NOTIFY_ERROR;
        }

        \core\notification::add($message->messagetext, $type);

        $readrecord = new stdClass();
        $readrecord->messageid = $message->id;
        $readrecord->userid =  $USER->id;
        $readrecord->timeread = time(); // php 라이브러리
        $DB->insert_record('local_message_read', $readrecord);
     }

     /* 
        DashBoard에 메세지 출력
        \core\notification::add('화면에 보일 문자', \core\output\notification::NOTIFY_알림 유형);

        NOTIFY_SUCCESS 
        NOTIFY_WARNING 
        NOTIFY_ERROR($message);
        NOTIFY_INFO($message);
    */
    // \core\notification::add('MoodleTest 에 오신 여러분 환영합니다!', \core\output\notification::NOTIFY_INFO); // 화면에 알림 메세지 출력
}