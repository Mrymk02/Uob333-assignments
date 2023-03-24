
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Display Student Grades</title>

    <style>
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
        font-size: 20px;
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
<?php

$grade=array("A"=>4, "A-"=>3.7, "B+"=>3.5, "B"=>3, "B-"=>2.7, "C+"=>2.5, "C"=>2, "C-"=>1.7, "D+"=>1.5, "D"=>1, "F"=>0);
$cgpa=$gpa=$TotalCrPassed=$TotalCrReg=$failedcr=0;

if(isset($_GET['sb']))
{
try {
  require("connection.php");

  // $sql = "SELECT
  //               a.Name,
  //               a.Major,
  //               b.CourseCode,
  //               b.CourseGrade
  //         FROM
  //               Students a
  //         INNER JOIN
  //               Grades b
  //         WHERE
  //               a.sid = b.sid";

  $id=$_GET['id'];

  $sqli="SELECT name,major,sid FROM students WHERE universityID = $id";
  $ri = $db -> query($sqli);

  if(($ri->rowCount()) == 0) die("<div style='display:flex; justify-content:center;'>
                                        <table>
                                          <tr><th><h1 style='color:red'>ID not found</h1></th></tr>
                                          <tr><th><h1><a href='displayStudentGrades.php'>go back</a></h1></th></tr>
                                        </table><div>");
  // echo $sql;
  ?>

  <div class="container">
    <div class="align">
  <!-- Student Name and Major -->
   <table class="student" align="center">
  <!-- <tr>
    <th>Name:</th>
    <th>Major:</th>
    <th>Course Code:</th>
    <th>Course Grade:</th>
  </tr> -->

  <?php

  foreach ($ri as $rowi)
  {
          echo "<tr>";
          echo "<th> Name: </th>";
          echo "<td> $rowi[0] </td>";
          echo "</tr>";

          echo "<tr>";
          echo "<th> Major: </th>";
          echo "<td> $rowi[1] </td>";
          echo "</tr>";

          $rj = $db -> query("SELECT CourseCode,CourseGrade,Credits FROM Grades WHERE sid = '$rowi[2]'");

  // foreach ($rs as $row)
  // {
  //       echo "<tr>";
  //       echo "<td> $row[0] </td>";
  //       echo "<td> $row[1] </td>";
  //       echo "<td> $row[2] </td>";
  //       echo "<td> $row[3] </td>";
  //       echo "</tr>";
  // }
  ?>
   </table>
   <br/>
   <br/>


   <!-- Student Name and Major -->
    <table class="grades" border="1" align="center">

      <tr>
        <th>Course Code</th>
        <th>Course Grade</th>
      </tr>

   <?php

   foreach ($rj as $row)
   {
     if($grade[$row[1]]=="F")
     {
        echo "<tr style='background-color:red'>";
        $failedcr+=$row[2];
     }
     else
     {
        echo "<tr>";
     }
        echo "<td> $row[0] </td>";
        echo "<td> $row[1] </td>";
        echo "</tr>";

           $gpa += ($row[2]*$grade[$row[1]]);
           $TotalCrReg += $row[2];
   }
   $cgpa=$gpa/$TotalCrReg;
   $TotalCrPassed = $TotalCrReg-$failedcr;
   // foreach ($rs as $row)
   // {
   //       echo "<tr>";
   //       echo "<td> $row[0] </td>";
   //       echo "<td> $row[1] </td>";
   //       echo "<td> $row[2] </td>";
   //       echo "<td> $row[3] </td>";
   //       echo "</tr>";
   // }
   ?>
    </table>
    <br/>
    <br/>

    <table class="gpa" border="1" align="center">
      <tr>
        <th>Gpa</th>
        <th>Total Credits Registered</th>
        <th>Total Credits Passed</th>
      </tr>

      <tr>
        <td><?php echo $cgpa ?></td>
        <td><?php echo $TotalCrReg ?></td>
        <td><?php echo $TotalCrPassed ?></td>
      </tr>

    </table>
  </div>
</div>

   <?php

  }
  $db = NULL;
   // $gpa=$TotalCrPassed=$TotalCrReg="";
   // foreach ($rs as $row)
   // {
   //   ;
   // }
   // echo $gpa;
   // echo $TotalCrPassed;
   // echo $TotalCrReg;

} catch (PDOException $e) {
    die('Error:'.$e -> getMessage());
}
}
else{
 ?>
     <div class="container">
       <div class="align">
         <form method="GET">
           <table align="center">
             <tr>
               <th><h2>Type Student Id here:</h2></th>
             </tr>

             <tr>
               <th><input type="text" name="id"></th>
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
