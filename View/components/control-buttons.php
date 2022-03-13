<?php if (!empty($_SESSION['is_logged'])): ?>

    <br>
    <div class="row">
        <div class="col-md-5"></div>

        <div class="col-md-1">
            <button type="button" onclick="window.location='<?= ROOT_URL ?>edit?id=<?= $oPost->id ?>'"
                    class="btn btn-secondary">Edit
            </button>
        </div>
        <div class="col-md-1">
            <form action="<?= ROOT_URL ?>delete?id=<?= $oPost->id ?>" method="post" class="inline">
                <button type="submit" name="delete" value="1" class="btn btn-secondary">Delete</button>
            </form>
        </div>
        <div class="col-md-5"></div>
    </div>
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