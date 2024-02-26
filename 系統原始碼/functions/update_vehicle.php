<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    // include '../config/mongo.inc.php';
    header('charset=UTF-8');
    // $mongoManager = connect();
    $link=connectMySQL();


    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        @$updateID = $_POST["vehicle_id"];
        @$updatedInfo = $_POST["updated_info"];

        if (!empty($updatedInfo)) {
            // SQL更新車輛資訊
            $query = "update vehicle set license_plate='{$updatedInfo['license_plate']}', user_id={$updatedInfo['user_id']}, spot_id={$updatedInfo['spot_id']}, vehicle_brand='{$updatedInfo['vehicle_brand']}', vehicle_type='{$updatedInfo['vehicle_type']}', vehicle_color='{$updatedInfo['vehicle_color']}', vehicle_state={$updatedInfo['vehicle_state']}, special_requirements='{$updatedInfo['special_requirements']}', notes='{$updatedInfo['notes']}', update_time=now() where id={$updateID}";
            // $query = "update vehicle set vehicle_brand='{$updatedInfo['vehicle_brand']}' where id={$updateID}";
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