<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    header('charset=UTF-8');
    $link=connectMySQL();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        @$updateID = $_POST['id'];
        @$updatedInfo = $_POST['updated_info'];

        if (!empty($updatedInfo)) {
            $query = "update user set vehicle_id='{$updatedInfo['vehicle_id']}', name='{$updatedInfo['name']}', 
            age={$updatedInfo['age']}, birthday='{$updatedInfo['birthday']}', email='{$updatedInfo['email']}', 
            phone_number='{$updatedInfo['phone_number']}', origin_home='{$updatedInfo['origin_home']}', current_home='{$updatedInfo['current_home']}', 
            user_type={$updatedInfo['user_type']}, user_state={$updatedInfo['user_state']}, update_time=now() where id={$updateID}";


            execute($link, $query);
            if(mysqli_affected_rows($link) == 1){
                echo json_encode(array(
                    'successMsg' => '更新成功'
                ));
            }
            else{
                echo json_encode(array(
                    'errorMsg' => '更新失敗'
                ));
            }
        }
    } else {
        echo json_encode(array(
            'errorMsg' => '請求無效，只允許 POST 方式訪問！'
        ));
    }
?>