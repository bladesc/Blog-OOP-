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
        include 'comments/read.php';
    } else {
        switch ($_GET['action']) {
            case 'create':
                include 'comments/create.php';
                break;
            case 'update':
                include 'comments/update.php';
                break;
            case 'delete':
                include 'comments/delete.php';
                break;
            default:
                include 'comments/read.php';
        }
    }
    ?>
</div>