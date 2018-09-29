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
        include 'categories/read.php';
    } else {
        switch ($_GET['action']) {
            case 'create':
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








