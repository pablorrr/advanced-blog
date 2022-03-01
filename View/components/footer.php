<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<footer>
    <p class="italic"><strong><a href="<?= ROOT_URL ?>" title="Homeage">Simple Blog</a></strong> created for a PHP
        Technical Test &nbsp; | &nbsp;
        <?php if (!empty($_SESSION['is_logged'])): ?>
        You are connected as Admin -
    <h3><?= $_SESSION['userEmail']; ?></h3> <a href="<?= ROOT_URL ?>logout">Logout</a> &nbsp;


    <?php else: ?>
        <p class="italic"><strong>You are looged off to add post please click on <a
                        href="<?= ROOT_URL ?>login">Backend Login</a> </strong></p>

    <?php endif ?>
    </p>
    <script>$('.alert').alert()</script>

</footer>
</div>
</div>
</body>
</html>

