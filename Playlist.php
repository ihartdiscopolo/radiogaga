<?php
include 'inc/functions.php';
$albums = getAlbums();
// dd($albums);
htmlHead("Playlists!");
?>
<main id="Main">
    <div id="album-container">
        <?php
        DisplayAlbumImg();
        ?>
    </div>
    </div>
    <div id="playlist-container">\
    <?php 
        DisplayAlbum();
        displayMusicVideos();
        Displaytracks(); 
    ?>
    </div>
</main>
<?php
htmlFooter();
?>