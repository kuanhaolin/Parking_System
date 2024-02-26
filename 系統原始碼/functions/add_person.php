<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    header('charset=UTF-8');
    $link=connectMySQL();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $query = "insert into user (vehicle_id, name, age, birthday, email, phone_number, origin_home, current_home, user_type, user_state, create_time, update_time)
        values ('{$_POST['vehicle_id']}', '{$_POST['name']}', {$_POST['age']}, '{$_POST['birthday']}', '{$_POST['email']}', '{$_POST['phone_number']}', '{$_POST['origin_home']}', '{$_POST['current_home']}', {$_POST['user_type']}, {$_POST['user_state']}, now(), now())";
        execute($link, $query);
        if(mysqli_affected_rows($link) == 1){
            echo json_encode(array(
                'successMsg' => '新增成功'
            ));
        }
        else{
            echo json_encode(array(
                'errorMsg' => '新增失敗'
            ));
        }
    } else {
        echo json_encode(array(
            'errorMsg' => '請求無效，只允許 POST 方式訪問！'
        ));
    }
?>