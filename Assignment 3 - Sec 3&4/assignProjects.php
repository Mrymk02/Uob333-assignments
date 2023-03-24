<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Assign Project</title>
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
        flex-direction: column;
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

      .check
      {
        text-align: left;
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

if(!isset($_SESSION['activeUser']) || $_SESSION['activeUser'][1] !='Admin')  header('location:login.php');

if(isset($_POST['sb']))
{
  if($_POST['noc']>0){ ?>
    <div class="container">
      <div class="align">

        <form method="post">
              <?php
    for($i=1;$i<=$_POST['noc'];$i++)
    {
      echo "<h1>Project $i </h1>"; ?>
    <table class="projects" border="1" align="center">

      <tr>
        <td>Project Id</td>
        <td><input type="text" name="pid[]" value=""></td>
      </tr>

      <tr>
        <td>Project Name</td>
        <td><input type="text" name="pn[]" value=""></td>
      </tr>

      <tr>
        <td>Project Progress</td>
        <td><input type="text" name="pr[]" value=""></td>
      </tr>

      <tr>
        <th colspan='2' style="background:lightblue">Employees</th>
      </tr>

      <tr>
        <th colspan="2">
          <select name="EID[]"> 
            <?php try {
                require("connection.php");

                $sqla="SELECT * FROM employee";
                $ra=$db->query($sqla);
                
                foreach($ra as $row)
                echo "<option value='{$row[1]}'>{$row[0]}, {$row[1]}, {$row[2]}</option>";
              
                $db=NULL;
                  
            } catch (PDOException $e) {
              die('Error:'.$e -> getMessage());
            }?>  
          </select>
        </th>
      </tr>


    </table>
  <?php } }
  else {
    if($_POST['noc']<=0) die("<div style='display:flex; justify-content:center;'>
                                          <table>
                                            <tr><th><h1 style='color:red'>You Cannot assign Zero projects</h1></th></tr>
                                            <tr><th><h1><a href='assignProjects.php'>go back</a></h1></th></tr>
                                          </table><div>");
  }?>
  <br/>
  <table align="center">
    <tr>
      <th><button type="submit" name="sb2" >Submit</button></th>
    </tr>
  </table>
</form>
</div>
</div>
<?php }

else if (isset($_POST['sb2']))
{
  $total=0;
  try {
    require ("connection.php");

    $db->beginTransaction();

    $sqlb="INSERT INTO project(PID,EID,Progress,PName) VALUES(:PID,:EID,:Progress,:PName)";
    $rb=$db->prepare($sqlb);

    for ($i=0; $i < count($_POST['pid']); $i++)
    {
      $rb->bindParam(':PID', $_POST['pid'][$i]);
      $rb->bindParam(':EID', $_POST['EID'][$i]);
      $rb->bindParam(':Progress', $_POST['pr'][$i]);
      $rb->bindParam(':PName', $_POST['pn'][$i]);

      $total+=$rb->rowCount();
    }
    echo "$total rows has been inserted";

    $db->commit();

    // $db=NULL;
  } catch (PDOException $e) {
    die('Error:'.$e -> getMessage());
  }
}
else{
?>
    <div class="container">
      <div class="align">

      <table>
        <tr>
          <th><h2>How many projects would you like to enter?</h2></th>
        </tr>

      <form method="POST">
        <tr align="center">
          <td><input type="number" name="noc" minlength="1"></td>
        </tr>

        <tr>
          <th><button type="submit" name="sb">Submit</button></th>
        </tr>
      </table>
      </form>
    </div>
  </div>
      <br> <br>
  <?php }?>
    </body>
  </html>
