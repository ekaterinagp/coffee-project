<?php

/****************/
function sendErrorMessage($message, $line){
    echo '{"status":0, "message": '.$message.', "line":'.$line.'}';
    exit;
}