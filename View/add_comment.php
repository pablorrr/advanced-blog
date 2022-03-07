<?php require 'components/header.php' ?>
<?php require 'components/comment-msg.php' ?>

<h1> Add comment page</h1>
<form action="" method="POST">

    <p><label for="comment">Comment(musi skladac sie conajmniej z dwoch slow):</label><br/>
        <textarea name="comment" id="comment" rows="5" cols="35" required="required"></textarea>
    </p>

    <p><input type="submit" name="add_comment" value="Add"/></p>
</form>

<?php require 'components/footer-form.php' ?>
