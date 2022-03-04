<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */

use Controller\MainController;

?>
<footer>
    <p class="italic"><strong><a href="<?= ROOT_URL ?>" title="Home page">Simple Blog</a></strong> created for a PHP
        Technical Test &nbsp; | &nbsp;
        <?php if (!empty($_SESSION['is_logged'])): ?>
        You are connected as Admin -
    <h3><?= $_SESSION['userEmail']; ?></h3> <a href="<?= ROOT_URL ?>logout">Logout</a> &nbsp;
    Register New User - <a href="<?= ROOT_URL ?>admin/register">Register</a> &nbsp;
    View All Admin Users - <a href="<?= ROOT_URL ?>admin">Display ADMINS</a> &nbsp;
    <a href="<?= ROOT_URL ?>">View All Blog Posts</a></p>
    <?php else: ?>
        <p class="italic"><strong>You are looged off to add post please click on <a
                        href="<?= ROOT_URL ?>login">Backend Login</a> </strong></p>
    <?php endif ?>
    </p>

</footer>
</div>
</body>
</html>
<?php MainController::isPageRefreshed(); ?>

