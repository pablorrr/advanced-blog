<?php require ROOT_PATH . 'View/components/header.php' ?>
<?php require ROOT_PATH . 'View/components/admin-msg.php' ?>
<br>
<br>
<h3>Edit User Page</h3>
<form action="" method="post">
    <p><label for="email">email:</label><br/>
        <input type=email name="email" id="email" value="<?= trim(htmlspecialchars($this->oAdmin->email)) ?>"
               required="required"/>
    </p>
    <p>
        <label for="password">password:</label><br/>
        <input type=password name="password" id="password" value=""
               required="required"/>
    </p>
    <!-- confirm -->
    <p>
        <label for="confirm">confirm password:</label><br/>
        <input type=password name="confirm" id="confirm" value=""
               required="required"/>
    </p>
    <p><input type="submit" name="edit_submit" value="Update"/></p>
</form>

<?php require ROOT_PATH . 'View/components/footer-form.php' ?>
