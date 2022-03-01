<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php if (!empty($_SESSION['is_logged'])): ?>

    <button type="button" onclick="window.location='<?= ROOT_URL ?>single-post?id=<?= $oPost->id ?>'"
            class="bold">Edit
    </button> |
    <form action="<?= ROOT_URL ?>delete&amp;id=<?= $oPost->id ?>" method="post" class="inline">
        <button type="submit" name="delete" value="1" class="bold">Delete</button>
    </form> |



<?php endif ?>

<?php if (empty($oPost->comment)): ?>

    <button type="button"
            onclick="window.location='<?= ROOT_URL ?>add-comment?id=<?= $oPost->id ?>'" class="bold">
        Add New Comment
    </button>

<?php endif; ?>