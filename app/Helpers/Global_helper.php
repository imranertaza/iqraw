<?php
function DB()
{
    $db = \Config\Database::connect();
    return $db;
}
function Cart(){
    $ca = \Config\Services::cart();
    return $ca;
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


function invoiceStatusView($selected = '1')
{
    $status = [
        '0' => 'Unpaid',
        '1' => 'Paid',
        '2' => 'Pending',
        '3' => 'cancel',
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= ($selected == $key) ? $option : '';
    }
    return $row;
}

function orderStatusInOption($sel = '0')
{
    $status = [
        0 => 'unpaid',
        1 => 'paid',
        2 => 'Pending',
        3 => 'cancel'
    ];
    $row = '<option value="">Please select</option>';
    foreach ($status as $key => $option) {
        $s = ($key == $sel)?'selected':'';
        $row .= '<option value="'.$key.'" '.$s.'>'.$option.'</option>';
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

function getListInOptionParentIdBySub($selected, $tblId, $needCol, $table,$whereParent,$parentID)
{
    $db = \Config\Database::connect();
    $tabledta = $db->table($table);
    $query = $tabledta->where($whereParent,$parentID)->get();
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

function get_all_data_by_id($table, $whereCol, $whereInfo){
    $db = \Config\Database::connect();

    $tabledta = $db->table($table);
    $findResult = $tabledta->where($whereCol, $whereInfo)->get()->getResult();

    return $findResult;
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
    $total = $tabledta->where('subject_id',$subject_id)->where('published_date <',date('Y-m-d'))->countAllResults();
    return $total;
}

function get_subID_by_upcoming_exam($subject_id){
    $tabledta = DB()->table('quiz_exam_info');
    $total = $tabledta->where('subject_id',$subject_id)->where('published_date >',date('Y-m-d'))->countAllResults();
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

function pro_parent_category_by_category_id($id)
{
    $session = newSession();
    $table = DB()->table('product_category');
    $query = $table->where('parent_pro_cat_id', $id);
    $row = $query->countAllResults();
    if (!empty($row)) {
        $prId = get_data_by_id('parent_pro_cat_id', 'product_category', 'parent_pro_cat_id', $id);
        $table2 = DB()->table('product_category');
        $query2 = $table2->where('prod_cat_id', $prId);
        $catName = $query2->get()->getRow();
        $view = (!empty($catName)) ? $catName->product_category : 'No parent';
    } else {
        $view = "No parent";
    }
    return $view;
}

function no_image_view($image_path,$no_image_path,$imageName = '1'){
    $imgPathcheck = FCPATH.$image_path;
    if ((empty($imageName))||(!file_exists($imgPathcheck))){
        return base_url().$no_image_path;
    }else{
        return base_url().$image_path;
    }
}

function unitInOptionArray($selec = '1')
{
    $status = [
        '1' => 'Piece',
        '2' => 'KG',
        '3' => 'LETTER',
        '4' => 'TON'
    ];
    $options = '';
    foreach ($status as $key => $value) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selec) ? ' selected="selected"' : '';
        $options .= '>' . $value . '</option>';
    }
    return $options;
}

function productTypeInOption($selec = '0')
{
    $status = [
        '1' => 'Regular',
        '2' => 'Temporary',
    ];
    $options = '';
    foreach ($status as $key => $value) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selec) ? ' selected="selected"' : '';
        $options .= '>' . $value . '</option>';
    }
    return $options;
}
function unitArray()
{
    $status = [
        '1' => 'Piece',
        '2' => 'KG',
        '3' => 'LETTER',
        '4' => 'TON'
    ];
    return $status;
}
function showUnitName($selected = '1')
{
    $status = unitArray();
    $row = $status[$selected];
    return $row;
}

function  proSubCatListInOption($categoryId,$selected){
    $table = DB()->table('product_category');
    $query = $table->where('prod_cat_id', $categoryId);
    $row = $query->countAllResults();
    $view = '<option value="" >Please Select</option>';
    if (!empty($row)) {
        $table2 = DB()->table('product_category');
        $query2 = $table2->where('parent_pro_cat_id', $categoryId)->get()->getResult();
        foreach ($query2 as $item) {
            $sel = ($item->prod_cat_id == $selected)?'selected':'';
            $view .= '<option value="'.$item->prod_cat_id.'" '.$sel.'>'.$item->product_category.'</option>';
        }
    }
    return $view;
}

function get_category_link_by_name($name,$url){

    $table = DB()->table('product_category');
    $table->where('product_category', $name);
    $data = $table->get()->getRow();

    if (!empty($data)){
        $link = $url.'/'.$data->prod_cat_id;
    }else{
        $link = '#';
    }
    return $link;
}

function check_subscribe_by_course_id($course_id){
    $std_id = newSession()->std_id;
    $table = DB()->table('course_subscribe');
    $table->where('course_id', $course_id);
    $table->where('std_id', $std_id);
    $table->where('status', '1');
    $data = $table->get()->getRow();

    if (!empty($data)){
        $result = 1;
    }else{
        $result = 0;
    }
    return $result;

}

function course_main_category($selected){
    $table = DB()->table('course_category');
    $query = $table->where('parent_course_cat_id',null)->where('status','1')->get()->getResult();

    $view = '<option value="" >Please Select</option>';
    foreach ($query as $item) {
        $sel = ($item->course_cat_id == $selected)?'selected':'';
        $view .= '<option value="'.$item->course_cat_id.'" '.$sel.'>'.$item->category_name.'</option>';
    }
    return $view;

}

function get_all_array_data_by_id($table, $whereCol, $whereInfo)
{
    $db = \Config\Database::connect();
    $tabledta = $db->table($table);
    $result = $tabledta->where($whereCol, $whereInfo)->get()->getResult();
    return $result;
}

