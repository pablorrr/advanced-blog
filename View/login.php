<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php require 'components/header.php' ?>

<br>
<div class="row">
    <div class="md-col-4"></div>
    <div class="md-col-4">
        <h3>Log in Form</h3>
        <form action="" method="post">

            <p><label for="email">Email:</label><br/>
                <input type="email" name="email" id="email" required="required"/>
            </p>

            <p><label for="password">Password:</label><br/>
                <input type="password" name="password" id="password" required="required"/>
            </p>

            <p><input type="submit" value="Log In"/></p>
        </form>
    </div>
    <div class="md-col-4"></div>
</div>
<?php require 'components/footer-form.php' ?>
