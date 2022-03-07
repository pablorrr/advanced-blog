<?php if (!empty($_SESSION['AdminSuccMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['AdminSuccMsg'] ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>


<?php if (!empty($_SESSION['AdminErrorMsg'])): ?>

    <!-- Modal -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= $_SESSION['AdminErrorMsg'] ?></strong>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif ?>






