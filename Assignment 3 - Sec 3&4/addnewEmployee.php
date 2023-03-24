<?php
// regular expression validation
$Name="/^[a-z ]{2,20}$/i";
$ECode="/^[a-z]{2}(\-)?\d{6}$/i";
$Salary="/^[1-9][0-9,]{1,5}$/i";

session_start();

if(!isset($_SESSION['activeUser']) || $_SESSION['activeUser'][1] !='Admin')  header('location:login.php');

if (isset($_POST['sb2']))
{
  if((trim($_POST['id'])=="")||(trim($_POST['nm'])=="")||(trim($_POST['sl'])==""))
  { die("<div style='display:flex; justify-content:center;'>
                                        <table>
                                          <tr><th><h1 style='color:red'>Cells cannot be empty</h1></th></tr>
                                          <tr><th><h1><a href='addnewEmployee.php'>go back</a></h1></th></tr>
                                        </table><div>");}

  $er="";

    if(!preg_match($ECode, $_POST["id"])) $er.= "<li>You entered: <span style='color:red'>'{$_POST["id"]}'</span> ,please enter a valid employee id</li>";
    if(!preg_match($Name, $_POST['nm'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['nm']}'</span> ,please enter a valid name</li>";
    if(!preg_match($Salary, $_POST['sl'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['sl']}'</span> ,please enter a valid Salary</li>";

    if (strlen($er)>0)
      die("Error list: <ul>$er</ul>");



  try {
    require ("connection.php");
    $db->beginTransaction();
// student details

    $sqla="INSERT INTO employee (ECode,Name,Salary) VALUES(:ECode, :Name,:Salary)";
    $ra=$db->prepare($sqla);

    $ra->execute(array(':ECode'=>$_POST['id'], ':Name'=>$_POST['nm'], ':Salary'=>$_POST['sl']));
    $counta=$ra->rowCount();

    $db->commit();

    echo "<div style='display:flex; justify-content:center;'>
                                          <table>
                                            <tr><th><h1>" .$counta. "Employee has been inserted</h1></th></tr>
                                            <tr><th><h1><a href='addnewEmployee.php'>add another employee</a></h1></th></tr>
                                          </table><div> <br/>";


    $db=NULL;
  } catch (PDOException $e) {

    die('Error:'.$e -> getMessage());
  }

}
else{
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add New Employee</title>
    <style>
    body
    {
      font-family:'Lucida Console';
    }

    div.container
    {
      height: 100%;
      display:flex;
      justify-content:center;
    }

     div.align
     {
       padding: 20px;
        width: 500px;
        height: auto;
        background-color:lightgrey;
        border-radius: 10px;
        display:flex;
        justify-content:center;
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

      h2,h1
      {
        text-align: center;
      }

      th,td
      {
        text-align: center;
        padding: 5px;
      }

      table, tr,th,td
      {
        border-radius: 10px;
      }

      nav
      {
        text-align: right;
        margin-top: 40px;
        margin-right: 40px;
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

    <div class="container scale">
      <div class="align scale">
  <form method="POST">
    <table>
      <tr>
        <th colspan="2"><h1>Enter Employee Details:</h1></th>
      </tr>
    </table>
  <table class="student" border="1" align="center">
    <tr>
      <td>Employee Id</td>
      <td><input type="text" name="id" value=""></td>
    </tr>

    <tr>
      <td>Name</td>
      <td><input type="text" name="nm" value=""></td>
    </tr>

    <tr>
      <td>Salary</td>
      <td><input type="text" name="sl" value=""></td>
    </tr>
  </table>
  <br>
  <br/>
  <table align="center">
    <tr>
      <th><button type="submit" name="sb2" >Submit</button></th>
    </tr>
  </table>
</form>
</div>
</div>
    </body>
  </html>

<?php } ?>
