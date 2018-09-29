<?php
/**
 * Created by PhpStorm.
 * User: dom
 * Date: 26.09.2018
 * Time: 23:49
 */

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
        include 'users/read.php';
    } else {
        switch ($_GET['action']) {
            case 'create':
                include 'users/create.php';
                break;
            case 'update':
                include 'users/update.php';
                break;
            case 'delete':
                include 'users/delete.php';
                break;
            default:
                include 'users/read.php';
        }
    }
    ?>
</div>