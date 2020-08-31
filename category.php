<?php
/* only accessible with a video_type */ 
session_start();
if (isset($_SESSION['user']) && isset($_GET['type'])) {
try {
  $DB = new PDO('mysql:host=localhost;dbname=sqrflix;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die ('Erreur ' . $e->getMessage());
}
$req = $DB->prepare('SELECT * FROM videos WHERE video_type = ?');
$req -> execute(array($_GET['type']));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/burger_menu.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>SQRFLIX - <?php echo $_GET['type']?></title>
</head>
<body>
    <header id="main-header" class="main-header">
        <img id="logo-small" class="logo-small" src="assets/pictures/sqrflix-logo-small.png" alt="SQRFLIX Logo">
        <img id="header-picture"  class="hearder-picture image_category" src="assets/pictures/shining-long.png" alt="The Shining">
    </header>
    <div class="category-name"><?php echo '<h3>' . $_GET['type'] . '</h3>' ?></div>
    <section class="movies">
      <div class="grid-container">
        <!-- movie -->
        <?php 
        while($data = $req->fetch()){
          echo '<figure class="movie">
          <a href="videopage.php?title=' . $data['title'] . '"><img class= "image_category" src="assets/pictures/movie_thumbnails/' . $data['photo'] . '" alt="' . $data['title'] . '"></a>
          </figure>';
        }
        ?>
      </div>
    </section>
    <?php include("navbar.php"); ?>
    <?php include("footer.php"); ?>
    
    
    <script>
      document.getElementById("mySearchButton").addEventListener("click", () => {
          document.getElementsByClassName("hidden_navbar")[0].style.visibility = "visible";
          setTimeout(() => {
            document.getElementsByClassName("hidden_navbar")[0].style.visibility = "hidden";
          }, 10000);
      })
    </script>
</body>
</html>
<?php
}
else 
{
  header('location:login.php');
}
?>