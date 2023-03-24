<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Menu page</title>

    <style>
      /* background and containers */
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
         width: 500px;
         height: 500px;
         background-color:lightgrey;
         border-radius: 10px;
         display:flex;
         justify-content:center;
         align-items:center;
       }

       /* buttons */
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
    </nav>

    <div class="container">
      <div class="align">
        <table>

<?php
session_start();

if(isset($_SESSION['activeUser']) && $_SESSION['activeUser'][1] =='Admin')
{
if(isset($_POST['ad'])) header('location:addnewEmployee.php');
if(isset($_POST['as'])) header('location:assignProjects.php');
if(isset($_POST['up'])) header('location:UploadPictures.php');
?>
          <tr>
            <th><h2>What would you like to do?</h2></th>
          </tr>

         <form method="POST">

          <tr>
            <th><button type="submit" name="ad"> Add New Employee </button></th>
          </tr>

          <tr>
            <th><button type="submit" name="as"> Assign Projects </button></th>
          </tr>

          <tr>
            <th><button type="submit" name="up"> Upload OR View Pictures </button></th>
          </tr>
         </form>
<?php } ?>

<?php

if (isset($_SESSION['activeUser']) && $_SESSION['activeUser'][1] =='Regular')
{
  if(isset($_POST['ds'])) header('location:displayEmployees.php');
   ?>
  <tr>
    <th><h2>What would you like to do?</h2></th>
  </tr>

 <form method="POST">

  <tr>
      <th><button type="submit" name="ds"> Display Employees </button></th>
  </tr>

 </form>

<?php } ?>
</table>

</div>
</div>

</body>
</html>
