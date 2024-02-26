<?php
    // 連接 MongoDB
    function connectMongoDB($host = MONGO_HOST, $port = MONGO_PORT){
        try {
            $mongoManager = new MongoDB\Driver\Manager("mongodb://$host:$port");
            // echo "MongoDB connection successful.\n";
            return $mongoManager;
        } catch (Exception $e) {
            exit("MongoDB connection failed: " . $e->getMessage());
        }
    }

    // 執行 MongoDB 查詢
    function executeMongoDB($collection, $filter = [], $options = []){
        global $mongoManager;
        $query = new MongoDB\Driver\Query($filter, $options);
        return $mongoManager->executeQuery(MONGO_DATABASE . ".$collection", $query)->toArray();
    }

    // 執行 MongoDB 查詢，回傳是否存在且唯一
    function isLicensePlateUnique($collection, $filter) {
        global $mongoManager;
        $result = $mongoManager->executeQuery(MONGO_DATABASE . ".$collection", new MongoDB\Driver\Query($filter))->toArray();
        return count($result) === 1;
    }

    // 執行 MongoDB 新增
    function insertDocument($collection, $data){
        global $mongoManager;
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->insert($data);
        return $mongoManager->executeBulkWrite(MONGO_DATABASE . ".$collection", $bulk);
    }

    // 執行 MongoDB 刪除
    function deleteDocument($collection, $filter){
        global $mongoManager;
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->delete($filter);
        return $mongoManager->executeBulkWrite(MONGO_DATABASE . ".$collection", $bulk);
    }

    // 執行 MongoDB 修改
    function updateDocument($collection, $filter, $data){
        global $mongoManager;
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->update($filter, $data);
        return $mongoManager->executeBulkWrite(MONGO_DATABASE . ".$collection", $bulk);
    }
?>