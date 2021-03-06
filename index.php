<?php
// 引入檔頭
require_once 'header.php';
/************************自訂函數**************************/
// 表單
function post_form()
{
    global $content, $db, $smarty;
    if (isset($_POST['send'])) {
        if (isset($_POST['next_op'])) {
            if ($_POST['next_op'] == "add") {
                $sn = add();
                if (empty($sn)) {
                    $_message    = "新增失敗";
                    $page_title  = '錯誤提示頁';
                    $refresh_url = 'index.php';
                } else {
                    $_message    = "新增成功!";
                    $page_title  = '成功提示頁';
                    $refresh_url = 'index.php?sn=' . $sn;
                }
            }

            if ($_POST['next_op'] == "update") {
                $sn = update();
                if (empty($sn)) {
                    $_message    = "更新失敗";
                    $page_title  = '錯誤提示頁';
                    $refresh_url = 'index.php';
                } else {
                    $_message    = "更新成功!";
                    $page_title  = '成功提示頁';
                    $refresh_url = 'index.php?sn=' . $sn;
                }

            }
        }
        redirect_page($_message, $refresh_url, $page_title);
    }

    // 編輯
    if (isset($_GET['sn'])) {
        // 從資料庫撈資料
        // 過濾變數
        $sn      = (int) $_GET['sn'];
        $content = find_one($sn);
        $next_op = 'update';
    } else {
        // 加入預設值
        $content = [
            'title'      => '',
            'directions' => '',
            'end'        => date("Y-m-d", strtotime("+10 day")),
            'priority'   => '中',
            'assign_arr' => [],
            'done'       => 0,
        ];
        $next_op = 'add';
    }

    $smarty->assign('next_op', $next_op);
}
//新增清單
function add()
{
    global $db;
    check_error();
    //過濾變數
    $title      = $db->real_escape_string($_POST['title']);
    $directions = $db->real_escape_string($_POST['directions']);
    $end        = $db->real_escape_string($_POST['end']);
    $priority   = $db->real_escape_string($_POST['priority']);
    $assign     = $db->real_escape_string(implode(';', $_POST['assign']));
    $done       = (int) $_POST['done'];

    // 連線資料庫
    $sql = "INSERT INTO `list` ( `title`, `directions`, `end`, `priority`, `assign`, `done`,`create_time`,`update_time`)
    VALUES ('{$title}', '{$directions}', '{$end}', '{$priority}', '{$assign}', '{$done}',now(),now())";

    $db->query($sql) or die(redirect_page($db->error));

    $sn = $db->insert_id;
    return $sn;
}

//更新清單
function update()
{
    global $db;
    check_error();
    //過濾變數
    $sn          = (int) $_POST['sn'];
    $title       = $db->real_escape_string($_POST['title']);
    $directions  = $db->real_escape_string($_POST['directions']);
    $end         = $db->real_escape_string($_POST['end']);
    $priority    = $db->real_escape_string($_POST['priority']);
    $assign      = $db->real_escape_string(implode(';', $_POST['assign']));
    $done        = (int) $_POST['done'];
    $update_time = date('Y-m-d H:i:s');

    // 連線資料庫
    $sql = "UPDATE `list` SET
    `title`='{$title}',
    `directions`='{$directions}',
    `end`='{$end}',
    `priority`='{$priority}',
    `assign`='{$assign}',
    `done`='{$done}',
    `update_time`='{$update_time}'
    WHERE `sn`= '$sn'";
    // die($sql);
    $db->query($sql) or die(redirect_page($db->error));

    return $sn;
}

// 驗證欄位正確性
function check_error()
{
    $message = [];
    if (empty($_POST['title'])) {
        $message[] = '標題必填';
    }
    if (empty($_POST['directions'])) {
        $message[] = '描述必填';
    }
    if (empty($_POST['end'])) {
        $message[] = '到期日必填';
    }

    if (empty($_POST['assign'])) {
        $message[] = '至少指派一名';
    }

    if (!checkDateIsValid($_POST['end'])) {
        $message[] = '到期日的日期格式需為西元 YYYY-mm-dd 或 YYYY/mm/dd';
    }
    if (!empty($message)) {
        redirect_page($message, 'index.php');
        exit();
    }
}

// 列出所有
function list_all($done = '')
{
    global $db, $smarty, $content;
    $where = (empty($done)) ? "where done='0' order by priority,end" : "where done='1' order by update_time";
    $sql   = "select * from `list` $where";
    // die($sql);
    include_once "class/PageBar.php";
    $PageBar = getPageBar($db, $sql, 20, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    if (!$result = $db->query($sql)) {
        die(redirect_page($db->error));
    }

    $i       = 0;
    $content = [];
    while (list($sn, $title, $directions, $end, $priority, $assign, $done, $create_time, $update_time) = $result->fetch_row()) {

        //過濾變數
        $title      = htmlspecialchars($title, ENT_QUOTES);
        $directions = htmlspecialchars($directions, ENT_QUOTES);
        $priority   = filter_var($priority, FILTER_SANITIZE_SPECIAL_CHARS);

        $content[$i]['sn']          = $sn;
        $content[$i]['title']       = $title;
        $content[$i]['directions']  = $directions;
        $content[$i]['end']         = $end;
        $content[$i]['priority']    = $priority;
        $content[$i]['assign']      = $assign;
        $content[$i]['done']        = $done;
        $content[$i]['create_time'] = $create_time;
        $content[$i]['update_time'] = $update_time;
        $i++;
    }

    $smarty->assign('total', $total);
    $smarty->assign('bar', $bar);
    // die(var_dump($bar));
}

//以流水號取得某筆資料
function find_one($sn = "")
{
    global $db;

    if (empty($sn)) {
        die(redirect_page($db->error));
    }

    $sql = "select * from list where `sn` = '{$sn}'";

    if (!$result = $db->query($sql)) {
        die(redirect_page($db->error));
    }

    $data = $result->fetch_assoc();
    if (empty($data)) {
        redirect_page('無此編號', 'index.php');

    } else {
        //過濾變數
        $data['title'] = htmlspecialchars($data['title'], ENT_QUOTES);
        // $data['directions'] = htmlspecialchars($data['directions'], ENT_QUOTES);
        $data['priority'] = filter_var($data['priority'], FILTER_SANITIZE_SPECIAL_CHARS);
        // 複選框$data['assign']
        $data['assign_arr'] = explode(';', $data['assign']);
        // die(var_dump($data));
        return $data;
    }

}

// 刪除
function delete($sn)
{
    global $db;

    if (empty($sn)) {
        redirect_page('無此編號', 'index.php');
    }
    $sql = "DELETE FROM `list` WHERE `sn`='{$sn}'";
    if (!$db->query($sql)) {
        redirect_page($db->error, 'index.php');
    } else {
        redirect_page('刪除成功', 'index.php', '成功提示頁');
    }
}

/********************流程判斷*********************/
// 變數過濾
$op = isset($_REQUEST['op']) ? filter_var($_REQUEST['op'], FILTER_SANITIZE_SPECIAL_CHARS) : "";
$sn = isset($_REQUEST['sn']) ? (int) $_REQUEST['sn'] : "";
switch ($op) {
    case 'done':
        list_all('1');
        break;
    case 'post_form':
        post_form();
        break;
    //刪除資料
    case "delete":
        delete($sn);
        break;
    default:
        if (empty($sn)) {
            //列出所有事項
            list_all();
        } else {
            $content = find_one($sn);
            $op      = 'show_one';
        }

        break;
}

// 引入頁尾
require_once 'footer.php';
