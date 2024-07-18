<?php
function validate_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_phone($phone){
    return preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone);
}

function validate_email($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
?>