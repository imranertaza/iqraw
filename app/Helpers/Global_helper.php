<?php
function DB()
{
    $db = \Config\Database::connect();
    return $db;
}

function newSession()
{
    $session = \Config\Services::session();
    return $session;
}

function statusView($selected = '1')
{
    $status = [
        '0' => 'Inactive',
        '1' => 'Active',
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= ($selected == $key) ? $option : '';
    }
    return $row;
}

function globalStatus($selected = 'sel')
{
    $status = [
        'sel' => '--Select--',
        '1' => 'Active',
        '0' => 'Inactive',
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected == $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    return $row;
}

function getListInOption($selected, $tblId, $needCol, $table)
{
    $db = \Config\Database::connect();
    $tabledta = $db->table($table);
    $query = $tabledta->get();
    $options = '';
    foreach ($query->getResult() as $value) {
        $options .= '<option value="' . $value->$tblId . '" ';
        $options .= ($value->$tblId == $selected) ? ' selected="selected"' : '';
        $options .= '>' . $value->$needCol . '</option>';
    }
    return $options;
}

function isCheck($checked = 0, $match = 1)
{
    $checked = ($checked);
    return ($checked == $match) ? 'checked="checked"' : '';
}

function getCurrency($selected = '&pound')
{
    $codes = [
        '&pound' => "&pound; GBP",
        '&dollar' => "&dollar; USD",
        '&nira' => "&#x20A6; NGN"
    ];

    $row = '<select name="data[Setting][Currency]" class="form-control">';
    foreach ($codes as $key => $option) {
        $row .= '<option value="' . htmlentities($key) . '"';
        $row .= ($selected == $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    $row .= '</select>';
    return $row;
}

function globalDateTimeFormat($datetime = '0000-00-00 00:00:00')
{

    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return 'Unknown';
    }
    return date('h:i A d/m/y', strtotime($datetime));
}

function invoiceDateFormat($datetime = '0000-00-00 00:00:00')
{

    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return 'Unknown';
    }
    return date('d M Y h:i A ', strtotime($datetime));
}

function get_data_by_id($needCol, $table, $whereCol, $whereInfo)
{
    $db = \Config\Database::connect();
    $tabledta = $db->table($table);
    $findResult = $tabledta->select($needCol)->where($whereCol, $whereInfo)->countAllResults();

    if ($findResult > 0) {
        $tabledta2 = $db->table($table);
        $result = $tabledta2->select($needCol)->where($whereCol, $whereInfo)->get()->getRow();
        $col = ($result->$needCol == NULL) ? NULL : $result->$needCol;
    } else {
        $col = '';
    }
    return $col;
}

function numberView($num){
    if (!empty($num)){
        $result = number_format($num);
    }else{
        $result =  number_format("0");
    }
    return $result;
}

function already_join_check($quiz_exam_info_id){
    $tabledta = DB()->table('quiz_exam_joined');
    $data = $tabledta->where('std_id',newSession()->std_id)->where('quiz_exam_info_id',$quiz_exam_info_id)->get()->getRow();

    if (!empty($data)){
        $result = 1;
    }else{
        $result = 0;
    }

    return $result;
}

function get_subID_by_exam($subject_id){
    $tabledta = DB()->table('quiz_exam_info');
    $total = $tabledta->where('subject_id',$subject_id)->countAllResults();
    return $total;
}

function get_subID_by_done_exam($subject_id){
    $tabledta = DB()->table('quiz_exam_joined');
    $total = $tabledta->select('*')->join('quiz_exam_info','quiz_exam_info.quiz_exam_info_id = quiz_exam_joined.quiz_exam_info_id')->where('quiz_exam_info.subject_id',$subject_id)->countAllResults();
    return $total;
}

function already_join_mcq_check($skill_video_id){
    $tabledta = DB()->table('mcq_exam_joined');
    $data = $tabledta->where('std_id',newSession()->std_id)->where('skill_video_id',$skill_video_id)->get()->getRow();

    if (!empty($data)){
        $result = 1;
    }else{
        $result = 0;
    }

    return $result;
}


function already_join_chapter_check($chapterId){
    $tabledta = DB()->table('chapter_exam_joined');
    $data = $tabledta->where('std_id',newSession()->std_id)->where('chapter_id',$chapterId)->get()->getRow();

    if (!empty($data)){
        $result = 1;
    }else{
        $result = 0;
    }

    return $result;
}

function already_join_voc_exam_check($voc_exam_id){
    $tabledta = DB()->table('vocabulary_exam_joined');
    $data = $tabledta->where('std_id',newSession()->std_id)->where('voc_exam_id',$voc_exam_id)->get()->getRow();

    if (!empty($data)){
        $result = 1;
    }else{
        $result = 0;
    }

    return $result;
}
