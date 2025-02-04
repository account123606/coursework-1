<?php
session_start();
if (isset($_GET['id'])) {
    unset($_SESSION['tasks'][$_GET['id']]);
}
header('Location: dashboard.php');
