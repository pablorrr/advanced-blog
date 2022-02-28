<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php require 'components/header.php' ?>
<?php require 'components/admin-msg.php' ?>
<br>
<br>
<h3>Edit User Page</h3>
<form action="" method="post">
    <p><label for="email">email:</label><br/>
        <input type=email name="email" id="email" value="<?= htmlspecialchars($this->oAdmin->email) ?>"
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


<?php require 'components/footer.php' ?>
