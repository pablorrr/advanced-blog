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
        <p>redirected for a while to the main page....<span id="countdown">10</span> seconds....</p>
    </div>

</div>
<script type="text/javascript">

    // Total seconds to wait
    var seconds = 6;

    function countdown() {
        seconds = seconds - 1;
        if (seconds > 0) {
            // Update remaining seconds
            document.getElementById("countdown").innerHTML = seconds;
            // Count down using javascript
            window.setTimeout("countdown()", 1000);
        }
    }

    // Run countdown function
    countdown();

</script>
</body>
</html>