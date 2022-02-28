<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php require 'components/header.php' ?>
<?php require 'components/comment-msg.php' ?>

<!--todo add prtoection validate in php-->
<h1> Add comment page</h1>
<form action="" method="POST">

    <input type="hidden" name="post_id" id="post_id" value="<?= htmlspecialchars($_GET['id']) ?>" required="required"/>
    <p><label for="comment">Comment(musi skladac sie conajmniej z dwoch slow):</label><br/>
        <textarea name="comment" id="comment" rows="5" cols="35" required="required"></textarea>
    </p>

    <p><input type="submit" name="add_comment" value="Add"/></p>
</form>

<?php require 'components/footer.php' ?>
