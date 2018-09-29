<?php

use Blog\Session;

//#SESSION MESSAGES#
$session = new Session;
if ($session->issetSession('messages')) {
    print_r($_SESSION['messages']);
    $session->deleteSession('messages');
}
?>

<div id="right-bar">
    <?php
    if (!isset($_GET['action'])) {
        include 'categories/read.php';
    } else {
        switch ($_GET['action']) {
            case 'add':
                include 'categories/create.php';
                break;
            case 'update':
                include 'categories/update.php';
                break;
            case 'delete':
                include 'categories/delete.php';
                break;
            default:
                include 'categories/read.php';
        }
    }
    ?>
</div>








