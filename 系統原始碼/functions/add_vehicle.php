<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    include '../config/mongo.inc.php';
    header('charset=UTF-8');
    $mongoManager = connectMongoDB();
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
                if($data == 0){//車輛資料表不存在此車牌
                    //判斷使用者資料表是否有重複資料
                    $query = "select * from user where vehicle_id='{$_POST['license_plate']}'";
                    $result = execute($link, $query);
                    $data = mysqli_fetch_assoc($result);
                    if($data > 0){//使用者存在此車牌
                        //車輛資料表新增車牌與停車位
                        $query = "insert into vehicle(license_plate, user_id, spot_id) values('{$_POST['license_plate']}', {$data['id']}, {$selectedParkingID})";
                        $result = execute($link, $query);
                        if(mysqli_affected_rows($link) == 1){
                            //更新停車位狀態
                            $query = "update parking_space set state=3 where id={$selectedParkingID}"; 
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                $filter = ["license_plate" => $_POST['license_plate']];
                                $isUnique = isLicensePlateUnique("fee", $filter);
                                if ($isUnique) {// 存在
                                    $d = strval(date("Y-m-d h:i:sa"));
                                    $filter = ["license_plate" => $_POST['license_plate']];
                                    $result = executeMongoDB('fee', $filter);
                                    if (!empty($result)) {
                                        $numValue = $result[0]->num;
                                        
                                        $updateFilter = $filter;
                                        $updateData = [
                                            '$set' => [
                                                'num' => $numValue + 1,
                                                'update_time' => $d
                                            ],
                                            '$push' => ['in_time' => $d]
                                        ];
                                        $updateResult = updateDocument('fee', $updateFilter, $updateData);
                                    }
                                }else{// 不存在
                                    $d = strval(date("Y-m-d h:i:sa"));
                                    $insertData = [
                                        'id' => 1188,
                                        'license_plate' => $_POST['license_plate'],
                                        'in_time' => [$d],
                                        'out_time' => [],
                                        'fee' => [],
                                        'num' => 0,
                                        'create_time' => $d,
                                        'update_time' => $d
                                    ];
                                    $insertResult = insertDocument('fee', $insertData);
                                }
                                echo json_encode(array(
                                    'successMsg' => '車輛停車位更新成功'
                                ));
                            }
                        }
                    }else{//使用者不存在此車牌
                        //使用者資料表寫入車牌資訊
                        $query = "insert into user(vehicle_id) values('{$_POST['license_plate']}')";
                        $result = execute($link, $query);
                        if(mysqli_affected_rows($link) == 1){
                            //車輛資料表新增車牌與停車位
                            $query = "insert into vehicle(license_plate, user_id, spot_id) values('{$_POST['license_plate']}', {$link->insert_id}, {$selectedParkingID})";
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                //更新停車位狀態
                                $query = "update parking_space set state=3 where id={$selectedParkingID}"; 
                                $result = execute($link, $query);
                                if(mysqli_affected_rows($link) == 1){
                                    $filter = ["license_plate" => $_POST['license_plate']];
                                    $isUnique = isLicensePlateUnique("fee", $filter);
                                    if ($isUnique) {// 存在
                                        $d = strval(date("Y-m-d h:i:sa"));
                                        $filter = ["license_plate" => $_POST['license_plate']];
                                        $result = executeMongoDB('fee', $filter);
                                        if (!empty($result)) {
                                            $numValue = $result[0]->num;
                                            
                                            $updateFilter = $filter;
                                            $updateData = [
                                                '$set' => [
                                                    'num' => $numValue + 1,
                                                    'update_time' => $d
                                                ],
                                                '$push' => ['in_time' => $d]
                                            ];
                                            $updateResult = updateDocument('fee', $updateFilter, $updateData);
                                        }
                                    }else{// 不存在
                                        $d = strval(date("Y-m-d h:i:sa"));
                                        $insertData = [
                                            'id' => 1188,
                                            'license_plate' => $_POST['license_plate'],
                                            'in_time' => [$d],
                                            'out_time' => [],
                                            'fee' => [],
                                            'num' => 0,
                                            'create_time' => $d,
                                            'update_time' => $d
                                        ];
                                        $insertResult = insertDocument('fee', $insertData);
                                    }
                                    echo json_encode(array(
                                        'successMsg' => '車輛停車位更新成功'
                                    ));
                                }
                            }                            
                        }
                    }
                }else{//車輛資料表存在此車牌
                    //判斷使用者資料表是否有重複車牌資料
                    $query = "select * from user where vehicle_id='{$_POST['license_plate']}'";
                    $result = execute($link, $query);
                    $data = mysqli_fetch_assoc($result);
                    if($data > 0){//使用者資料表存在此車牌
                        $filter = ["license_plate" => $_POST['license_plate']];
                        $isUnique = isLicensePlateUnique("fee", $filter);
                        if($isUnique) {// 存在
                            $d = strval(date("Y-m-d h:i:sa"));
                            $filter = ["license_plate" => $_POST['license_plate']];
                            $result = executeMongoDB('fee', $filter);
                            if(!empty($result)) {
                                $numValue = $result[0]->num;
                                
                                $updateFilter = $filter;
                                $updateData = [
                                    '$set' => [
                                        'num' => $numValue + 1,
                                        'update_time' => $d
                                    ],
                                    '$push' => ['in_time' => $d]
                                ];
                                $updateResult = updateDocument('fee', $updateFilter, $updateData);
                            }
                        }else{// 不存在
                            $d = strval(date("Y-m-d h:i:sa"));
                            $insertData = [
                                'id' => 1188,
                                'license_plate' => $_POST['license_plate'],
                                'in_time' => [$d],
                                'out_time' => [],
                                'fee' => [],
                                'num' => 0,
                                'create_time' => $d,
                                'update_time' => $d
                            ];
                            $insertResult = insertDocument('fee', $insertData);
                        }
                        echo json_encode(array(
                            'successMsg' => 'mongodb車輛停車位更新成功'
                        ));
                    }else{//使用者資料表不存在此車牌
                        //使用者資料表寫入車牌資訊
                        $query = "insert into user(vehicle_id) values('{$_POST['license_plate']}')";
                        $result = execute($link, $query);
                        if(mysqli_affected_rows($link) == 1){
                            //更新車輛資料表車牌
                            $query = "update vehicle set user_id={$link->insert_id} where license_plate='{$_POST['license_plate']}'";
                            $result = execute($link, $query);
                            if(mysqli_affected_rows($link) == 1){
                                $filter = ["license_plate" => $_POST['license_plate']];
                                $isUnique = isLicensePlateUnique("fee", $filter);
                                if ($isUnique) {// 存在
                                    $d = strval(date("Y-m-d h:i:sa"));
                                    $filter = ["license_plate" => $_POST['license_plate']];
                                    $result = executeMongoDB('fee', $filter);
                                    if (!empty($result)) {
                                        $numValue = $result[0]->num;
                                        
                                        $updateFilter = $filter;
                                        $updateData = [
                                            '$set' => [
                                                'num' => $numValue + 1,
                                                'update_time' => $d
                                            ],
                                            '$push' => ['in_time' => $d]
                                        ];
                                        $updateResult = updateDocument('fee', $updateFilter, $updateData);
                                    }
                                }else{// 不存在
                                    $d = strval(date("Y-m-d h:i:sa"));
                                    $insertData = [
                                        'id' => 1188,
                                        'license_plate' => $_POST['license_plate'],
                                        'in_time' => [$d],
                                        'out_time' => [],
                                        'fee' => [],
                                        'num' => 0,
                                        'create_time' => $d,
                                        'update_time' => $d
                                    ];
                                    $insertResult = insertDocument('fee', $insertData);
                                }
                                echo json_encode(array(
                                    'successMsg' => '車輛停車位更新成功'
                                ));
                            }
                        }
                    }
                }
            }else{
                echo json_encode(array(
                    'successMsg' => '測試456'
                ));
            }
        }
    }else{
        echo json_encode(array(
            'errorMsg' => '目前暫無車位'
        ));
    }
?>