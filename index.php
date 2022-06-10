<?php

declare(strict_types=1); ?>

<!DOCTYPE html>
<html>

<head>
   <link rel="stylesheet" href="./style.css">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
</head>

<body>
   <?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "personnelman";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
   }
   if (isset($_POST['deleteEm'])) {
      $sqlDelete = "DELETE FROM personnel WHERE id = " . $_POST['deleteEm'] . "";
      if (mysqli_query($conn, $sqlDelete))
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
      die;
   }
   if (isset($_POST['deleteM'])) {
      $sqlDelete = "DELETE FROM machines WHERE id = " . $_POST['deleteM'] . "";
      if (mysqli_query($conn, $sqlDelete))
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
      die;
   }
   if (isset($_POST['createEmpl'])) {
      $sqlCreate = "INSERT INTO personnel (fname, lname)
         VALUES ('" . $_POST['fname'] . "', '" . $_POST['lname'] . "')";
      if (mysqli_query($conn, $sqlCreate))
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
      die;
   }
   if (isset($_POST['machine'])) {
      $check = "SELECT * from machines WHERE machine_name = '" . $_POST['machine'] . "'";
      $alreadyExists = mysqli_query($conn, $check);
      if (mysqli_num_rows($alreadyExists) < 1) {
         $sqlCreate = "INSERT INTO machines (machine_name)
         VALUES ('" . $_POST['machine'] . "')";
         if (mysqli_query($conn, $sqlCreate))
            header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
      die;
   }
   print('<div class="navbar">
               <div>
                  <a href="?path=darbuotojai">Darbuotojai</a>
                  <a href="?path=masinos">Mašinos</a>
               </div>
               <p>Įmonės X mašinų valdymas</p>
            </div>');
   $sql = "SELECT personnel.id, fname, lname, machine_name 
            FROM personnel LEFT JOIN Machines ON Personnel.Machine_id = Machines.id";
   $result = mysqli_query($conn, $sql);
   if (isset($_GET['path']) and $_GET['path'] === 'darbuotojai') {
      print("<table>
                  <tr>
                     <th>ID</th>
                     <th>Vardas</th>
                     <th>Pavardė</th>
                     <th>Mašinos ID</th>
                     <th>Pasirinktys</th>
                  </tr>");
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            print('<tr>
                        <td>' . $row["id"] . '</td> 
                        <td>' . $row["fname"] . '</td>
                        <td>' . $row["lname"] . '</td>
                        <td> ' . $row["machine_name"] . '</td>
                        <td>
                           <form method="POST" action="">
                              <button id= "deleteEm" name="deleteEm" value="' . $row["id"] . '">Ištrinti</button>
                              <button id="updateEm" name="updateEm" value="">Atnaujinti</button>
                           </form>
                        </td>
                     </tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
      print("<form class='createForm' action='' method='POST'>
                  <input type='text' name='fname' placeholder='Vardas' required>
                  <input type='text' name='lname' placeholder='Pavardė' required>
                  <button id='createEmpl' name='createEmpl'>Sukurti</button>
               </form>");
   }
   $sql2 =  'SELECT Machines.id, machine_name, GROUP_CONCAT(CONCAT_WS(" ", fname, lname)SEPARATOR ", ") as fullname 
               FROM personnel RIGHT JOIN Machines ON Machines.id=Personnel.Machine_id GROUP BY machine_name order by id';
   $result2 = mysqli_query($conn, $sql2);
   if (isset($_GET['path']) and $_GET['path'] === 'masinos') {
      print("<table >
                  <tr>
                     <th>ID</th>
                     <th>Mašinos ID</th>
                     <th>Darbuotojai</th>
                     <th>Pasirinktys</th>
                  </tr>");
      if (mysqli_num_rows($result2) > 0) {
         while ($row = mysqli_fetch_assoc($result2)) {
            print('<tr>
                        <td>' . $row["id"] . '</td> 
                        <td>' . $row["machine_name"] . '</td> 
                        <td>' . $row["fullname"] . '</td>
                        <td>
                           <form method="POST" action="">
                              <button id= "deleteM" name="deleteM" value="' . $row["id"] . '">Ištrinti</button>
                              <button>Atnaujinti</button>
                           </form>
                        </td>
                     </tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
      print("<form class='createForm' action='' method='POST'>
                  <select id='machine' name='machine' onfocus='this.size=11;' onchange='this.size=1; onblur='this.size=0;' >
                     <option value='H-1'>H-1</option>
                     <option value='H-2'>H-2</option>
                     <option value='H-4'>H-4</option>
                     <option value='H-5'>H-5</option>
                     <option value='H-6'>H-6</option>
                     <option value='E-1'>E-1</option>
                     <option value='H-7'>H-7</option>
                     <option value='H-8'>H-8</option>
                     <option value='H-9'>H-9</option>
                     <option value='H-10'>H-10</option>
                     <option value='S-1'>S-1</option>
                  </select>
                  <button>Pridėti</button>
               </form>");
   } else if (!isset($_GET['path'])) {
      print("<table>
                  <tr>
                     <th>ID</th>
                     <th>Vardas</th>
                     <th>Pavardė</th>
                     <th>Mašinos ID</th>
                     <th>Pasirinktys</th>
                  </tr>");
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            print('<tr>
                        <td>' . $row["id"] . '</td>
                        <td>' . $row["fname"] . '</td>
                        <td>' . $row["lname"] . '</td>
                        <td> ' . $row["machine_name"] . '</td>
                        <td>
                           <form method="POST" action="">
                              <button id= "deleteEm" name="deleteEm" value="' . $row["id"] . '">Ištrinti</button>
                              <button id="updateEm" name="updateEm" value="">Atnaujinti</button>
                           </form>
                        </td>
                        </tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
      print("<form class='createForm' action='' method='POST'>
                  <input type='text' name='fname' placeholder='Vardas' required>
                  <input type='text' name='lname' placeholder='Pavardė' required>
                  <button id='createEmpl' name='createEmpl'>Pridėti</button>
               </form>");
   }
   print("<footer>
            <p>Copyright</p>
         </footer>");
   mysqli_close($conn);
   ?>
</body>

</html>