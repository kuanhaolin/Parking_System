<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    header('charset=UTF-8');
    $link=connectMySQL();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //判斷停車位資料表是否有空位
        $query = "select * from parking_space where state = 1";
        $result = execute($link, $query);
        $data = mysqli_fetch_assoc($result);
        if($data > 0){
            //隨機選擇一個停車位
            $query = "select * from parking_space where state = 1 order by rand() limit 1";
            $result = execute($link, $query);
            if (mysqli_affected_rows($link) == 1) {
                $rowSelect = mysqli_fetch_assoc($result);
                $selectedParkingID = $rowSelect['id'];
                //判斷車輛資料表是否有重複資料
                $query = "select * from vehicle where license_plate='{$_POST['license_plate']}'";
                $result = execute($link, $query);
                $data = mysqli_fetch_assoc($result);
                if($data == 0){//不存在
                    //車輛資料表寫入車牌資訊
                    $query = "insert into vehicle(license_plate) values('{$_POST['license_plate']}')";
                    $result = execute($link, $query);
                    if(mysqli_affected_rows($link) == 1){
                        $newVehicleID = $link->insert_id;
                        //判斷使用者資料表是否有重複資料
                        $query = "select * from user where vehicle_id='{$_POST['license_plate']}'";
                        $result = execute($link, $query);
                        $data = mysqli_fetch_assoc($result);
                        if($data > 0){//使用者存在
                            $query = "update vehicle set user_id={$data['id']}, spot_id={$selectedParkingID} where id={$newVehicleID}";
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                $query = "update parking_space set state=3 where id={$selectedParkingID}"; 
                                $result = execute($link, $query);
                                if(mysqli_affected_rows($link) == 1){
                                    echo json_encode(array(
                                        'successMsg' => '車輛停車位更新成功'
                                    ));
                                }
                            }
                        }else{//不存在
                            //使用者資料表寫入車牌資訊
                            $query = "insert into user(vehicle_id) values('{$_POST['license_plate']}')";
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                //車輛資料表更新停車位編號與用戶編號
                                $newUserID = $link->insert_id;
                                $query = "update vehicle set user_id={$newUserID}, spot_id={$selectedParkingID} where id={$newVehicleID}";
                                $result = execute($link, $query);
                                if(mysqli_affected_rows($link) == 1){
                                    $query = "update parking_space set state=3 where id={$selectedParkingID}"; 
                                    $result = execute($link, $query);
                                    if(mysqli_affected_rows($link) == 1){
                                        echo json_encode(array(
                                            'successMsg' => '車輛更新成功'
                                        ));
                                    }
                                }else{
                                    echo json_encode(array(
                                        'errorMsg' => '停車位更新失敗'
                                    ));
                                }
                            }
                        }
                    }
                }
            }else{
                echo json_encode(array(
                    'successMsg' => '測試'
                ));
            }
        }
    }else{
        echo json_encode(array(
            'errorMsg' => '目前暫無車位'
        ));
    }
?>