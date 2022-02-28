<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>

<?php if (!empty($_SESSION['CommentSuccessMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['CommentSuccessMsg']; ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>

<?php if (!empty($_SESSION['CommentErrorMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['CommentErrorMsg']; ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>
