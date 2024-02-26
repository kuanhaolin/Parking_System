<?php
    include_once './config/config.inc.php';
    include_once './config/mongo.inc.php';
    include_once './config/mysql.inc.php';
    $mongoManager = connectMongoDB();
    $link = connectMySQL();

    $result = executeMongoDB('fee');
    $row = current($result);
    for ($i = 0; $i < count($row->in_time); $i++) {
        // 判斷$row->out_time[$i]是否存在
        if(!empty($row->out_time[$i])){
        }
        echo <<<HTML
        <tr>
            <td class='id' rowindex='{$row->id}'>{$row->id}</td>
            <td class='license-plate' rowindex='{$row->id}'>{$row->license_plate}</td>
            <td class='in-time' rowindex='{$row->id}'>{$row->in_time[$i]}</td>
            <td class='out-time' rowindex='{$row->id}'>{$row->in_time[$i]}</td>
            <td class='create-time' rowindex='{$row->id}'>{$row->create_time}</td>
            <td class='update-time' rowindex='{$row->id}'>{$row->update_time}</td>
            <td>
                <button class='btn btn-success' name='edit_this_info' rowindex='{$row->id}'>編輯</button>
                <button class='btn btn-error' name='delete_this_info' rowindex='{$row->id}'>刪除</button>
            </td>
        </tr>
    HTML;
    }
    next($result);
?>

