<!-- just to add test users -->
<?php
$msg=$n=$un=$ps=$cps="";
$pregN="/^[a-z ]{2,15}$/i";
$pregUn="/^[\w0-9.]{5,29}$/i";
$pregPs="/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Z0-9_#@%\*\-]{8,24}/i";

if(isset($_POST['sb']))
{

  if (trim($_POST['n'])=="" || trim($_POST['un'])=="" || trim($_POST['ps'])=="" || trim($_POST['cps'])=="")
  $msg = "<p style='background-color:#FFCCCB; color:#D2042D; padding:5px; border-radius:5px;'><strong>all inputs should be filled!</strong></p>";

  if(($_POST['cps'] == $_POST['ps']) && preg_match($pregN,$_POST['n']) && preg_match($pregUn,$_POST['un']) && preg_match($pregPs,$_POST['ps']))
  {

try {

      require("connection.php");

      $name = $_POST['n'];
      $username = $_POST['un'];
      $password = password_hash($_POST['ps'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users value(NULL,'$name','$username','$password','Regular')";

        $rec = $db -> exec($sql);

        if($rec == 1)
        echo "<strong style='color:green; background:lightgreen'>You have successfully registered</strong>";
        else
        echo "oh no... something went wrong";

        $db = null;

    } catch (PDOException $e) {

          die('Error:'.$e -> getMessage());
    }

  }
  //

  else
  {

    if(!preg_match($pregN,$_POST['n']))
    $n = "<p style='background-color:#FFCCCB; color:#D2042D; padding:5px; border-radius:5px;'><strong>Please enter valid a name in the range of 2-15 characters</strong></p>";

    if(!preg_match($pregUn,$_POST['un']))
    $un = "<p style='background-color:#FFCCCB; color:#D2042D; padding:5px; border-radius:5px;'><strong>Please enter a valid username using letters, numbers . or _</strong></p>";

    if(!preg_match($pregPs,$_POST['ps']))
    $ps = "<p style='background-color:#FFCCCB; color:#D2042D; padding:5px; border-radius:5px;'><strong>Please enter a valid password, it must include:</strong> <br/> 1. at least 8 characters long <br/> 2. has at least one uppercase and lowercase letter <br/> 3. has at least one digit <br/> 4. special character allowed are _, #, @, %, *, - </p>";

    if($_POST['cps'] != $_POST['ps'])
    $cps = "<p style='background-color:#FFCCCB; color:#D2042D; padding:5px; border-radius:5px;'><strong>Password did not match! Try again.</p>";

    else echo "something went wrong";
  }

}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign-Up</title>
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
    </style>
  </head>
  <body>
    <div class="container">
      <div class="align">
        <form method="post">
          <?php echo $msg; ?>
          <table>
            <tr>
              <td><label>Name</label></td>
              <td><input type="text" name="n" /></td>
            </tr>

            <?php echo "<tr><td colspan='2'>$n</td></tr>";?>

            <tr>
              <td><label>Username</label></td>
              <td><input type="text" name="un"></td>
            </tr>

            <?php echo "<tr><td colspan='2'>$un</td></tr>";?>

            <tr>
              <td><label>Password</label></td>
              <td><input type="password" name="ps"></td>
            </tr>

            <?php echo "<tr><td colspan='2'>$ps</td></tr>";?>

            <tr>
              <td><label>Confirm Password</label></td>
              <td><input type="password" name="cps" ></td>
            </tr>

            <?php echo "<tr><td colspan='2'>$cps</td></tr>";?>

          </table>

          <button type="submit" name="sb"><b>Sign up</b></button>

        </form>
      </div>
    </div>
  </body>
</html>
