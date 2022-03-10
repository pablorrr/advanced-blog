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
            <h4 class="mb-5"><strong>Register User</strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">

                    <h3>Info</h3>
                    <p> 1. Email must be unique </p>
                    <p> 2. Password must contains at least 6 characters , at least one digit , at least one letter.</p>
                    <p> for e.g pwd1234567 </p>

                    <form action="" method="post">

                        <div class="form-group">
                            <label for="email">User Email</label><br/>
                            <input type=email name="email" id="email" class="form-control"
                                   value="" required="required"/>
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
                        <input type="submit" name="register" class="btn btn-outline-secondary" value="register"/>

                    </form>
                </div>

                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>

<?php require ROOT_PATH . 'View/components/footer-form.php' ?>
