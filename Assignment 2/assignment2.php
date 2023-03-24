<?php
// Assignment 2, 12 nov 2022

// student name and ID:

            // MARYAM EMADUDDIN SALEH KAMASHKI    202002021
            // NOUR AHMAD WAIS                    20196624
            // ROMAYSAA SAMI ABDO AHMED           20197197

// defining variables
$out="";  //output

// if there's a value in basic salary and view history button has not been clicked then it means calculate salary button is clicked
if (isset($_POST['basic']))
{
  if(!isset($_POST['view'])) //&& !isset($_POST['clear'])
  {
      if($_POST['basic'] != null) //if there's a value in basic do the following (not empty)
        {
            $total=0; //Total Salary
            $martial=0; //Martial Status Allowance
            $total_eta = 0; //Extra Tasks Allowance

            // setting the value of martial status
            if($_POST['ms']=="single") {$martial=50;}
            else if($_POST['ms']=="married") {$martial=100;}

                // if there's "extra" checkboxes checked
                if(isset($_POST['extra']))
                {
                    // for loop: for each value in "extra"
                    foreach ($_POST['extra'] as $a)
                    {
                      // split the array
                      $array=explode("#",$a);
                      $eta[]=$array[0]; //the value before the #
                      $caption[]=$array[1]; //the caption after the #

                      $total_eta+=$array[0]; //calculating the sum of all checkboxes
                    }
                }

                // start calculations: Total Salary = Basic Salary + Martial Status Allowance + Extra Tasks Allowance
                // note: if total eta is empty it will be 0 so if i add it to anything it's as if it wasn't there
                $total=($_POST['basic']) + $martial + $total_eta;
                $out="<ul><li> Salary Details: Total Salary is BD " .$total ."</li>";

                // if there's extra checkboxes selected print their text
                if(isset($_POST['extra']))
                {
                  $out .= "<li> Extras: </li><ol>";

                    foreach ($caption as $a)
                    {
                      $out .= "<li>".$a ."</li>";
                    }
                  $out .= "</ol> </ul>";
                }

                // only if the user selected the save checkbox all values will be stored
                if(isset($_POST['save']))
                {
                  if (isset($_COOKIE['historyDetails'])) $cookieValue = json_decode($_COOKIE['historyDetails'], true);
                  else $cookieValue = array();

                  $details['Total'] = $total;
                  $details['Date'] = date('d/m/Y');
                  $details['Time'] = date('H:i:s');

                          if(isset($_POST['extra']))
                          {
                                foreach ($caption as $a)
                              {
                                  $details['Extras'][] = $a;
                              }
                          }

                  $cookieValue[] = $details;
                  setcookie("historyDetails",json_encode($cookieValue),time() + 7 * 24 * 60 * 60);

                  $out .= "<br /> saved";
                }

            }

         else if ($_POST['basic'] == null) die("You must enter your basic salary");
       }

       if(isset($_POST['view']))
       {
               if(!isset($_COOKIE['historyDetails'])) die("no cookies stored");

               else
               {
                    // print_r(json_decode($_COOKIE['historyDetails'], true));

                    $data = json_decode($_COOKIE['historyDetails'], true);

                    $out = "<table> <tr>
                                 <th> Total </th>
                                 <th> Date </th>
                                 <th> Time </th>
                                 <th> Extras </th>";

                        $out .= "</tr>";

                     foreach ($data as $key =>$value)
                     {
                         // extract($t);
                           $out .= "<tr>
                                    <td>" .$value['Total'] ."</td>
                                    <td>" .$value['Date'] ."</td>
                                    <td>" .$value['Time'] ."</td>";

                         if(isset($value['Extras']))
                         {
                           $out .= "<td> <ol>";
                             for($i=0; $i < count($value['Extras']); $i++)
                             {
                               $out .= "<li>" .$value['Extras'][$i] ."</li>";
                             }
                          $out .= "</td> </ol>";
                         }

                         else $out .= "<td> No Extras </td>";

                     $out .= "</tr>";
                    }
               }
        }
       // else if(isset($_POST['clear']))
       // {
       // setcookie("historyDetails","",time() - 7 * 24 * 60 * 60);
       // die('cleared');
       // }

       }
       ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>assignment 2</title>

    <style>
        table
          {
            margin-left:auto;
            margin-right:auto;
            border: 2px solid #9a9acf;
          }
        tr,td
          {
            text-align: center;
            padding: 15px;
            border: 2px solid #9a9acf;
          }
        th
          {background-color: #9a9acf;}

        tr:nth-child(odd)
          {background-color: #E6E6FA;}

        li
          {
            padding-right: 25px;
            text-align: left;
           }
    </style>

  </head>
  <body>

    <?php
    // checking for user input
    if(isset($_POST['basic']))
    {
      // printing the statement "Salary Details: Total Salary is BD ###"
      echo $out;
    }

    else { ?>
    <form method='post'>
    Basic Salary <input name='basic' /><br />

    Marital Status: <br />
    <input type='radio' name='ms' value='single' checked/> Single <br />
    <input type='radio' name='ms' value='married' /> Married <br />

    Extra: <br />
    <input type='checkbox' name="extra[]" value="200#Work on Weekend" /> Work on Weekend - BD 200<br />
    <input type='checkbox' name="extra[]" value="100#Work Night Shift" /> Work Night Shift - BD 100<br />
    <input type='checkbox' name="extra[]" value="400#Work Abroad" /> Work Abroad - BD 400<br /> <br />

    Save this details
    <input type='checkbox' name="save" /> <br /> <br />

    <input type='submit' value='Calculate Salary' />
    <input type='submit' value='View History' name='view'/>
    <!-- <input type='submit' value='clear History' name='clear'/> -->

    </form>
      <?php } ?>
  </body>
</html>
