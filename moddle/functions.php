<?php
function render_message(){
    return 0;
}
function check_user_login(){
    if(isset($_SESSION["id"]) && isset($_SESSION["email"]))
    return true;
    return false;
}
