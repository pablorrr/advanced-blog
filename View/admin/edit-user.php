<?php require ROOT_PATH . 'View/components/header.php' ?>
<?php require ROOT_PATH . 'View/components/admin-msg.php' ?>

<body>
<header>
    <!-- Intro settings -->
    <?php require ROOT_PATH . 'View/components/style.php' ?>
    <!-- Navbar -->
    <?php require ROOT_PATH . 'View/components/menu.php' ?>
    <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main class="my-5">
    <div class="container">
        <!--Section: Content-->
        <section class="text-center">
            <br>
            <br>
            <h4 class="mb-5"><strong>Edit User Page</strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <form action="" method="post">

                        <div class="form-group">
                            <label for="email">email:</label><br/>
                            <input type=email name="email" id="email" class="form-control"
                                   value="<?= trim(htmlspecialchars($this->oAdmin->email)) ?>"
                                   required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="password">password:</label><br/>
                            <input type=password name="password" id="password" class="form-control" value=""
                                   required="required"/>
                        </div>
                        <!-- confirm -->
                        <div class="form-group">
                            <label for="confirm">confirm password:</label><br/>
                            <input type=password name="confirm" id="confirm" class="form-control" value=""
                                   required="required"/>
                        </div>

                <br>
                <br>
                <input type="submit" name="edit_submit" class="btn btn-outline-secondary" value="Update"/>

                </form>
                </div>

                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>
<?php require ROOT_PATH . 'View/components/footer.php' ?>
