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
      $dbname = "personnel_projects";
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      if (!$conn) {
         die("Connection failed: " . mysqli_connect_error());
      }
      if (isset($_POST['deleteEm'])) {
         $stmt = $conn->prepare("DELETE FROM personnel WHERE id = ?");
         $stmt->bind_param("i", $_POST['deleteEm']);
         $stmt->execute();
         $stmt->close();
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      if (isset($_POST['deleteP'])) {
         $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
         $stmt->bind_param("i", $_POST['deleteP']);
         $stmt->execute();
         $stmt->close();
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      if (isset($_POST['createEmpl'])) {
         $fname = htmlspecialchars($_POST['fname']);
         $lname = htmlspecialchars($_POST['lname']);
         $stmt = $conn->prepare("INSERT INTO personnel (fname, lname)
            VALUES (?,?)");
         $stmt->bind_param("ss", $fname, $lname);
         $stmt->execute();
         $stmt->close();
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      if (isset($_POST['project'])) {
         $projectName = htmlspecialchars($_POST['project']);
         $check = "SELECT * from projects WHERE project_name = '" . $projectName . "'";
         $alreadyExists = mysqli_query($conn, $check);
         if (mysqli_num_rows($alreadyExists) < 1) {
            $stmt = $conn->prepare("INSERT INTO projects (project_name)
               VALUES (?)");
            $stmt->bind_param("s", $projectName);
            $stmt->execute();
            $stmt->close();
            header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            die;
         }
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      if (isset($_POST['updateSql'])) {
         $fname = htmlspecialchars($_POST['fname']);
         $lname = htmlspecialchars($_POST['lname']);
         $sqlUpdate = "UPDATE personnel LEFT JOIN Projects ON Personnel.Project_id = Projects.id
                              SET
                              fname = '$fname',
                              lname = '$lname',
                              project_id =  (SELECT id FROM Projects WHERE project_name = '" . $_POST['pName'] . "')
                              WHERE personnel.id = " . $_POST['updateSql'] . "";
         if (mysqli_query($conn, $sqlUpdate))
            header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      if (isset($_POST['submit'])) {
         $projectUpdateName = htmlspecialchars($_POST['projectUpdate']);
         $check = "SELECT * from projects WHERE project_name = '" . $projectUpdateName . "'";
         $alreadyExists = mysqli_query($conn, $check);
         if (mysqli_num_rows($alreadyExists) < 1) {
            $sqlUpdate = "UPDATE projects
                                 SET
                                 project_name = '" . $projectUpdateName . "'
                                 WHERE id = " . $_POST['submit'] . "";
            if (mysqli_query($conn, $sqlUpdate))
               header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            die;
         }
         header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
         die;
      }
      print('<div class="navbar">
                  <div>
                     <a href="?path=darbuotojai">Darbuotojai</a>
                     <a href="?path=projektai">Projektai</a>
                  </div>
                  <p>Darbuotojų ir jų projektų valdymas</p>
               </div>');
      $sql = "SELECT personnel.id, fname, lname, project_name, project_id 
                        FROM personnel LEFT JOIN Projects ON Personnel.Project_id = Projects.id";
      $result = mysqli_query($conn, $sql);
      if (isset($_GET['path']) and $_GET['path'] === 'darbuotojai') {
         print("<table>
                     <tr>
                        <th>ID</th>
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>Projektas</th>
                        <th>Pasirinktys</th>
                     </tr>");
         if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               print('<tr>
                           <td>' . $row["id"] . '</td> 
                           <td>' . $row["fname"] . '</td>
                           <td>' . $row["lname"] . '</td>
                           <td> ' . $row["project_name"] . '</td>
                           <td>
                              <form method="POST" action="">
                                 <button id= "deleteEm" name="deleteEm" value="' . $row["id"] . '">Ištrinti</button>
                                 <button id="updateEm" name="updateEm" value="' . $row["id"] . '">Atnaujinti</button>
                              </form>
                           </td>
                        </tr>');
            }
         } else {
            echo "0 results";
         }
         print("</table>");
         if (!isset($_POST['updateEm'])) {
            print("<form class='createForm' action='' method='POST'>
                        <input type='text' name='fname' placeholder='Vardas' required>
                        <input type='text' name='lname' placeholder='Pavardė' required>
                        <button id='createEmpl' name='createEmpl'>Pridėti</button>
                     </form>");
         } else if (isset($_POST['updateEm'])) {
            print("<form class='updateForm' action='' method='POST'>
                        <p class='createId'> Pakeisti darbuotojo, kurio ID yra " . $_POST['updateEm'] . ", duomenis</p>");
            $sql = "SELECT fname, lname, project_name, projects.id
            FROM personnel LEFT JOIN Projects ON Personnel.Project_id = Projects.id WHERE personnel.id =" . $_POST['updateEm'] . "";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            print("
                        <input type='text' name='fname' placeholder='Pakeisti darbuotojo vardą' value='" . $row["fname"] . "'required>
                        <input type='text' name='lname' placeholder='Pakeisti darbuotojo pavardę' value='" . $row["lname"] . "' required>
                        <select id='pName' name='pName' onfocus='this.size=5'>
                           <option value='" . $row["project_name"] . "'>" . $row["project_name"] . "</option>");
            $select = "SELECT project_name FROM projects WHERE projects.id != (SELECT project_id FROM Personnel WHERE personnel.id =" . $_POST['updateEm'] . ")";
            $result = mysqli_query($conn, $select);
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  print("<option value='" . $row["project_name"] . "'>" . $row["project_name"] . "</option>");
               }
               print("</select>
                           <button type='updateSql' name='updateSql' value=" . $_POST['updateEm'] . ">Pakeisti</button>
                     </form>");
            }
         }
      }
      $sql2 =  'SELECT Projects.id, project_name, GROUP_CONCAT(CONCAT_WS(" ", fname, lname)SEPARATOR ", ") as fullname 
                           FROM personnel RIGHT JOIN Projects ON Projects.id=Personnel.Project_id GROUP BY project_name order by id';
      $result2 = mysqli_query($conn, $sql2);
      if (isset($_GET['path']) and $_GET['path'] === 'projektai') {
         print("<table >
                     <tr>
                        <th>ID</th>
                        <th>Projektas</th>
                        <th>Darbuotojai</th>
                        <th>Pasirinktys</th>
                     </tr>");
         if (mysqli_num_rows($result2) > 0) {
            while ($row = mysqli_fetch_assoc($result2)) {
               print('<tr>
                           <td>' . $row["id"] . '</td> 
                           <td>' . $row["project_name"] . '</td> 
                           <td>' . $row["fullname"] . '</td>
                           <td>
                              <form method="POST" action="">
                                 <button id= "deleteP" name="deleteP" value="' . $row["id"] . '">Ištrinti</button>
                                 <button id="updateP" name="updateP" value="' . $row["id"] . '">Atnaujinti</button>
                              </form>
                           </td>
                        </tr>');
            }
         } else {
            echo "0 results";
         }
         print("</table>");
         if (!isset($_POST['updateP'])) {
            print("<form class='createForm' action='' method='POST'>
                        <input type='text' name='project' required>
                        <button>Pridėti</button>
                     </form>");
         } else if (isset($_POST['updateP'])) {
            print("<form class='updateForm' action='' method='POST'>
                        <p>Pakeisti projektą, kurio id yra " . $_POST['updateP'] . "</p>");
            $sql = "SELECT project_name FROM  Projects WHERE projects.id = " . $_POST['updateP'] . "";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            print("<input type='text' name='projectUpdate' value='" . $row['project_name'] . "' required>
                        <button type='submit' name='submit' value='" . $_POST['updateP'] . "'>Pakeisti</button>
                     </form>");
         }
      } else if (!isset($_GET['path'])) {
         print("<table>
                     <tr>
                        <th>ID</th>
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>Projektas</th>
                        <th>Pasirinktys</th>
                     </tr>");
         if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
               print('<tr>
                           <td>' . $row["id"] . '</td>
                           <td>' . $row["fname"] . '</td>
                           <td>' . $row["lname"] . '</td>
                           <td> ' . $row["project_name"] . '</td>
                           <td>
                              <form method="POST" action="">
                                 <button id= "deleteEm" name="deleteEm" value="' . $row["id"] . '">Ištrinti</button>
                                 <button id="updateEm" name="updateEm" value="' . $row["id"] . '">Atnaujinti</button>
                              </form>
                           </td>
                        </tr>');
            }
         } else {
            echo "0 results";
         }
         print("</table>");
         if (!isset($_POST['updateEm'])) {
            print("<form class='createForm' action='' method='POST'>
                        <input type='text' name='fname' placeholder='Vardas' required>
                        <input type='text' name='lname' placeholder='Pavardė' required>
                        <button id='createEmpl' name='createEmpl'>Pridėti</button>
                     </form>");
         } else if (isset($_POST['updateEm'])) {
            print("<form class='updateForm' action='' method='POST'>
               <p class='createId'> Pakeisti darbuotojo, kurio ID yra " . $_POST['updateEm'] . ", duomenis</p>");
            $sql = "SELECT fname, lname, project_name, projects.id
               FROM personnel LEFT JOIN Projects ON Personnel.Project_id = Projects.id WHERE personnel.id =" . $_POST['updateEm'] . "";
            $result = mysqli_query($conn, $sql);
            mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            print("<input type='text' name='fname' placeholder='Pakeisti darbuotojo vardą' value='" . $row["fname"] . "'required>
                        <input type='text' name='lname' placeholder='Pakeisti darbuotojo pavardę' value='" . $row["lname"] . "' required>
                        <select id='pName' name='pName' onfocus='this.size=5'>
                           <option selected value='" . $row["project_name"] . "'>" . $row["project_name"] . "</option>");
            $select = "SELECT project_name FROM projects WHERE projects.id != (SELECT project_id FROM Personnel WHERE personnel.id =" . $_POST['updateEm'] . ")";
            $result = mysqli_query($conn, $select);
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  print("<option value='" . $row["project_name"] . "'>" . $row["project_name"] . "</option>");
               }
               print("</select>
                           <button type='updateSql' name='updateSql' value=" . $_POST['updateEm'] . ">Pakeisti</button>
                     </form>");
            }
         }
      }
      print("<footer>
                  <p id='footerText'> Copyright ©    <script>document.write(new Date().getFullYear())</script></p>
               </footer>");
      mysqli_close($conn);
   ?>
</body>

</html>