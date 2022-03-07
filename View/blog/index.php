<?php require ROOT_PATH . 'View/components/header.php' ?>
<?php require ROOT_PATH . 'View/components/msg.php' ?>

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
    <body>
    <header>
        <!-- Intro settings -->
        <style>
            #intro {
                /* Margin to fix overlapping fixed navbar */
                margin-top: 58px;
            }

            @media (max-width: 991px) {
                #intro {
                    /* Margin to fix overlapping fixed navbar */
                    margin-top: 45px;
                }
            }
        </style>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" target="_blank" href="https://mdbootstrap.com/docs/standard/">

                </a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                        data-mdb-target="#navbarExample01"
                        aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarExample01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" aria-current="page" href="<?= ROOT_URL ?>">Home</a>
                        </li>

                        <?php if (!empty($_SESSION['is_logged'])): ?>
                            <li class="nav-item active">
                                <p> Welcome <?= $_SESSION['userEmail']; ?></p>
                            </li>

                            <li class="nav-item active">
                                <a class="nav-link" aria-current="page" href="<?= ROOT_URL ?>admin/register">
                                    Register</a>
                            </li>

                            <li class="nav-item active">
                                <a class="nav-link" aria-current="page" href="<?= ROOT_URL ?>admin">Admin</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" aria-current="page" href="<?= ROOT_URL ?>logout">Logout</a>
                            </li>


                        <?php endif ?>

                        <?php if (empty($_SESSION['is_logged'])): ?>
                            <li class="nav-item active">
                                <a class="nav-link" aria-current="page" href="<?= ROOT_URL ?>login">Login</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar -->

        <!-- Jumbotron -->
        <div id="intro" class="p-5 text-center bg-light">
            <h1 class="mb-3 h2">Welcome Blog Page</h1>
            <p class="mb-3">Just for educational purposes</p>

        </div>
        <!-- Jumbotron -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="my-5">
        <div class="container">
            <!--Section: Content-->
            <section class="text-center">
                <h4 class="mb-5"><strong>Main Posts Page</strong></h4>
                <div class="row text-center">
                    <div class="col-lg-4 col-md-4 mb-4"></div>

                    <?php foreach ($this->oPosts as $oPost): ?>
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
                    <?php endforeach ?>

                    <?php if (isset($_SESSION['is_logged'])) : ?>

                        <button type="button" onclick="window.location='<?= ROOT_URL ?>add'" class="bold">Add New Post
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