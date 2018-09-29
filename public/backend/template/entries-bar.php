<?php

use Blog\Session;

//#########SESSION MESSAGES
$session = new Session;
if ($session->issetSession('messages')) {
    $errors = $_SESSION['messages'];
    $session->deleteSession('messages');
}
?>

<?php if (isset($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div id="right-bar">
    <?php
    if (!isset($_GET['action'])) {
        include 'entries/read.php';
    } else {
        switch ($_GET['action']) {
            case 'create':
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
    }
    ?>
</div>








