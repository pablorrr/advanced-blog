<?php require ROOT_PATH . 'View/components/header.php' ?>

<?php if (empty($this->oPost)): ?>
<body>
<header>
    <!-- Intro settings -->
    <?php require ROOT_PATH . 'View/components/style.php' ?>
    <!-- Navbar -->
    <?php require ROOT_PATH . 'View/components/menu.php' ?>
    <!-- Navbar -->

    <!-- Jumbotron -->
    <div id="intro" class="p-5 text-center bg-light">
        <h1 class="mb-3 h2">The post can't be be found!</h1>
    </div>
    <!-- Jumbotron -->
</header>

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
        <h1 class="mb-3 h2">Single post page</h1>

    </div>

    <!-- Jumbotron -->
</header>

<!--Main layout-->
<main class="my-5">
    <div class="container">
        <!--Section: Content-->
        <section class="text-center">
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <article>
                                <time datetime="<?= $this->oPost->createdDate ?>" pubdate="pubdate"></time>
                                <h5 class="card-title"><?= htmlspecialchars($this->oPost->title) ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars($this->oPost->body)) ?></p>
                                <p class="card-text">Posted on <?= $this->oPost->createdDate ?></p>

                                <?php
                                $oPost = $this->oPost;
                                require ROOT_PATH . 'View/components/control-buttons.php';
                                ?>
                            </article>

                            <?php if (!empty($this->oPost->comment)): ?>
                                <p class="card-text">Comment: <?= $this->oPost->comment ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>


<?php endif ?>

<?php require ROOT_PATH . 'View/components/footer.php' ?>
