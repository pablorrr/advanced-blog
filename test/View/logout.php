<?php
/**
 * log put page , redirecting on this page when user update his self (as he is logged and updated)
 */

?>
<?php require 'components/header.php' ?>
<br>
<br>
<h5><?= $_SESSION['userEmail']; ?></h5>

<p>You are updated yourself please press log out button and log in again to see results of upgrade</p>
<button><a href="<?= ROOT_URL ?>?p=admin&amp;a=logout">Logout</a></button>

<footer></footer>
</div>
</body>
</html>

