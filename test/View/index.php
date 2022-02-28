<?php require 'components/header.php' ?>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

<?php if (empty($this->oPosts)): ?>

    <p class="bold">There is no Blog Post.</p>

    <?php if (isset($_SESSION['is_logged'])) : ?>
        <p>
            <button type="button" onclick="window.location='<?= ROOT_URL ?>?p=blog&amp;a=add'" class="bold">Add Your
                First
                Blog Post!
            </button>
        </p>
    <?php endif; ?>

    <?php if (!isset($_SESSION['is_logged'])) : ?>
        <p> To add your first post you must be logged!!</p>
    <?php endif; ?>

<?php else: ?>

    <!--todo : rozwiazac problem z wyswietlaniem sie postow  dla ktorych pryyzpada iecej niz jeden komentzrz-->
    <?php foreach ($this->oPosts as $oPost): ?>

        <h1>
            <a href="<?= ROOT_URL ?>?p=blog&amp;a=post&amp;id=<?= $oPost->id ?>"><?= htmlspecialchars($oPost->title) ?></a>
        </h1>

        <p><?= nl2br(htmlspecialchars(mb_strimwidth($oPost->body, 0, 100, '...'))) ?></p>
        <p><a href="<?= ROOT_URL ?>?p=blog&amp;a=post&amp;id=<?= $oPost->id ?>">Want to see more?</a></p>

        <p class="left small italic">Posted on <?= $oPost->createdDate ?></p>

        <?php if (property_exists($oPost, 'comment') == true): ?>
            <p>Comments: <?= nl2br(htmlspecialchars(mb_strimwidth($oPost->comment, 0, 5, '...'))) ?></p>
        <?php endif; ?>


        <hr class="clear"/><br/>
    <?php endforeach ?>
    <?php if (isset($_SESSION['is_logged'])) : ?>
        <button type="button" onclick="window.location='<?= ROOT_URL ?>?p=blog&amp;a=add'" class="bold">Add New Post
        </button>
    <?php endif ?>
<?php endif ?>





<?php require 'components/footer.php' ?>