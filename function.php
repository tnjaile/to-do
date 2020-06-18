<?php
function link_db()
{
    //實體化資料庫物件
    $mysqli = new mysqli(_DB_LOCATION, _DB_ID, _DB_PASS, _DB_NAME);
    if ($mysqli->connect_error) {
        throw new Exception('無法連上資料庫：' . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8");
    return $mysqli;
}

//失敗返回
function error($message, $refresh = '')
{
    global $smarty;
    $smarty->assign('page_title', '錯誤提示頁');
    $smarty->assign('message', $message);
    $smarty->assign('refresh', $refresh);
    $smarty->display('templates/error.tpl');
    exit();
}

// 判斷日期格式是否正確
function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d"))
{
    $unixTime = strtotime($date);
    if (!$unixTime) {
        return false;
    }
    foreach ($formats as $format) {
        if (date($format, $unixTime) == $date) {
            return true;
        }
    }

    return false;
}
