<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Student Pictures</title>

    <style>
    body
    {
      font-family:'Lucida Console';
    }

    div
    {
      display:flex;
      justify-content:center;
      align-items:center;
    }
    button
    {
      background-color:lightblue;
      border-radius:50px;
      margin-top:10px;
      padding:5px 10px;
    }

      button:hover
      {
        background-color:#9a9acf;
      }

    .drag
    {
      padding:100px;
      text-align:center;
    }

    .button
    {
      position: absolute;
      top: 165px;
      left: 350px;
      right: 350px;
      bottom: 290px;
    }

    .img
    {
      background-image: url("images/126477.png");
      background-size: contain;
      background-position: center;
      width:100px;
      height:100px;
      margin-left: auto;
      margin-right: auto;
    }

    .button:hover
    {
      background-color: rgba(81, 52, 224, 0.38);

    }

    nav
    {
      text-align: right;
      padding-top: 40px;
      padding-right: 40px;
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

    </style>
  </head>
  <body>
    <nav>
      <a href="login.php">Login</a>
      <a href="redirect.php">Home</a>
    </nav>

<?php
session_start();

if(!isset($_SESSION['activeUser']) || $_SESSION['activeUser'][1] =='Admin') header('location:login.php');

  // check if the user has clicked the button "Upload Image"
if(isset($_POST['sb']))
{
  $filename = $_FILES["fileToUpload"]["name"];
  $tempname = $_FILES["fileToUpload"]["tmp_name"];

  // check file type and size
if (($_FILES["fileToUpload"]["type"] == "image/svg+xml")
|| ($_FILES["fileToUpload"]["type"] == "image/pjpeg")
|| ($_FILES["fileToUpload"]["type"] == "image/png")
|| ($_FILES["fileToUpload"]["type"] == "image/jpeg")
|| ($_FILES["fileToUpload"]["type"] == "image/bmp")
|| ($_FILES["fileToUpload"]["type"] == "image/webp")
|| ($_FILES["fileToUpload"]["type"] =="image/gif")
&& ($_FILES["fileToUpload"]["size"] < 40000)) {

  // print error msgs
  if ($_FILES["fileToUpload"]["error"] > 0)
  echo "Return Code: ".$_FILES["fileToUpload"]["error"] . "<br/>";

  else
  {
    // create a unique filename
$file=explode(".",$filename);
$fileExtension=end($file);

$fn="pic".time().uniqid(rand()).".$fileExtension";

try
{
  require('Connection.php');

  $us=$_SESSION['activeUser'][0];
  $sqli="SELECT id FROM users WHERE username='$us'";
  $rows=$db->query($sqli);

  if ($row=$rows->fetch())
    $sid=$row[0];
  else
    die('Session has been expired');

  $sql="INSERT INTO studentpictures VALUES(Null, '$sid', '$fn')";
  if (move_uploaded_file($tempname, "images/$fn")) {
    echo "Stored in: images/$fn";
    $rs=$db->exec($sql);

    if($rs == 1)
      echo "<br  /><strong style='color:green; background:lightgreen'>Your Picture hass been successfully uploaded</strong>";
    else
      echo "oh no... something went wrong";
  }
  else {echo "Failed to store file";}


  $db=NULL;
} catch (PDOException $e) {
  die('Error:'.$e -> getMessage());
}


}
} //end of checking file type and size
else {echo "Invalid file";}
} //end of checking button

 ?>

<div class="top">
  <form method="POST" enctype="multipart/form-data">
    <table align="center">
      <tr>
        <th><h3>Insert your Image file here:</h3></th>
      </tr>

      <tr>
        <td><i>PNG, JPEG, GIF, BMP, etc. must be less than 4 Mb. Square aspect ratio recommendend.</i> <br/><br/></td>
      </tr>

      <tr>
        <td>
          <div style="border:2px dotted black;">

            <table class="drag">
              <tr>
                <td><div class="img"></div></td>
              </tr>

              <tr>
                <td>Drag and drop your file here</td>
              </tr>

              <tr>
                <td>or</td>
              </tr>

              <tr>
                <td><button>Browse</button></td>
              </tr>

              <tr>
                <td><input class="button" type="file" name="fileToUpload" id="fileToUpload"></td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <!-- make input absolute and top bottom left right = 0 -->

      <tr align="center">
        <td style="padding:20px;"><button class="up" type="submit" name="sb">Upload Image</button></td>
      </tr>
    </table>
 </form>
</div>

 <hr />
 <div class="bottom">
   <table>
      <tr>
        <th><h3>OR</h3></th>
      </tr>

      <tr>
        <th><h3>View all pictures in a new tab:</h3></th>
      </tr>

      <tr align="center">
       <td>
       <form action="viewStudentPictures.php" method="POST">
         <button type="submit" name="view">View All pictures</button>
       </form>
       </td>
      </tr>
   </table>
 </div>
   </body>
 </html>
