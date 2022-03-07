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