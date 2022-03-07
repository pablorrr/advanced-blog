<?php require ROOT_PATH .'View/components/header.php' ?>
<?php require ROOT_PATH .'View/components/admin-msg.php' ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Admin Users List</h1>
        </div>

    </div>
    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Email</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($this->oAdmins as $oAdmin): ?>
                <tr>
                    <td><?= $oAdmin->id ?></td>
                    <td><?= $oAdmin->email ?></td>

                    <?php if (!empty($_SESSION['is_logged'])): ?>
                        <td>
                            <button type="button"
                                    onclick="window.location='<?= ROOT_URL ?>admin/edit?id=<?= $oAdmin->id ?>'"
                                    class="bold">Edit
                            </button>
                        </td>
                        <!--todo dzila ale do poprawy ABY USER NIE MOGLSAM SIE USUSNAC-->
                        <?php if ($oAdmin->email != $_SESSION['userEmail']) : ?>
                            <td>
                                <form action="<?= ROOT_URL ?>admin/delete?id=<?= $oAdmin->id ?>"
                                      method="post" class="inline">
                                    <button type="submit" name="delete" value="1" class="bold">Delete</button>
                                </form>
                            </td>
                        <?php endif ?>
                    <?php endif ?>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>
<?php require ROOT_PATH .'View/components/footer.php' ?>

