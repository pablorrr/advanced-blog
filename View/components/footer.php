<?php

use Controller\MainController;

?>
<footer class="bg-light text-lg-start">
    <script>$('.alert').alert()</script>
    <hr class="m-0"/>

    <div class="text-center py-4 align-items-center">

        <p>Follow MDB on social media</p>
        <a href="#" class="fa fa-facebook"></a>
        <a href="#" class="fa fa-twitter"></a>
        <a href="#" class="fa fa-google"></a>

    </div>
</footer>

</div>
</body>
</html>
<?php MainController::isPageRefreshed();
ob_end_flush(); ?>

