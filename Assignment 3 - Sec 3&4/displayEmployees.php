
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Display Employees</title>

    <style>
      /* background and container */
      body
      {
        font-family:'Lucida Console';
      }

      div.container
      {
        height: 800px;
        display:flex;
        justify-content:center;
        align-items:center;
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
        align-items:center;
        flex-direction:column;
      }

      /* input */
      input
      {
        border-radius:10px;
      }

      /* buttons */
      button
      {
        background-color:lightblue;
        border-radius:50px;
        margin-top:20px;
        padding:5px 10px;
      }

      button:hover
      {
        background-color:#9a9acf;
      }

      /* text */
      h2,h1
      {
        text-align: center;
      }

      /* table */
      th,td
      {
        text-align: left;
        padding: 5px;
      }

      table.emp th,td
      {
        text-align:center;
      }

      table, tr,th,td
      {
        border-radius: 10px;
        font-size: 20px;
      }

      /* top right navigation */
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

      a#center
      {
        margin: 0 auto;
      }
    </style>

  </head>
  <body>
    <nav>
      <a href="login.php">Login</a>
      <a href="redirect.php"><!--<img src="images\home.png" width="20px">--> Home</a>
    </nav>
<?php

if(isset($_GET['sb']))
{
try {
  require("connection.php");

  $IDS=$_GET['IDS'];

  $sqli="SELECT Name,Salary,EID FROM Employee WHERE ECode = '$IDS'";
  $ri = $db -> query($sqli);

  // if(($ri->rowCount()) == 0) die("<div style='display:flex; justify-content:center;'>
  //                                       <table>
  //                                         <tr><th><h1 style='color:red'>ID not found</h1></th></tr>
  //                                         <tr><th><h1><a href='displayEmployees.php'>go back</a></h1></th></tr>
  //                                       </table><div>");
  ?>

  <div class="container">
    <div class="align">
  <!-- Employee Name and salary -->
   <table class="student" align="center">

  <?php

  foreach ($ri as $rowi)
  {
          echo "<tr>";
          echo "<th> Name: </th>";
          echo "<td> $rowi[0] </td>";
          echo "</tr>";

          echo "<tr>";
          echo "<th> Salary: </th>";
          echo "<td> $rowi[1] </td>";
          echo "</tr>";

          $rj = $db -> query("SELECT PName,Progress FROM project WHERE EID = '{$rowi['2']}'");

  ?>
   </table>
   <br/>
   <br/>


   <!-- Student Name and Major -->
    <table class="grades" border="1" align="center">

      <tr>
        <th>Project Name</th>
        <th>Progress</th>
      </tr>

   <?php

   foreach ($rj as $row)
   {
     if($row[1]==100)
     {
        echo "<tr style='background-color:green'>";
     }
     else
     {
        echo "<tr>";
     }
     echo "<td> $row[0] </td>";
     echo "<td> $row[1] </td>";
     echo "</tr>";
   }

   ?>
    </table>
    <br>  
    <a href="displayEmployees.php" id="center">Go Back</a>
  </div>
</div>

   <?php

  }
  $db = NULL;


} catch (PDOException $e) {
    die('Error:'.$e -> getMessage());
}
}
else{
 ?>
     <div class="container">
       <div class="align">
         <form method="GET">
           <table class="emp">
             <tr>
               <th><h2>Choose the Employee you want to display:</h2></th>
             </tr>

             <tr>
                <th> 
                  <select name="IDS"> 
                      <?php try {
                      
                        require("connection.php");

                        $sqla="SELECT * FROM employee";
                        $ra=$db->query($sqla);

                        foreach ($ra as $row)
                        echo "<option value='{$row[1]}'>{$row[0]}, {$row[1]}, {$row[2]}</option>";
                      
                        $db=NULL;
                      
                      } catch (PDOException $e) {
                        die('Error:'.$e -> getMessage());
                      }?>  
                  </select>
                </th>
             </tr>

             <tr>
               <th><button type="submit" name="sb">Show</button></th>
             </tr>
           </table>
         </form>
       </div>
     </div>

   </body>
 </html>
<?php } ?>
