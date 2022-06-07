<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="./style.css">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
</head>

</body>
</html>
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
   print('<div class="navbar">
<div>
<a href="?path=darbuotojai">Darbuotojai</a>
<a href="?path=masinos">Mašinos</a>
</div>
<p>Įmonės X mašinų valdymas</p>
</div>');
   $sql = "SELECT personnel.id, fname, lname, machine_name FROM personnel LEFT JOIN Machines ON Personnel.Machine_id = Machines.id";
   $result = mysqli_query($conn, $sql);
   if (isset($_GET['path']) and $_GET['path'] === 'darbuotojai') {

      print("<table>
         <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Machine</th>
         </tr>");
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            print('<tr> <td>' . $row["id"] . '</td> <td>' . $row["fname"] . '</td> <td>' . $row["lname"] . '</td><td > ' . $row["machine_name"] . '</td></tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
   }

   $sql2 =  "SELECT Machines.id, machine_name,fname, lname FROM machines RIGHT JOIN Personnel ON Machines.id=Personnel.Machine_id WHERE Machines.id=Personnel.Machine_id ";
   $result2 = mysqli_query($conn, $sql2);
   if (isset($_GET['path']) and $_GET['path'] === 'masinos') {
      print("<table >
         <tr>
            <th >ID</th>
            <th>Machine</th>
            <th>First Name</th>
            <th>Last Name</th>
         </tr>");
      if (mysqli_num_rows($result2) > 0) {
         while ($row = mysqli_fetch_assoc($result2)) {
            print('<tr> <td ">' . $row["id"] . '</td> <td>' . $row["machine_name"] . '</td> <td>' . $row["fname"] . '</td><td> ' . $row["lname"] . '</td></tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
   } else if (!isset($_GET['path'])){
      
      print("<table>
         <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Machine</th>
         </tr>");
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            print('<tr> <td>' . $row["id"] . '</td> <td>' . $row["fname"] . '</td> <td>' . $row["lname"] . '</td><td > ' . $row["machine_name"] . '</td></tr>');
         }
      } else {
         echo "0 results";
      }
      print("</table>");
   }
   print("<footer>
         <p>Copyright</p>
      </footer>");
   mysqli_close($conn);

   ?>
</body>
</html>