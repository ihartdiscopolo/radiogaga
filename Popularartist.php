<?php
include 'inc/functions.php';
db_connect();
htmlHead("Popular Artist!");
?>
<main id= "Popular">
    <?php displayPopulairArtist()?>
</main>
<?php
    htmlFooter();
?>