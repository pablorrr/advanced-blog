<?php if (!empty($_SESSION['is_logged'])): ?>

    <br>
    <button type="button" onclick="window.location='<?= ROOT_URL ?>edit?id=<?= $oPost->id ?>'"
            class="btn btn-secondary">Edit
    </button>

    <br>
    <br>
    <form action="<?= ROOT_URL ?>delete?id=<?= $oPost->id ?>" method="post" class="inline">
        <button type="submit" name="delete" value="1" class="btn btn-secondary">Delete</button>
    </form>
    <br>

<?php endif ?>

<?php if (empty($oPost->comment)): ?>
    <br>
    <button type="button"
            onclick="window.location='<?= ROOT_URL ?>add-comment?id=<?= $oPost->id ?>'" class="btn btn-secondary">
        Add New Comment
    </button>
    <br>
    <br>
<?php endif; ?>