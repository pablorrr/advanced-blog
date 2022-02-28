<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php require 'components/header.php' ?>
<?php require 'components/msg.php' ?>
<h3>Add post page</h3>
<!--todo add prtoection validate in php-->
<form id="add" action="" method="post">

    <p><label for="title">Title:</label><br/>
        <input type="text" name="title" id="title" required="required"/>
    </p>

    <p><label for="body">Body:(musi skladac sie conajmniej z dwoch slow)</label><br/>
        <textarea name="body" id="body" rows="5" cols="35" required="required"></textarea>
    </p>

    <p><input type="submit" name="add_submit" value="Add"/></p>
</form>

<?php require 'components/footer.php' ?>
