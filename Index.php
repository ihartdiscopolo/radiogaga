<?php
include 'inc/functions.php';
db_connect();
htmlHead("Radiogaga");
?>
<div class="mainContainer">
    <div class="Banner">
        <h1>Welcome to Radiogaga!!</h1>
        <p>Here is a website on a few of my favorite artists! :3</p>
        <br>
        <a href="Playlist.php?albumId=1">To playlist!</a>
    </div>
</div>
<?php
htmlFooter();