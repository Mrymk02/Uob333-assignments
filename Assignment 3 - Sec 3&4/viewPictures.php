<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Student Pictures</title>

    <style>
      body
      {
        font-family:'Lucida Console';
      }

      .container, .text
      {
        display:flex;
        justify-content:center;
      }

      .container
      {
        flex-wrap: wrap;
      }

      img
      {
        width:300px;
        height:300px;
      }

      .header
      {
        width: 100%;
        text-align: center;
        padding: 20px;
      }

      nav
      {
        text-align: right;
        padding: 20px;
      }

      a
      {
        color: black;
        text-decoration: none;
        background-color:lightblue;
        border: 2px solid black;
        border-radius:50px;
        margin-top:20px;
        padding:5px 10px;
      }

      a:hover
      {
        background-color:#9a9acf;
      }

      .inner
      {
        display: flex;
        justify-content: space-between;
      }

      .style
      {
        padding: 40px;
        color: red;
      }
    </style>
  </head>
  <body>

    <div class="container">
<?php
session_start();

if(!isset($_SESSION['activeUser']) || $_SESSION['activeUser'][1] !='Admin') header('location:login.php');

try {
  require('Connection.php');

  $us=$_SESSION['activeUser'][0];
  $un=$_SESSION['activeUser'][2];
  $sqli="SELECT id FROM users WHERE username='$us'";
  $rows=$db->query($sqli);

  if ($row=$rows->fetch())
    $sid=$row[0];
  else
    die('Session has been expired');

  $sql="SELECT * from projectspictures WHERE PID=$sid";
  $rs=$db->query($sql);

  ?>
<div class="header">
  <div class="inner">
    <h1>You are viewing pictures of <?php echo $un; ?></h1>
    <nav>
      <a href="login.php">Login</a>
      <a href="redirect.php">Home</a>
    </nav>
  </div>
  <hr>
  <?php if(($db->query("SELECT COUNT(*) FROM projectspictures"))=='0')echo "<h3 class='style'> There are no pictures to view </h3>";?>

</div>


<?php
  foreach($rs as $row)
  {
    ?>

<div class="card">
  <table>
    <tr>
      <th>Image Id</th>
      <th><?php echo $row[0] ?></th>
    </tr>

    <tr>
      <th><img src='images/<?php echo $row[2] ?>'></th>
    </tr>
  </table>
</div>

<?php  }

$db=NULL;
} catch (PDOException $e) {
  die('Error:'.$e -> getMessage());
}
?>
    </div>

<div class="text">
<h1><a href="uploadPictures.php">go back</a></h1>
</div>

</body>
</html>
