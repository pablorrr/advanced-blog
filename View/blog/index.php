<?php require ROOT_PATH . 'View/components/header.php' ?>
<?php require ROOT_PATH . 'View/components/msg.php' ?>

<?php if (empty($this->oPosts)): ?>
    <body>
    <header>
        <!-- Intro settings -->
        <?php require ROOT_PATH . 'View/components/style.php' ?>

        <!-- Navbar -->
        <?php require ROOT_PATH . 'View/components/menu.php' ?>
        <!-- Navbar -->

        <!-- Jumbotron -->
        <div id="intro" class="p-5 text-center bg-light">
            <h1 class="mb-3 h2">Welcome Blog Page</h1>
            <p class="mb-3">Just for educational purposes</p>
            <p class="mb-3">There is no Blog Post.</p>
        </div>

        <!-- Jumbotron -->
    </header>
    <main class="my-5">
        <div class="container">
            <!--Section: Content-->
            <section class="text-center">
                <h4 class="mb-5"><strong>No Posts!!!</strong></h4>
                <div class="row text-center">
                    <div class="col-lg-4 col-md-4 mb-4"></div>
                    <div class="col-lg-4 col-md-4 mb-4">
                        <?php if (isset($_SESSION['is_logged'])) : ?>

                            <button type="button" onclick="window.location='<?= ROOT_URL ?>add'"
                                    class="btn-outline-secondary">
                                Add Your
                                First
                                Blog Post!
                            </button>

                        <?php endif; ?>

                        <?php if (!isset($_SESSION['is_logged'])) : ?>
                            <p> To add your first post you must be logged!!</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4"></div>
                </div>
            </section>
        </div>
    </main>
<?php else: ?>
    <body>
    <header>
        <!-- Intro settings -->
        <?php require ROOT_PATH . 'View/components/style.php' ?>
        <!-- Navbar -->
        <?php require ROOT_PATH . 'View/components/menu.php' ?>
        <!-- Navbar -->

        <!-- Jumbotron -->
        <div id="intro" class="p-5 text-center bg-light">
            <h1 class="mb-3 h2">Welcome Blog Page</h1>
            <p class="mb-3">Just for educational purposes</p>

        </div>
        <!-- Jumbotron -->
    </header>
    <!--Main layout-->
    <main class="my-5">
        <div class="container">
            <!--Section: Content-->
            <section class="text-center">
                <h4 class="mb-5"><strong>Main Posts Page</strong></h4>
                <div class="row text-center">
                    <div class="col-lg-4 col-md-4 mb-4"></div>

                    <?php
                    foreach ($this->oPosts as $oPost): ?>
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-title"><?= htmlspecialchars($oPost->title) ?></h5>

                                <p class="card-text"><?= nl2br(htmlspecialchars(mb_strimwidth($oPost->body, 0, 100, '...'))) ?></p>
                                <p class="card-text">Posted on <?= $oPost->createdDate ?></p>

                                <?php if (property_exists($oPost, 'comment') == true): ?>
                                    <p class="card-text">
                                        Comments: <?= nl2br(htmlspecialchars(mb_strimwidth($oPost->comment, 0, 5, '...'))) ?></p>
                                <?php endif; ?>
                                <?php require ROOT_PATH . 'View/components/control-buttons.php' ?>

                                <a href="<?= ROOT_URL ?>single-post?id=<?= $oPost->id ?>" class="btn btn-primary">Want
                                    to see more?</a>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach ?>

                    <?php if (isset($_SESSION['is_logged'])) : ?>

                        <button type="button" class="btn btn-primary" onclick="window.location='<?= ROOT_URL ?>add'">Add
                            New Post
                        </button>
                        <br>
                        <br>
                    <?php endif ?>
                    <div class="col-lg-4 col-md-4 mb-4"></div>
                </div>
            </section>
        </div>
    </main>


<?php endif ?>
<?php require ROOT_PATH . 'View/components/footer.php' ?>