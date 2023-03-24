<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add New Student</title>
    <style>
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

    </style>
  </head>

  <body>
<?php
// regular expression validation
$nm_mj="/^[a-z ]{2,20}$/i";
$uid="/^20(1[3-9]|2[0-2]){1}\d{4,5}$/";
$cr="/^[1234]{1}/i";
$cc="/^[a-z]{3,5}[1234][0-9]{2}$/i";
$cg="/^(([BC](-|\+)?)|A(-)?|D\+?|F)$/i";

session_start();

if(!isset($_SESSION['activeUser']) || $_SESSION['activeUser'][1] !='Admin')  header('location:login.php');

if(isset($_POST['sb']))
{
  if($_POST['noc']>0){ ?>
    <div class="container scale">
      <div class="align scale">
  <form method="POST">
    <table>
      <tr>
        <th colspan="2"><h1>Enter Student Details:</h1></th>
      </tr>
    </table>
  <table class="student" border="1" align="center">
    <tr>
      <td>Student Id</td>
      <td><input type="text" name="uid" value=""></td>
    </tr>

    <tr>
      <td>Student Name</td>
      <td><input type="text" name="nm" value=""></td>
    </tr>

    <tr>
      <td>Student Major</td>
      <td><input type="text" name="mj" value=""></td>
    </tr>
  </table>
  <br>
    <?php
    for($i=1;$i<=$_POST['noc'];$i++)
    {
      echo "<h1>Course $i </h1>"; ?>
    <table class="courses" border="1" align="center">

      <tr>
        <td>Course Code</td>
        <td><input type="text" name="cc[]" value=""></td>
      </tr>

      <tr>
        <td>Credits</td>
        <td><input type="text" name="cr[]" value=""></td>
      </tr>

      <tr>
        <td>Course Grade</td>
        <td><input type="text" name="cg[]" value=""></td>
      </tr>
    </table>
  <?php } }
  else {
    if($_POST['noc']<=0) die("<div style='display:flex; justify-content:center;'>
                                          <table>
                                            <tr><th><h1 style='color:red'>cannot enter zero courses</h1></th></tr>
                                            <tr><th><h1><a href='addnewStudentwithgrades.php'>go back</a></h1></th></tr>
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
  $er="";

    if(!preg_match($uid, $_POST['uid'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['uid']}'</span> ,please enter a valid student id</li>";
    if(!preg_match($nm_mj, $_POST['nm'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['nm']}'</span> ,please enter a valid name</li>";
    if(!preg_match($nm_mj, $_POST['mj'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['mj']}'</span> ,please enter a valid major</li>";

    for($i=0; $i < count($_POST['cc']); $i++)
    {
    if(!preg_match($cc, $_POST['cc'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cc'][$i]}'</span> ,please enter a valid course code</li>";
    if(!preg_match($cr, $_POST['cr'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cr'][$i]}'</span> ,please enter a valid credit</li>";
    if(!preg_match($cg, $_POST['cg'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cg'][$i]}'</span> ,please enter a valid course grade</li>";
    }

    if (strlen($er)>0)
      die("Error list: <ul>$er</ul>");



  try {
    require ("Connection.php");
    $db->beginTransaction();
// student details

    $sqla="INSERT INTO students (universityID,name,major) VALUES(:universityID, :name,:major)";
    $ra=$db->prepare($sqla);

    $ra->execute(array(':universityID'=>$_POST['uid'], ':name'=>$_POST['nm'], ':major'=>$_POST['mj']));
    $counta=$ra->rowCount();

    $sid=$db->lastInsertId();

    $sqlb="INSERT INTO Grades (Sid,CourseCode,Credits,CourseGrade) VALUES($sid,:CourseCode,:Credits,:CourseGrade)";
    $rb=$db->prepare($sqlb);

    $rb->bindParam(':CourseCode', $CourseCode);
    $rb->bindParam(':Credits', $Credits);
    $rb->bindParam(':CourseGrade',$CourseGrade);

// Grades details
    $c=0;
    for($i=0; $i < count($_POST['cc']); $i++)
    {
      $CourseCode = $_POST['cc'][$i];
      $Credits = $_POST['cr'][$i];
      $CourseGrade = $_POST['cg'][$i];

      if ($rb->execute()) ++$c;
    }
    $db->commit();

    echo $counta." students have been inserted <br/>";
    echo $c." rows have been inserted";


    $db=NULL;
  } catch (PDOException $e) {

    die('Error:'.$e -> getMessage());
  }

}
else{
?>

<!-- <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add New Student</title>
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

      button
      {
        background-color:lightblue;
        border-radius:50px;
        margin-top:20px;
        padding:5px 10px;
        font-family:'Lucida Console';
      }
      button:hover{
        background-color:purple;
      }

      h2
      {
        font-family:'Lucida Console';
      }
    </style>
  </head>

  <body> -->
    <div class="container">
      <div class="align">

      <table>
        <tr>
          <th><h2>How many Courses would you like to enter?</h2></th>
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
      <?php
      // if(isset($_POST['sb']))
      // {
      //   if($_POST['noc']>0){ ?>
        <!-- <h1>Enter Student Details:</h1>
        <form method="POST">
        <table class="student" border="1">
          <tr>
            <td>Student Id</td>
            <td><input type="text" name="uid" value=""></td>
          </tr>

          <tr>
            <td>Student Name</td>
            <td><input type="text" name="nm" value=""></td>
          </tr>

          <tr>
            <td>Student Major</td>
            <td><input type="text" name="mj" value=""></td>
          </tr>
        </table> -->
          <?php
          // for($i=1;$i<=$_POST['noc'];$i++)
          // {
          //   echo "<h1>Course $i </h1>"; ?>
          <!-- <table class="courses" border="1">

            <tr>
              <td>Course Code</td>
              <td><input type="text" name="cc[]" value=""></td>
            </tr>

            <tr>
              <td>Credits</td>
              <td><input type="text" name="cr[]" value=""></td>
            </tr>

            <tr>
              <td>Course Grade</td>
              <td><input type="text" name="cg[]" value=""></td>
            </tr>
          </table> -->
        <?php // } }
        // else {
        //   if($_POST['noc']<=0) die("cannot enter 0 columns");
        //}?>
        <!-- <br/>
        <button type="submit" name="sb2">Submit</button>
      </form> -->
    <?php
    // else if (isset($_POST['sb2']))
    // {
    //   $er="";
    //
    //     if(!preg_match($uid, $_POST['uid'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['uid']}'</span> ,please enter a valid student id</li>";
    //     if(!preg_match($nm_mj, $_POST['nm'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['nm']}'</span> ,please enter a valid name</li>";
    //     if(!preg_match($nm_mj, $_POST['mj'])) $er.= "<li>You entered: <span style='color:red'>'{$_POST['mj']}'</span> ,please enter a valid major</li>";
    //
    //     for($i=0; $i < count($_POST['cc']); $i++)
    //     {
    //     if(!preg_match($cc, $_POST['cc'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cc'][$i]}'</span> ,please enter a valid course code</li>";
    //     if(!preg_match($cr, $_POST['cr'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cr'][$i]}'</span> ,please enter a valid credit</li>";
    //     if(!preg_match($cg, $_POST['cg'][$i])) $er.=  "<li>Course ".($i+1).": You entered: <span style='color:red'>'{$_POST['cg'][$i]}'</span> ,please enter a valid course grade</li>";
    //     }
    //
    //     if (strlen($er)>0)
    //       die("Error list: <ul>$er</ul>");
    //
    //
    //   try {
    //     require ("Connection.php");
    //     $db->beginTransaction();
    // // student details
    //
    //     $sqla="INSERT INTO students (universityID,name,major) VALUES(:universityID, :name,:major)";
    //     $ra=$db->prepare($sqla);
    //
    //     $ra->execute(array(':universityID'=>$_POST['uid'], ':name'=>$_POST['nm'], ':major'=>$_POST['mj']));
    //     $counta=$ra->rowCount();
    //
    //     $sid=$db->lastInsertId();
    //
    //     $sqlb="INSERT INTO Grades (Sid,CourseCode,Credits,CourseGrade) VALUES($sid,:CourseCode,:Credits,:CourseGrade)";
    //     $rb=$db->prepare($sqlb);
    //
    //     $rb->bindParam(':CourseCode', $CourseCode);
    //     $rb->bindParam(':Credits', $Credits);
    //     $rb->bindParam(':CourseGrade',$CourseGrade);
    //
    // // Grades details
    //     $c=0;
    //     for($i=0; $i < count($_POST['cc']); $i++)
    //     {
    //       $CourseCode = $_POST['cc'][$i];
    //       $Credits = $_POST['cr'][$i];
    //       $CourseGrade = $_POST['cg'][$i];
    //
    //       if ($rb->execute()) ++$c;
    //     }
    //     $db->commit();
    //
    //     echo $counta." students have been inserted <br/>";
    //     echo $c." rows have been inserted";
    //
    //
    //     $db=NULL;
    //   } catch (PDOException $e) {
    //
    //     die('Error:'.$e -> getMessage());
    //   }
    //
    // }
  }?>
    </body>
  </html>