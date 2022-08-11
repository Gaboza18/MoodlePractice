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
 * 내용: 메세지 등록 페이지 구성
 */

require_once(__DIR__ . '/../../config.php'); // 디렉토리 파일 경로 포함시킨다
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');

global $DB; // DB 객체

$PAGE->set_url(new moodle_url('/local/message/edit.php')); // 현재 페이지 url 설정
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Edit'); // url 접속시 제목 설정

// 폼 출력
$mform = new edit();

    // 취소 버튼 누를시
    if ($mform->is_cancelled()) {

        // 관리 페이지로 이동
        redirect($CFG->wwwroot . '/local/message/manage.php', get_string('canceled_form', 'local_message'));

    } else if ($fromform = $mform->get_data()) {
    
        // Insert the data into our database table.
        $messagetext = $fromform->messagetext; // 메세지 내용입력 폼 설정
        $messagetype = $fromform->messagetype; // 메세지 종류 폼 설정

        $recordtoinsert = new stdClass();
        $recordtoinsert->messagetext = $fromform->messagetext; // 데이터 삽입시 DB에 저장하는 객체
        $recordtoinsert->messagetype = $fromform->messagetype; // 데이터 삽입시 DB에 저장하는 객체

        $DB->insert_record('local_message', $recordtoinsert); // local_message DB 삽입

         // 관리 페이지로 이동(DB에 저장후 이동)
         redirect($CFG->wwwroot . '/local/message/manage.php', get_string('create_form', 'local_message') . $fromform->messagetext);

    }

echo $OUTPUT->header(); // Moodle 페이지 header 함수 호출

    $mform->display(); // 메인 내용 출력

echo $OUTPUT->footer(); // Moodle 페이지 footer 함수 호출