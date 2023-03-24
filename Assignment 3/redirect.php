<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menu page</title>

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
      
      button:hover
      {
        background-color:#9a9acf;
      }

      h2
      {
        font-family:'Lucida Console';
      }
    </style>
  </head>
  <body>

    <div class="container">
      <div class="align">
        <table>

<?php
session_start();

if(isset($_SESSION['activeUser']) && $_SESSION['activeUser'][1] =='Admin')
{
if(isset($_POST['ds'])) header('location:displayStudentGrades.php');
if(isset($_POST['ad'])) header('location:addnewStudentwithgrades.php');
?>
          <tr>
            <th><h2>What would you like to do?</h2></th>
          </tr>

         <form method="POST">

          <tr>
              <th><button type="submit" name="ds"> Display Student Grades </button></th>
          </tr>

          <tr>
            <th><button type="submit" name="ad"> Add New Student With Grades </button></th>
          </tr>
         </form>
<?php } ?>

<?php

if (isset($_SESSION['activeUser']) && $_SESSION['activeUser'][1] =='Regular')
{
  if(isset($_POST['ds'])) header('location:displayStudentGrades.php');
  if(isset($_POST['up'])) header('location:UploadStudentPictures.php');
   ?>
  <tr>
    <th><h2>What would you like to do?</h2></th>
  </tr>

 <form method="POST">

  <tr>
      <th><button type="submit" name="ds"> Display Student Grades </button></th>
  </tr>

  <tr>
    <th><button type="submit" name="up"> Upload OR View Student Pictures </button></th>
  </tr>
 </form>

<?php } ?>
</table>

</div>
</div>

</body>
</html>
