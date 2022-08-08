<?php

/*
 admin/settings 오픈소스 참고

 관리자 모드 설정 블럭(test block)
*/

if($ADMIN->fulltree){
    $settings->add(new admin_setting_configcheckbox('block_testblock/showcourses',
               get_string('showcourses','block_testblock'),
               get_string('showcoursesdesc','block_testblock'), 
               0));
}