<?php require ROOT_PATH . 'View/components/header.php' ?>
<br>
<br>
<br>
<?php require ROOT_PATH .'View/components/msg.php' ?>
<br>

<?php if (empty($this->oPost)): ?>
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

            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">

                    <h4 class="mb-5"><strong>Post Data Not Found!</strong></h4>

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
</header>
<!--Main layout-->
<main class="my-5">
    <div class="container">
        <!--Section: Content-->
        <section class="text-center">
            <br>
            <br>
            <h4 class="mb-5"><strong>Edit Post</strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="title">Title:</label><br/>
                            <input type="text" name="title" id="title" class="form-control"
                                   value="<?= htmlspecialchars($this->oPost->title) ?>"
                             required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="body">Body:(musi skladac sie conajmniej z dwoch slow)</label><br/>
                            <textarea name="body" id="body" class="form-control" rows="5" cols="35" required="required">
                                <?= htmlspecialchars($this->oPost->body) ?>
                            </textarea>
                        </div>

                        <?php if (!empty($this->oPost->comment)): ?>
                            <div class="form-group">
                                <label for="comment">Comment:</label><br/>
                                <textarea name="comment" id="comment" rows="5" cols="35" class="form-control"
                                          required=""><?= htmlspecialchars($this->oPost->comment) ?></textarea>
                            </div>
                        <?php endif ?>
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
<?php endif ?>
<?php require ROOT_PATH . 'View/components/footer.php' ?>


