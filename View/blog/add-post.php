<?php require ROOT_PATH . 'View/components/header.php' ?>
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
            <h4 class="mb-5"><strong>Add post page</strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="title">Title:</label><br>
                            <input type="text" name="title" id="title" class="form-control" required="required"/>
                        </div>
                        <div class="form-group">
                        <label for="body">Body:(musi skladac sie conajmniej z dwoch slow)</label><br/>
                        <textarea name="body" id="body" class="form-control" rows="5" cols="35" required="required"></textarea>
                        </div>
                        <br>
                        <br>
                        <input type="submit" name="add_submit" class="btn btn-outline-secondary" value="Add"/>
                    </form>
                </div>

                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>
<?php require ROOT_PATH . 'View/components/footer.php' ?>
