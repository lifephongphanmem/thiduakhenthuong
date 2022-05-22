<?php
function getPermissionDefault($level) {
    $roles = array();
//Quyền tỉnh
    $roles['T'] = array(
        //Thi đua khen thưởng thời kỳ kháng chiến
        'tdktkhangchien'=>array(
            'index'=>1,
        ),
            'chongphapcanhan'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'chongmycanhan'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'chongmygiadinh'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'ktthutuong'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'ktctubnd'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'kyniemchuong'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
        //Thi đua khen thưởng các cấp
        'tdktcaccap'=>array(
            'index'=>1,
        ),
            'dangkytd'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'duyetdktd'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'laphosotd'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'trinhhoso'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'duyethoso'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
        'duyethosocapduoi'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),

        //quản lý tài liệu liên quan
        'qltailieu'=>array(
            'index'=>1,
        ),
            'qlquyetdinhkt'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qltotrinhkt'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qlbienban'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qlfile'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qlphontraotd'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
        //Hiệp Y khen thưởng
        'hiepykhenthuong'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Quản lý quỹ TĐKT
        'qlquytdkt'=>array(
            'index'=>1,
        ),
            'qldauvao'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qlchihdtdkt'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'qldmchi'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
            'baocaoquy'=>array(
                'index'=>1,
                'create'=>1,
                'edit'=>1,
                'delete'=>1,
                'approve'=>1,
            ),
        //Quản lý văn bản pháp lý, hướng dẫn, hỏi đáp
        'qlvbnn'=>array(
            'index'=>1,
        ),
        'vbpq'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'vbhd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlhoidap'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //System
        'system'=>array(
            'index'=>1,
        ),
        'qlnguoisd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qlnhomngioisd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'nhatky'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        //End System
        //Danh mục
        'danhmuc'=>array(
            'index'=>1,
        ),
        'qldanhhieutd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qltieuchuantd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'qlhinhthuckt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmloaihinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmhinhthuctd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
    );
    $roles['H'] = array();
    $roles['X'] = array();
    /*
    $roles['H'] = array(
        //Thi đua khen thưởng thời kỳ kháng chiến
        'tdktkhangchien'=>array(
            'index'=>1,
        ),
        'chongphapcanhan'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'chongmycanhan'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'chongmygiadinh'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'ktthutuong'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'ktctubnd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'kyniemchuong'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Thi đua khen thưởng các cấp
        'tdktcaccap'=>array(
            'index'=>1,
        ),
        'dangkytd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'duyetdktd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'laphosotd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'trinhhoso'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'duyethoso'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'duyethosocapduoi'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'chuyenhosocaptren'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //quản lý tài liệu liên quan
        'qltailieu'=>array(
            'index'=>1,
        ),
        'qlquyetdinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qltotrinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlbienban'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlfile'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlphontraotd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Hiệp Y khen thưởng
        'hiepykhenthuong'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Quản lý quỹ TĐKT
        'qlquytdkt'=>array(
            'index'=>1,
        ),
        'qldauvao'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlchihdtdkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qldmchi'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'baocaoquy'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Quản lý văn bản pháp lý, hướng dẫn, hỏi đáp
        'qlvbnn'=>array(
            'index'=>1,
        ),
        'vbpq'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'vbhd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlhoidap'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //System
        'system'=>array(
            'index'=>1,
        ),
        'qlnguoisd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qlnhomngioisd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'nhatky'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        //End System
        //Danh mục
        'danhmuc'=>array(
            'index'=>1,
        ),
        'qldanhhieutd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qltieuchuantd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'qlhinhthuckt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmloaihinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmhinhthuctd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
    );
    $roles['X'] = array(
        //Thi đua khen thưởng thời kỳ kháng chiến

        //Thi đua khen thưởng các cấp
        'tdktcaccap'=>array(
            'index'=>1,
        ),
        'dangkytd'=>array(
            'index'=>0,
            'create'=>0,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'duyetdktd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'laphosotd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'trinhhoso'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'duyethoso'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'chuyenhosocaptren'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //quản lý tài liệu liên quan
        'qltailieu'=>array(
            'index'=>1,
        ),
        'qlquyetdinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qltotrinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlbienban'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlfile'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlphontraotd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Hiệp Y khen thưởng
        'hiepykhenthuong'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Quản lý quỹ TĐKT
        'qlquytdkt'=>array(
            'index'=>1,
        ),
        'qldauvao'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlchihdtdkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qldmchi'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'baocaoquy'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //Quản lý văn bản pháp lý, hướng dẫn, hỏi đáp
        'qlvbnn'=>array(
            'index'=>1,
        ),
        'vbpq'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'vbhd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        'qlhoidap'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
            'approve'=>1,
        ),
        //System
        'system'=>array(
            'index'=>1,
        ),
        'qlnguoisd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qlnhomngioisd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'nhatky'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        //End System
        //Danh mục
        'danhmuc'=>array(
            'index'=>1,
        ),
        'qldanhhieutd'=> array(
            'index'=>1,
            'create' => 1,
            'edit' => 1,
            'delete' => 1,
        ),
        'qltieuchuantd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'qlhinhthuckt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmloaihinhkt'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
        'dmhinhthuctd'=>array(
            'index'=>1,
            'create'=>1,
            'edit'=>1,
            'delete'=>1,
        ),
    );
    */
//End Quyền tỉnh

    return json_encode($roles[$level]);

}

function getDayVn($date) {
    if($date != null || $date != '')
        $newday = date('d/m/Y',strtotime($date));
    else
        $newday='';
    return $newday;
}

function getDateTime($date) {
    if($date != null)
        $newday = date('d/m/Y H:i:s',strtotime($date));
    else
        $newday='';
    return $newday;
}

function getDbl($obj) {
    $obj=str_replace(',','',$obj);
    $obj=str_replace('.','',$obj);
    if(is_numeric($obj)){
        return $obj;
    }else
        return 0;
}


function canEdit($trangthai){
    if(session('admin')->level == 'SSA')
       return true;
    else{
        if ($trangthai == 'CC' || $trangthai == 'BTL') {
            return true;
        } else {
            return false;
        }
    }
}

function canChuyenXoa($trangthai){
    if($trangthai == 'CC' || $trangthai == 'BTL')
        return true;
    else
        return false;
}

function canShowLyDo($trangthai){
    if($trangthai == 'BTL')
        return true;
    else
        return false;
}

function canApprove($trangthai){
    if($trangthai == 'CD')
        return true;
    else
        return false;
}


function getDouble($str)
{
    $sKQ = 0;
    $str = str_replace(',','',$str);
    $str = str_replace('.','',$str);
    //if (is_double($str))
        $sKQ = $str;
    return floatval($sKQ);
}

function chuyenkhongdau($str)
{
    if (!$str) return false;
    $utf8 = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ|Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);
     return $str;
}

function chuanhoachuoi($text)
{
    $text = strtolower(chuyenkhongdau($text));
    $text = str_replace("ß", "ss", $text);
    $text = str_replace("%", "", $text);
    $text = preg_replace("/[^_a-zA-Z0-9 -]/", "", $text);
    $text = str_replace(array('%20', ' '), '-', $text);
    $text = str_replace("----", "-", $text);
    $text = str_replace("---", "-", $text);
    $text = str_replace("--", "-", $text);
    return $text;
}

function chuanhoatruong($text)
{
    $text = strtolower(chuyenkhongdau($text));
    $text = str_replace("ß", "ss", $text);
    $text = str_replace("%", "", $text);
    $text = preg_replace("/[^_a-zA-Z0-9 -]/", "", $text);
    $text = str_replace(array('%20', ' '), '_', $text);
    $text = str_replace("----", "_", $text);
    $text = str_replace("---", "_", $text);
    $text = str_replace("--", "_", $text);
    return $text;
}


function getDateToDb($value){
    if($value==''){return null;}
    $str =  strtotime(str_replace('/', '-', $value));
    $kq = date('Y-m-d', $str);
    return $kq;
}

function getMoneyToDb ($value){
    if($value == ''){
        $kq = 0;
    }else {
        $kq = str_replace(',', '', $value);
        $kq = str_replace('.', '', $kq);
    }
    return $kq;
}

function getDoubleToDb ($value){
    if($value == ''){
        $kq = 0;
    }else {
        $kq = str_replace(',', '', $value);
    }
    return $kq;
}

function getDecimalToDb($value){
    if($value == ''){
        $kq = 1;
    }else {
        $kq = str_replace(',', '.', $value);
    }
    return $kq;
}

function getRandomPassword(){
    $bytes = random_bytes(3); // length in bytes
    $kq = (bin2hex($bytes));
    return $kq;
}

function getSoNnSelectOptions() {

    $start = '1';
    $stop = '10';
    $options = array();

    for ($i = $start;  $i <= $stop; $i++) {

        $options[$i] = $i;
    }
    return $options;
}


function Thang2Quy($thang){
    if($thang == 1 || $thang == 2 || $thang == 3)
        return 1;
    elseif($thang == 4 || $thang == 5 || $thang == 6)
        return 2;
    elseif($thang == 7 || $thang == 8 || $thang == 9)
        return 3;
    else
        return 4;
}

function dinhdangso ($number , $decimals = 0, $unit = '1' , $dec_point = ',' , $thousands_sep = '.' ) {
    if(!is_numeric($number) || $number == 0){return '';}
    $r = $unit;

    switch ($unit) {
        case 2:{
            $decimals = 3;
            $r = 1000;
            break;
        }
        case 3:{
            $decimals = 5;
            $r = 1000000;
            break;
        }
    }

    $number = round($number / $r , $decimals);
    return number_format($number, $decimals ,$dec_point, $thousands_sep);
}

function IntToRoman($number)
{
    $roman = '';
    while ($number >= 1000) {
        $roman .= "M";
        $number -= 1000;
    }
    if ($number >= 900) {
        $roman .= "CM";
        $number -= 900;
    }
    if ($number >= 500) {
        $roman .= "D";
        $number -= 500;
    }
    if ($number >= 400) {
        $roman .= "CD";
        $number -= 400;
    }
    while ($number >= 100) {
        $roman .= "C";
        $number -= 100;
    }
    if ($number >= 90) {
        $roman .= "XC";
        $number -= 90;
    }
    if ($number >= 50) {
        $roman .= "L";
        $number -= 50;
    }
    if ($number >= 40) {
        $roman .= "XL";
        $number -= 40;
    }
    while ($number >= 10) {
        $roman .= "X";
        $number -= 10;
    }
    if ($number >= 9) {
        $roman .= "IX";
        $number -= 9;
    }
    if ($number >= 5) {
        $roman .= "V";
        $number -= 5;
    }
    if ($number >= 4) {
        $roman .= "IV";
        $number -= 4;
    }
    while ($number >= 1) {
        $roman .= "I";
        $number -= 1;
    }
    return $roman;
}

function toAlpha($data){
    $alphabet =   array('','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $alpha_flip = array_flip($alphabet);
    if($data <= 25){
        return $alphabet[$data];
    }
    elseif($data > 25){
        $dividend = ($data + 1);
        $alpha = '';
        $modulo='';
        while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
        }
        return $alpha;
    }
}

function romanNumerals($num)
{
    $n = intval($num);
    $res = '';

    /*** roman_numerals array  ***/
    $roman_numerals = array(
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1);

    foreach ($roman_numerals as $roman => $number)
    {
        /*** divide to get  matches ***/
        $matches = intval($n / $number);

        /*** assign the roman char * $matches ***/
        $res .= str_repeat($roman, $matches);

        /*** substract from the number ***/
        $n = $n % $number;
    }

    /*** return the res ***/
    return $res;
}

function getvbpl($str){
    $str = str_replace(',','',$str);
    $str = str_replace('.','',$str);
    $str = str_replace('/','',$str);
    $str = str_replace(' ','',$str);
    $str = chuyenkhongdau($str);
    return $str;
}

function VndText($amount)
{
    if($amount <=0)
    {
        return 0;
    }
    $Text=array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
    $TextLuythua =array("","nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
    $textnumber = "";
    $length = strlen($amount);

    for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;

    for ($i = 0; $i < $length; $i++)
    {
        $so = substr($amount, $length - $i -1 , 1);

        if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
            for ($j = $i+1 ; $j < $length ; $j ++)
            {
                $so1 = substr($amount,$length - $j -1, 1);
                if ($so1 != 0)
                    break;
            }

            if (intval(($j - $i )/3) > 0){
                for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                    $unread[$k] =1;
            }
        }
    }

    for ($i = 0; $i < $length; $i++)
    {
        $so = substr($amount,$length - $i -1, 1);
        if ($unread[$i] ==1)
            continue;

        if ( ($i% 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i/3] ." ". $textnumber;

        if ($i % 3 == 2 )
            $textnumber = 'trăm ' . $textnumber;

        if ($i % 3 == 1)
            $textnumber = 'mươi ' . $textnumber;


        $textnumber = $Text[$so] ." ". $textnumber;
    }

    //Phai de cac ham replace theo dung thu tu nhu the nay
    $textnumber = str_replace("không mươi", "lẻ", $textnumber);
    $textnumber = str_replace("lẻ không", "", $textnumber);
    $textnumber = str_replace("mươi không", "mươi", $textnumber);
    $textnumber = str_replace("một mươi", "mười", $textnumber);
    $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
    $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
    $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

    return ucfirst($textnumber." đồng chẵn.");
}

function trim_zeros($str) {
    if(!is_string($str)) return $str;
    return preg_replace(array('`\.0+$`','`(\.\d+?)0+$`'),array('','$1'),$str);
}

function dinhdangsothapphan ($number , $decimals = 0) {
    if(!is_numeric($number) || $number == 0){return '';}
    $number = round($number , $decimals);
    $str_kq = trim_zeros(number_format($number, $decimals ));
    /*for ($i = 0; $i < strlen($str_kq); $i++){
        if($str_kq[$i]== '.'){
            $str_kq[$i]= ',';
        }elseif($str_kq[$i]== ','){
            $str_kq[$i]= '.';
        }
    }*/
    //$a_so = str_split($str_kq);

    //$str_kq = str_replace(",", ".", $str_kq);
    //$str_kq = str_replace(".", ",", $str_kq);
    return $str_kq;
    //return number_format($number, $decimals ,$dec_point, $thousands_sep);
    //làm lại hàm chú ý đo khi các số thập phân nếu làm tròn thi ko bỏ dc số 0 đằng sau dấu ,
    // round(5.4,4) = 5,4000
}

function chkDbl($obj) {
    $obj=str_replace(',','',$obj);
    $obj=str_replace('%','',$obj);
    if(is_numeric($obj)){
        return $obj;
    }else {
        return 0;
    }
}

function emailValid($email)
{
    $pattern = '#^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#';
    if(preg_match($pattern, $email))
        return true;
    else
        return false;
}

?>