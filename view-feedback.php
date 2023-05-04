<?php
session_start();
include('connectDB.php');
$user_id =  $_SESSION['user_id'];
if (isset($_GET['assignment_id'])) {
    $class_id = $_GET['assignment_id'];
} else {
    echo "Error: Assignment ID not specified in URL";
    exit();
}