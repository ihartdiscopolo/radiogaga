<?php
/**
 * @param string $pageTitle
 * @return void
 */
function htmlHead($pageTitle)
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $pageTitle; ?></title>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="icon" type="image/png" href="https://i.pinimg.com/736x/87/75/9e/87759e7f46864cb8fceb14606d541f38.jpg">
    </head>
    <body> 
    <header id="Header">

    <a href="index.php">
        <div id="Logo">Radiogaga</div>
    </a>
<?php
    displayHeader()
?>
    </header>
    <?php
}

function htmlFooter()
{
    ?>
    <footer id="Footer">
        <p>Designed by <a href="https://www.dominikdebska.com/">Dominik Debska</a></p>
    </footer>
    </body>
    </html>
    <?php
}

function db_connect()
{
    // database connection settings
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "radiogaga";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // return database object
    return $conn;
}

function dd($var, $die = false)
{
    // die and display debug information
    echo "<pre style='background-color:#f1f1f1; color:#000; border:1px solid #000; margin:10px; padding:5px;'>";
    var_dump($var);
    echo '</pre>';
    if($die)
    {
        die("End of function dd()");
    }
    
}

function DisplayAlbumImg()
{

    $conn = db_connect();
    $albums = getAlbums();
    foreach ($albums as $album)
    {
        ?>
            <div id="Albums">
                <a href="Playlist.php?albumId=<?php echo $album['albumId'];?>">
                <img src="images/<?php echo $album['albumImage'];?>" title="Album title : <?php echo $album['albumTitle'];?>"
                alt="<?php echo $album['albumTitle'];?>" class="albumImage">
                </a>
            </div>
       <?php
    }
}

function Displaytracks()
 {
    $conn = db_connect();
    $tracks = GetTracks();
    ?>

    <table class="tracksTable">
    <tr>
        <th>Track id</th>
        <th>Track Title</th>
        <th>Track Duration</th>
        <th>Track</th>
    </tr>    
    <?php
    foreach ( $tracks as $track)
    {
        ?>
        <tr>
            <td><?php echo $track['trackId']?></td>
            <td><?php echo $track['trackTitle'] ?></td>
            <td><?php echo $track['trackDuration'] ?></td>
            <td><audio src="tracks/<?php echo $track['trackFile']?>" controls></audio></td>
        </tr>
        <?php
    }
    ?>
    </table>
    <?php
 }

 function getTracks()
 {
    $conn = db_connect();
    if(isset($_GET['albumId']) && is_numeric($_GET['albumId']))
    {
        $sql ="SELECT * FROM tracks WHERE albumId =" . $_GET['albumId'];
    }
    else
    {
        $sql = "SELECT * FROM tracks";
    }
    $resource = $conn->query($sql) or die($conn->error);
    $tracks = $resource->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $tracks;

 }
 function getAlbums()
 {
     $db = db_Connect();
     $sql = "SELECT * FROM albums";
     $resourse = $db->query($sql) or die($db->error);
     $albums = $resourse->fetch_all(MYSQLI_ASSOC);
     return $albums;
 }
 
 function getAlbum()
 {
     $db = db_Connect();
     if (isset($_GET['albumId']) && is_numeric($_GET['albumId'])) { 
         $sql = "SELECT * FROM albums WHERE albumId = " . $_GET['albumId']; 
     } 
     else 
     {
         $sql = "SELECT * FROM albums ORDER BY RAND() LIMIT 1"; 
     }
     $resource = $db->query($sql) or die($db->error);
     $album = $resource->fetch_assoc();
     $tracks = getTracks($album['albumId']);
     $album['tracks'] = $tracks;
     return $album; 
 }

 function DisplayAlbum()
    {
        $album = getAlbum();
    ?>
        <div class="albumDetailsContainer">
        <h3><?php echo $album['albumTitle']; ?></h3>
        <p><?php echo $album['albumDetails']; ?></p>
    </div>
    <?php
    }

 function getArtist()
 {
     $conn = db_connect();
     $sql = "SELECT * FROM artists";
     $result = $conn->query($sql) or die($conn->error);
     $artist = $result->fetch_all(MYSQLI_ASSOC);
     $result->free();
     $conn->close();
     return $artist;
 }

 function displayArtist()
 {
     $artists = getArtist(); // No need to call db_connect() here since getArtist() already does it
 
     foreach($artists as $artist)
     {
         ?>
         <h2 class="Name"><?php echo $artist['artistName']; ?></h2>
         <div class="artists">
            <img src="images/<?php echo $artist['artistImage']?>" >
         <p class="artistDetails">
           <?php echo $artist['artistDetails']; ?>
         </p>
         </div>
         <?php
     }
 }

 function getMusicVideos()
 {
    $conn = db_connect();
    
    if(isset($_GET['albumId']) && is_numeric($_GET['albumId']))
    {
        // Query for a single album
        $sql = "SELECT * FROM `musicvideo` WHERE albumId = " . $_GET['albumId'];
    }

    elseif(isset($_GET['albumid']) && !is_numeric($_GET['albumId']))
    {
        //return a null value
        return null;
    }
    else
    {
        $sql = "SELECT * FROM `musicvideo` ORDER BY RAND() LIMIT 1";
    }

    $result = $conn->query($sql) or die($conn->error);
    $musicvideo = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $musicvideo;
}

 function displayMusicVideos()
 {
    $musicVideos = getMusicVideos();
    foreach($musicVideos as $musicVideo)
    {
        ?>
        <video id="MV" controls src="videos/<?php echo$musicVideo['mvFile']?>"></video>
        <?php
    }
 }

function displayHeader()
{
 $navigation = getHeader();
 foreach ($navigation as $item) {
?>
<nav class = "Main-nav">
 <a href="<?php echo $item['pageFile']; ?>"><?php echo $item['pageName']; ?></a>
 </nav>
<?php
 }
}
function getHeader()
{
 $db = db_connect();
 $sql = "SELECT * FROM navigation";
 $resource = $db->query($sql) or die($db->error);
 $navigation = $resource->fetch_all(MYSQLI_ASSOC);

 return $navigation;
}

// Retrieves popular artists
function getPopulairArtist()
{
    $conn = db_connect();
    $sql = "SELECT * FROM popular_artists"; 
    $result = $conn->query($sql) or die($conn->error);
    $popularArtists = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $popularArtists;
}
// Displays popular artists in a table
function displayPopulairArtist()
{
    $popularArtists = getPopulairArtist();
    ?>
    <table class="PopularArtist">
        <tr>
            <th>Artist Id</th>
            <th>Artist Name</th>
            <th>Genre</th>
            <th>Debut Year</th>
            <th>Country</th>
            <th>Notable Work</th>
            <th>Youtube</th>
        </tr>
        <?php
        foreach ($popularArtists as $popularArtist)
        {
            ?>
            <tr>
                <td><?php echo ($popularArtist['artist_id']); ?></td>
                <td><a href=<?php echo $popularArtist['wikipedia_link'];?> target="_blank">
                    <?php echo ($popularArtist['artist_name']); ?></a></td>
                <td><?php echo ($popularArtist['genre']); ?></td>
                <td><?php echo ($popularArtist['debut_year']); ?></td>
                <td><?php echo ($popularArtist['country']); ?></td>
                <td><?php echo ($popularArtist['notable_work']); ?></td>
                <td class="YoutubeLink">
                    <a href=<?php echo ($popularArtist['youtube_link']);?> target="_blank">
                    <img src="images/Logo_of_YouTube_(2015-2017).svg.png" alt="Youtube Logo"></a>
                </td>
            </tr>
            <?php
        }
    ?>
    </table>
    <?php
}
?>

