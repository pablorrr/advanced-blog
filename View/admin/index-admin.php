<?php require ROOT_PATH .'View/components/header.php' ?>
<?php require ROOT_PATH .'View/components/admin-msg.php' ?>
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
            <h4 class="mb-5"><strong>Admin Users List</strong></h4>
            <div class="row text-center">
                <div class="col-lg-4 col-md-4 mb-4"></div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <table class="table table-dark">
                        <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Email</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        foreach ($this->oAdmins as $oAdmin): ?>
                            <tr>
                                <td><?= $oAdmin->id ?></td>
                                <td><?= $oAdmin->email ?></td>

                                <?php if (!empty($_SESSION['is_logged'])): ?>
                                    <td>
                                        <button type="button"
                                                onclick="window.location='<?= ROOT_URL ?>admin/edit?id=<?= $oAdmin->id ?>'"
                                                class="btn btn-outline-secondary">Edit
                                        </button>
                                    </td>
                                    <!--todo dzila ale do poprawy ABY USER NIE MOGLSAM SIE USUSNAC-->
                                    <?php if ($oAdmin->email != $_SESSION['userEmail']) : ?>
                                        <td>
                                            <form action="<?= ROOT_URL ?>admin/delete?id=<?= $oAdmin->id ?>"
                                                  method="post" class="inline">
                                                <button type="submit" name="delete" value="1"  class="btn btn-outline-secondary">Delete</button>
                                            </form>
                                        </td>
                                    <?php endif ?>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-lg-4 col-md-4 mb-4"></div>
            </div>
        </section>
    </div>
</main>
<?php require ROOT_PATH .'View/components/footer.php' ?>

