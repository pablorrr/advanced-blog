<?php
/**
 * @author           Pierre-Henry Soria <phy@hizup.uk>
 * @copyright        (c) 2015-2017, Pierre-Henry Soria. All Rights Reserved.
 * @license          Lesser General Public License <http://www.gnu.org/copyleft/lesser.html>
 * @link             http://hizup.uk
 */
?>
<?php require 'components/header.php' ?>

<!--todo add prtoection validate in php-->

<h3>Info</h3>
<p> 1. Email must be unique  </p>
<p> 2. Password must contains at least 6 characters , at least one digit , at least one letter.</p>
<p> for e.g pwd1234567 </p>

<form action="" method="POST">


    <p><label for="email">User Email</label><br/></p>
    <p><input type="email" name="email" id="email" value="" required="required"/></p>
    <p><label for="password">User Password</label><br/></p>
    <p><input type="password" name="password" id="password" required="required"/></p>
    <p><label for="confirm">Confirm Password</label><br/></p>
    <p><input type="password" name="confirm" id="confirm" required="required"/></p>


    <p><input type="submit" name="register" value="register"/></p>
</form>

<?php require 'components/footer-form.php' ?>
