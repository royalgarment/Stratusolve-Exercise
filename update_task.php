<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('task.class.php');


// Assignment: Implement this script
if(isset($_POST['taskName']) && isset($_POST['taskId']) && isset($_POST['taskDescription']) && $_POST['funcName'] == 'save'){
    $TaskObject = new Task($_POST['taskId']);
    $response = $TaskObject->Save($_POST['taskName'],$_POST['taskDescription']);
    echo json_encode($response);
}

if(isset($_POST['taskId']) && $_POST['funcName'] == 'delete'){
    $TaskObject = new Task($_POST['taskId']);
    $response = $TaskObject->Delete($_POST['taskId']);
    echo json_encode($response);
}

if(isset($_POST['taskId']) && $_POST['funcName'] == 'retrieve'){
    $TaskObject = new Task($_POST['taskId']);
    $TaskInfo['TaskName'] = $TaskObject->TaskName;
    $TaskInfo['TaskDescription'] = $TaskObject->TaskDescription;
    echo json_encode($TaskInfo);
}

?>