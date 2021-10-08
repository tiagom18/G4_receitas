<?php
    session_start();
    session_destroy();

    echo '<script>window.location = "../G4_receitas/login/screen/index.php"</script>'
?>