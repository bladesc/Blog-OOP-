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
    switch ($_GET['action']) {
        case 'add':
            include 'entries/create.php';
            break;
        case 'update':
            include 'entries/update.php';
            break;
        case 'delete':
            include 'entries/delete.php';
            break;
        default:
            include 'entries/read.php';
    }

    ?>
</div>








