<?php if (!empty($_SESSION['CommentSuccessMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['CommentSuccessMsg']; ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>
