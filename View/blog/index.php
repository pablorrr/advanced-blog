<?php require  ROOT_PATH .'View/components/header.php' ?>
<?php require  ROOT_PATH .'View/components/msg.php' ?>

<?php if (empty($this->oPosts)): ?>

    <p class="bold">There is no Blog Post.</p>

    <?php if (isset($_SESSION['is_logged'])) : ?>
        <p>
            <button type="button" onclick="window.location='<?= ROOT_URL ?>add'" class="bold">Add Your
                First
                Blog Post!
            </button>
        </p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['is_logged'])) : ?>
        <p> To add your first post you must be logged!!</p>
    <?php endif; ?>

<?php else: ?>
    <div class="container">
        <div class="row center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1>Main posts page</h1>
                <br>
                <br>

                <?php foreach ($this->oPosts as $oPost): ?>
                    <h1>
                        <a href="<?= ROOT_URL ?>single-post?id=<?= $oPost->id ?>"><?= htmlspecialchars($oPost->title) ?></a>
                    </h1>

                    <p><?= nl2br(htmlspecialchars(mb_strimwidth($oPost->body, 0, 100, '...'))) ?></p>
                    <p><a href="<?= ROOT_URL ?>single-post?id=<?= $oPost->id ?>">Want to see more?</a></p>

                    <p class="left small italic">Posted on <?= $oPost->createdDate ?></p>

                    <?php if (property_exists($oPost, 'comment') == true): ?>
                        <p>Comments: <?= nl2br(htmlspecialchars(mb_strimwidth($oPost->comment, 0, 5, '...'))) ?></p>
                    <?php endif; ?>
                    <?php require ROOT_PATH .'View/components/control-buttons.php' ?>
                    <hr class="clear"/><br/>
                <?php endforeach ?>

                <?php if (isset($_SESSION['is_logged'])) : ?>

                    <button type="button" onclick="window.location='<?= ROOT_URL ?>add'" class="bold">Add New Post
                    </button>
                    <br>
                    <br>
                <?php endif ?>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

<?php endif ?>
<?php require  ROOT_PATH .'View/components/footer.php' ?>