<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php if (!empty($_SESSION['is_logged'])): ?>
    <div class="row">

        <button type="button" onclick="window.location='<?= ROOT_URL ?>edit?id=<?= $oPost->id ?>'"
                class="bold">Edit
        </button>


        <form action="<?= ROOT_URL ?>delete?id=<?= $oPost->id ?>" method="post" class="inline">
            <button type="submit" name="delete" value="1" class="bold">Delete</button>
        </form>
    </div>


<?php endif ?>

<?php if (empty($oPost->comment)): ?>
    <div class="row">
        <button type="button"
                onclick="window.location='<?= ROOT_URL ?>add-comment?id=<?= $oPost->id ?>'" class="bold">
            Add New Comment
        </button>
    </div>
<?php endif; ?>