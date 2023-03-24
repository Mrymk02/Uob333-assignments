
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>

    <style>
    div.container
    {
      height: 800px;
      display:flex;
      justify-content:center;
      align-items:center;
    }

     div.align
     {
        width: 500px;
        height: 500px;
        background-color:lightgrey;
        border-radius: 10px;
        display:flex;
        justify-content:center;
        align-items:center;
        font-family:'Lucida Console';

      }

      label
      {
        margin-right:10px;
        font-family:'Lucida Console';
      }

      input
      {
        border-radius:10px;
      }

      button
      {
        background-color:lightblue;
        border-radius:50px;
        margin-top:20px;
        padding:5px 10px;
        font-family:'Lucida Console';
      }

      button:hover
      {
        background-color:#9a9acf;
      }
    </style>
  </head>
  <body>
<?php
if(isset($_POST['sb'])){
  //connect to the session
  session_start();

try {

  require("Connection.php");

    $user = $_POST['un'];
    $sql = "SELECT * FROM users WHERE username = '$user'";
     //if i used SELECT password,name instead name will be in index[1] and password [0]

    $rec = $db -> query($sql);
    // echo $sql;

    $db = null;

} catch (PDOException $e) {

      die('Error:'.$e -> getMessage());
}

// if($countRows = $rec->rowCount()){}
// it showes number of rows found in the record if there's none it will display 0 which is false

// another way (reccomended by the dr)
if($row = $rec -> fetch()){

  // check for password ($row[3] is the index of password in the DB you can also use $row['password'])
  // if($_POST['ps'] == $row[3]) commented because it will not work for hashed passwords :(
  if(password_verify($_POST['ps'] , $row['password']))
  {
    $_SESSION['activeUser'] = array($user,$row['userType'],$row['name']);

    //takes user to main page
    header('location:redirect.php');
  }
  else {echo"User found! but the password is incorrect";}

}
else{
  echo "User not found";
}}
?>

    <div class="container">
      <div class="align">
        <form method="POST">
          <table>
            <tr>
              <td><label style="margin-right:10px; font-family:'Lucida Console';">Username</label></td>
              <td><input type="text" name="un" style="border-radius:10px;"></td>
            </tr>

            <tr>
              <td><label style="margin-right:10px; font-family:'Lucida Console';">Password</label></td>
              <td><input type="password" name="ps" style="border-radius:10px;"></td>
            </tr>

            <tr>
              <td><button type="submit" name="sb">Login</button></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </body>
</html>
