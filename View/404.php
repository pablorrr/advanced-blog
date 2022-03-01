<!DOCTYPE html>
<html>
<style>
    body, html {
        height: 100%;
        margin: 0;
    }

    .bgimg {
        height: 100%;
        background-position: center;
        background-size: cover;
        position: relative;
        color: black;
        font-family: "Courier New", Courier, monospace;
        font-size: 25px;
    }
    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    hr {
        margin: auto;
        width: 40%;
    }
</style>
<body>

<div class="bgimg">

    <div class="middle">
        <h1>404 PAGE DOESN'T EXIST</h1>
        <hr>
        <p>redirected for a while to the main page.....</p>
    </div>

</div>

</body>
</html>
<?php header('Refresh: 3; URL=http://simplyblogadvanced.test/main-page'); ?>
