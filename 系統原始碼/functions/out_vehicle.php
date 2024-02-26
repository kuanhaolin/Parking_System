<?php
    include '../config/config.inc.php';
    include '../config/mysql.inc.php';
    include '../config/mongo.inc.php';
    header('charset=UTF-8');
    $mongoManager = connectMongoDB();
    $link=connectMySQL();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $query = "select * from vehicle where id = {$_POST['id']}";
        $result = execute($link, $query);
        if (mysqli_affected_rows($link) == 1) {
            $data = mysqli_fetch_assoc($result);

            $filter = ["license_plate" => $data['license_plate']];
            $isUnique = isLicensePlateUnique("fee", $filter);
            if ($isUnique) {// 存在
                $d = strval(date("Y-m-d h:i:sa"));
                $result = executeMongoDB('fee', $filter);
                if (!empty($result)) {
                    if(count($result[0]->out_time) === count($result[0]->in_time) - 1){
                        $num = $result[0]->num;
                        // 計算相差的秒數
                        $diffInSeconds = strtotime($d) - strtotime($result[0]->in_time[$num]);
                        // 將秒數轉換為天數
                        $daysDifference = floor($diffInSeconds / (60 * 60 * 24));

                        $updateFilter = $filter;
                        $updateData = [
                            '$set' => [
                                'update_time' => $d
                            ],
                            '$push' => ['out_time' => $d, 'fee' => $daysDifference * 100]
                        ];
                        $updateResult = updateDocument('fee', $updateFilter, $updateData);
                        echo json_encode(array(
                            'successMsg' => "以新增退場時間與費用"
                        ));
                    }else{
                        echo json_encode(array(
                            'errorMsg' => '請求無效！'
                        ));
                    }
                }
            }
        }
    } else {
        echo json_encode(array(
            'errorMsg' => '請求無效，只允許 POST 方式訪問！'
        ));
    }
?>