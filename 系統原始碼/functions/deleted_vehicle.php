<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    header('charset=UTF-8');
    $link=connectMySQL();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        @$updateID = $_POST['id'];
        @$updatedInfo = $_POST['updated_info'];

        if (!empty($updatedInfo)) {
            // $query = "update vehicle set deleted={$updatedInfo['deleted']}, update_time=now() where id={$updateID}";
            // $result = execute($link, $query);
            // if(mysqli_affected_rows($link) == 1){
                $query = "select * from vehicle where id={$updateID}";
                $result = execute($link, $query);
                if($data = mysqli_fetch_assoc($result)){
                    $query = "update parking_space set state=1, update_time=now() where id={$data['spot_id']}";
                    $result = execute($link, $query);
                    if(mysqli_affected_rows($link) == 1){
                        $query = "delete from vehicle where id={$updateID}";
                        $result = execute($link, $query);
                        if(mysqli_affected_rows($link) == 1){
                            //刪除使用者
                            $query = "delete from user where id={$data['user_id']}";
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                echo json_encode(array(
                                    'successMsg' => '刪除成功'
                                ));
                            }
                        }else{
                            echo json_encode(array(
                                'errorMsg' => '刪除失敗'
                            ));
                        }
                    }else{
                        echo json_encode(array(
                            'errorMsg' => '刪除失敗'
                        ));
                    }
                }
            // }
            else{
                echo json_encode(array(
                    'errorMsg' => '刪除失敗'
                ));
            }
        }
    } else {
        echo json_encode(array(
            'errorMsg' => '請求無效，只允許 POST 方式訪問！'
        ));
    }
?>