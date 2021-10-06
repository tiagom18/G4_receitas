<?php
    session_start();
    session_destroy();

    echo '<script>window.location = "../screen/index.html"</script>'
?>