<?php

// return data rows
function getDataRows($sql) {
 
    $app = \Slim\Slim::getInstance();
 
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = array();
        $stmt->setFetchMode(PDO::FETCH_OBJ);
        $error = array('error' => 'No match found');

        // fetch data into array
        $i = 0;
        while($row = $stmt->fetch()) {
            $data[$i] = $row;
            $i++;
        }
        
        // return data
        if($data) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($error);
        }
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo $e;
    }
}

// return selected row
function getRow($sql) {
 
    $app = \Slim\Slim::getInstance();
 
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $error = array('error' => 'No match found');
 
        // return data
        if($row) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($row, JSON_PRETTY_PRINT);
        } else {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($error);
        }
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo $e;
    }
}

// add data row #### broken. pass in $app? $db->prepare($sql) must take str, gets object?
function addRow($appObj, $sql) {

    $app = $appObj;

    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
 
        # message to confirm successful data entry?
        $app->response->setStatus(200);
        echo "<p>Data submitted successfully</p>";
        $db = null;

    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}