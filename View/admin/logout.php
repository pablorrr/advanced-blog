<?php require ROOT_PATH . 'View/components/header.php' ?>
<body>
<header>
    <!-- Intro settings -->
    <?php require ROOT_PATH . 'View/components/style.php' ?>
    <!-- Navbar -->
    <?php require ROOT_PATH . 'View/components/menu.php' ?>
    <!-- Navbar -->
</header>
<!--Main layout-->
<main class="my-5">
    <div class="container">
        <!--Section: Content-->
        <section class="text-center">
            <br>
            <br>
            <h4 class="mb-5"><strong><?= $_SESSION['userEmail']; ?></strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <p>You are updated yourself please press log out button and log in again to see results of upgrade</p>
                    <button  class="btn btn-outline-secondary"><a href="<?= PROT . $_SERVER['SERVER_NAME'] ?>/logout">Logout</a></button>
                </div>
                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>
<?php require ROOT_PATH . 'View/components/footer-form.php' ?>




