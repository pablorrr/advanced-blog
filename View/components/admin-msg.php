<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

use Controller\MainController;

?>


<?php if (!empty($_SESSION['AdminSuccMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['AdminSuccMsg'] ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>






