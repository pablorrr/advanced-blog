<?php require ROOT_PATH . 'View/components/header.php' ?>
<br>
<br>
<h5><?= $_SESSION['userEmail']; ?></h5>
<p>You are updated yourself please press log out button and log in again to see results of upgrade</p>
<button><a href="<?= PROT . $_SERVER['SERVER_NAME'] ?>/logout">Logout</a></button>
<footer>
</footer>
</div>
</body>
</html>

