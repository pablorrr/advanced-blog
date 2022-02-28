<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */


/**
 * Since PHP 5.4, the echo short tag "<?= ?> is always available, so I use it to simplify the visibility of the template
 */
?>
<?php require 'components/header.php' ?>
<?php require 'components/admin-msg.php' ?>

<h1>Admin Users List</h1>

<?php foreach ($this->oAdmins as $oAdmin): ?>

    <table>
        <tr>
            <th>id</th>
            <th>Email</th>
        </tr>
        <tr>
            <td><?= $oAdmin->id ?></td>
            <td><?= $oAdmin->email ?></td>
        </tr>
    </table>

    <?php require 'components/control_buttons_admin.php' ?>

    <hr class="clear"/><br/>
<?php endforeach ?>

<?php require 'components/footer.php' ?>

