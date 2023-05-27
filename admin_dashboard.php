<?php
session_start();

require_once "admin_auth_check.php";

require __DIR__ . "\\..\\database.php";

// Query to fetch the total number of users
$sql1 = "SELECT COUNT(*) AS total_users FROM users";
$result1 = $mysqli->query($sql1);
if ($result1) {
    // Fetch the result as an associative array
    $row = $result1->fetch_assoc();

    // Retrieve the user count
    $userCount = $row['total_users'];
} else {
    die("Failed: " . $mysqli->error);
}

// Query to fetch the total number of employees
$sql2 = "SELECT COUNT(*) AS total_emp FROM employees";
$result2 = $mysqli->query($sql2);
if ($result2) {
    // Fetch the result as an associative array
    $row = $result2->fetch_assoc();

    // Retrieve the employee count
    $empCount = $row['total_emp'];
} else {
    die("Failed: " . $mysqli->error);
}

// Query to fetch the total sum of earnings
$sql3 = "SELECT SUM(total) AS total_sum FROM orders";
$result3 = $mysqli->query($sql3);
if ($result3) {
    // Fetch the result as an associative array
    $row = $result3->fetch_assoc();

    // Retrieve the total sum of earnings
    $totalSum = $row['total_sum'];
} else {
    die("Failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <script
      src="https://kit.fontawesome.com/86b5c3aa15.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="admin_dashboard.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="top">
        <div class="logo"><span></span></div>
        <i class="fa-solid fa-bars" id="btn"></i>
      </div>
      <ul>
        <li>
          <a href="" onclick="changePage('dashboard')">
            <i class="fa-brands fa-hashnode"></i>
            <span class="nav-item">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="" onclick="changePage('users')">
            <i class="fa-solid fa-user"></i>
            <span class="nav-item">Users</span>
          </a>
        </li>

        <li>
          <a href="" onclick="changePage('employees')">
            <i class="fa-solid fa-briefcase"></i>
            <span class="nav-item">Employees</span>
          </a>
        </li>

        <li>
          <a href="" onclick="changePage('services')">
            <i class="fa-solid fa-bell-concierge"></i>
            <span class="nav-item">Services</span>
          </a>
        </li>

        <li>
          <a href="admin_login.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="nav-item">Logout</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="main-content" id="pageContent">
    <div class="default-container">
        <div class="default-box">
          <h1>Welcome to the Admin Panel!</h1>
          <p>Please select your preferred option from the sidebar.</p>
        </div>
    </div>
    <?php
      if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        ' . $msg . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
    ?>
    </div>
  </body>

  <script>
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");

    btn.onclick = function () {
      sidebar.classList.toggle("active");
    };

    function changePage(page) {
      event.preventDefault();

      // Fetch the corresponding page content based on the selected link
      var pageContent;

      if (page === "dashboard") {
        pageContent = `
        <html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing:border-box;
        }
        
        .cards {
            height: 100%;
            display: flex;
            justify-content:center;
            align-items: space-around;
        }
        
        .cards .card{
            margin: 40px 0;
            width:70%;
            padding: 20px;
            display: flex;
            justify-content:space-between;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.08);
        }

        .number{
            font-size: 35px;
            font-weight: 500;
            color: #299B63;
        }

        .card-name{
            color: #888;
            font-weight: 600;
        }

        .icon-box i{
            font-size: 45px;
            color: #299B63;
        } 
        
    </style>
       
</head>
<body>
  <div class="cards">
      <div class="card">
        <div class="card-content">
          <div class="number"><?php echo $userCount ?></div>
          <div class="card-name">Users</div>
        </div>
        <div class="icon-box">
          <i class="fa-regular fa-user"></i>
        </div>
      </div>
    </div>

    <div class="cards">
      <div class="card">
        <div class="card-content">
          <div class="number"><?php echo $empCount ?></div>
          <div class="card-name">Employees</div>
        </div>
        <div class="icon-box">
          <i class="fa-regular fa-building"></i>
        </div>
      </div>
    </div>

    <div class="cards">
        <div class="card">
          <div class="card-content">
            <div class="number"><?php echo $totalSum . " $"?></div>
            <div class="card-name">Earnings</div>
          </div>
          <div class="icon-box">
            <i class="fa-solid fa-money-bill-trend-up"></i>
          </div>
        </div>
      </div>
</body>
</html>
        `;
      } else if (page === "users") {
        pageContent = `
<html>
  <head>
    <title>Dynamic Table Example</title>
    <style>
      * {
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
      }


      table {
        width: 100%;
      }

      .content-table {
        border-radius: 8px 8px 8px 8px;
        overflow: hidden;
        box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.08);
      }

      tbody {
        display: block;
        height: 300px;
        overflow-y: auto;
      }

      tbody::-webkit-scrollbar {
        width: 8px;
      }

      tbody::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 4px;
      }

      tbody::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.7);
      }

      tbody::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.1);
      }

      tbody::-webkit-scrollbar-track:hover {
        background-color: rgba(0, 0, 0, 0.2);
      }

      tbody::-webkit-scrollbar-corner {
        background-color: transparent;
      }

      thead,
      tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        text-align: center;
      }

      .content-table tbody td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }

      .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
      }

      .content-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
        color: #1b8b1b;
      }

      .action {
        display: flex;
        justify-content: space-around;
      }

      .action a:nth-child(1) {
        padding-left: 40px;
      }

      .action a:nth-child(2) {
        padding-right: 40px;
      }
      .action i {
        color: black;
      }

      .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9rem;
        min-width: 400px;
      }

      .content-table thead tr {
        background-color: #1b8b1b;
        color: white;
      }

      /* Added CSS for moving data to the right */
      .scrollable-table.has-scrollbar tr td:nth-child(4),
      .scrollable-table.has-scrollbar tr td:nth-child(5),
      .scrollable-table.has-scrollbar tr td:nth-child(6),
      .scrollable-table.has-scrollbar tr td:nth-child(7) {
        padding-left: 13px;
      }

      .content-table th,
      .content-table td {
        padding-top: 12px;
        padding-bottom: 12px;
      }

      tfoot {
        width: 100%;
        background-color: #1b8b1b;
        color: white;
      }

      .btn {
        display: flex;
        justify-content: center;
      }

      button {
        border: 1px solid #1b8b1b;
        border-radius: 5px;
        background: #fff;
        color: #04140e;
        padding: 12px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 30px;
      }

      button:hover {
        background-color: #efefef;
        transition: all ease 0.5s;
      }

      button a {
        text-decoration: none;
        color: #1b8b1b;
      }
    </style>
    
  </head>
  <body>
    <table class="content-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Date of Birth</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="scrollable-table">
        <?php
            require __DIR__ . "\\..\\database.php";

            require_once "admin_auth_check.php";
      

            $sql4 = "SELECT * FROM users";

            $result4 = $mysqli->query($sql4);

            if($result4->num_rows > 0){

            while($row = $result4->fetch_assoc()){
                
                $_SESSION['user_id'] = $row['user_id'];
                echo "<tr>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["password_hash"] . "</td>";
                echo "<td>" . $row["date_of_birth"] . "</td>";
                echo "<td class='action'><a href='edit_user.php?id=" . $row["user_id"] . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>";
                echo "<a href='delete_user.php'id=" . $row["user_id"] . "' class='link-dark'><i class='fa-solid fa-trash fs-5'></i></a></td>";
                echo "</tr>";
            }
            } else {
                echo "<tr><td colspan='7'>No data available.</td></tr>";
            }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="7"></td>
        </tr>
      </tfoot>
    </table>

    <div class="btn">
      <button>
        <a href="add_new_user.php">Add New User</a>
      </button>
    </div>
  </body>
    <script>
      function hasVerticalScrollbar(element) {
        return element.scrollHeight > element.clientHeight;
      }

      const tbody = document.querySelector(".scrollable-table");

      if (hasVerticalScrollbar(tbody)) {
        tbody.classList.add("has-scrollbar");
      } else {
        tbody.classList.remove("has-scrollbar");
      }
</html>`;
      } else if (page === "employees") {
        pageContent = `
        <html>
  <head>
    <title>Dynamic Table Example</title>
    <style>
      * {
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
      }
      table {
        width: 100%;
      }

      .content-table {
        border-radius: 8px 8px 8px 8px;
        overflow: hidden;
        box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.08);
      }

      tbody {
        display: block;
        height: 300px;
        overflow-y: auto;
      }

      tbody::-webkit-scrollbar {
        width: 8px;
      }

      tbody::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 4px;
      }

      tbody::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.7);
      }

      tbody::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.1);
      }

      tbody::-webkit-scrollbar-track:hover {
        background-color: rgba(0, 0, 0, 0.2);
      }

      tbody::-webkit-scrollbar-corner {
        background-color: transparent;
      }

      thead,
      tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        text-align: center;
      }

      .content-table tbody td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }

      .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
      }

      .content-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
        color: #1b8b1b;
      }

      .action {
        display: flex;
        justify-content: space-around;
      }

      .action a:nth-child(1) {
        padding-left: 40px;
      }

      .action a:nth-child(2) {
        padding-right: 40px;
      }
      .action i {
        color: black;
      }

      .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9rem;
        min-width: 400px;
      }

      .content-table thead tr {
        background-color: #1b8b1b;
        color: white;
      }

      /* Added CSS for moving data to the right */
      .scrollable-table.has-scrollbar tr td:nth-child(4),
      .scrollable-table.has-scrollbar tr td:nth-child(5),
      .scrollable-table.has-scrollbar tr td:nth-child(6),
      .scrollable-table.has-scrollbar tr td:nth-child(7) {
        padding-left: 13px;
      }

      .content-table th,
      .content-table td {
        padding-top: 12px;
        padding-bottom: 12px;
      }

      tfoot {
        width: 100%;
        background-color: #1b8b1b;
        color: white;
      }

      .btn {
        display: flex;
        justify-content: center;
      }

      button {
        border: 1px solid #1b8b1b;
        border-radius: 5px;
        background: #fff;
        color: #04140e;
        padding: 12px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 30px;
      }

      button:hover {
        background-color: #efefef;
        transition: all ease 0.5s;
      }

      button a {
        text-decoration: none;
        color: #1b8b1b;
      }
    </style>
  </head>
  <body>
    <table class="content-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>Date of Birth</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="scrollable-table">
        <?php

            $sql5 = "SELECT * FROM employees";

            $result5 = $mysqli->query($sql5);

            if($result5->num_rows > 0){

            while($row = $result5->fetch_assoc()){
                
                $_SESSION['employee_id'] = $row['employee_id'];
                echo "<tr>";
                echo "<td>" . $row["employee_id"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["password_hash"] . "</td>";
                echo "<td>" . $row["date_of_birth"] . "</td>";
                echo "<td class='action'><a href='edit_employee.php?id=" . $row["employee_id"] . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>";
                echo "<a href='delete_employee.php'id=" . $row["employee_id"] . "' class='link-dark'><i class='fa-solid fa-trash fs-5'></i></a></td>";
                echo "</tr>";
            }
            } else {
                echo "<tr><td colspan='7'>No data available.</td></tr>";
            }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="7"></td>
        </tr>
      </tfoot>
    </table>

    <div class="btn">
      <button>
        <a href="add_new_employee.php">Add New Employee</a>
      </button>
    </div>
  </body>
    
</html>
        `;
      } else if (page === "services") {
        pageContent = `
        <html>
  <head>
    <title>Dynamic Table Example</title>
    <style>
      * {
        box-sizing: border-box;
        font-family: "Open Sans", sans-serif;
      }


      table {
        width: 100%;
      }

      .content-table {
        border-radius: 8px 8px 8px 8px;
        overflow: hidden;
        box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.08);
      }

      tbody {
        display: block;
        height: 300px;
        overflow-y: auto;
      }

      tbody::-webkit-scrollbar {
        width: 8px;
      }

      tbody::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 4px;
      }

      tbody::-webkit-scrollbar-thumb:hover {
        background-color: rgba(0, 0, 0, 0.7);
      }

      tbody::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.1);
      }

      tbody::-webkit-scrollbar-track:hover {
        background-color: rgba(0, 0, 0, 0.2);
      }

      tbody::-webkit-scrollbar-corner {
        background-color: transparent;
      }

      thead,
      tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        text-align: center;
      }

      .content-table tbody td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }

      .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
      }

      .content-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
        color: #1b8b1b;
      }

      .action {
        display: flex;
        justify-content: space-around;
      }

      .action a:nth-child(1) {
        padding-left: 100px;
      }

      .action a:nth-child(2) {
        padding-right: 100px;
      }
      .action i {
        color: black;
      }

      .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9rem;
        min-width: 400px;
      }

      .content-table thead tr {
        background-color: #1b8b1b;
        color: white;
      }

      /* Added CSS for moving data to the right */
      
      .scrollable-table.has-scrollbar tr td:nth-child(3),
      .scrollable-table.has-scrollbar tr td:nth-child(4){
        padding-left: 60px;
      }

      .content-table th,
      .content-table td {
        padding-top: 12px;
        padding-bottom: 12px;
      }

      tfoot {
        width: 100%;
        background-color: #1b8b1b;
        color: white;
      }

      .btn {
        display: flex;
        justify-content: center;
      }

      button {
        border: 1px solid #1b8b1b;
        border-radius: 5px;
        background: #fff;
        color: #04140e;
        padding: 12px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 30px;
      }

      button:hover {
        background-color: #efefef;
        transition: all ease 0.5s;
      }

      button a {
        text-decoration: none;
        color: #1b8b1b;
      }
    </style>
    
  </head>
  <body>
    <table class="content-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Service</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="scrollable-table">
          <?php

            $sql6 = "SELECT * FROM services";

            $result6 = $mysqli->query($sql6);

            if($result6->num_rows > 0){

            while($row = $result6->fetch_assoc()){
                
                $_SESSION['service_id'] = $row['service_id'];

                echo "<tr>";
                echo "<td>" . $row["service_id"] . "</td>";
                echo "<td>" . $row["service_name"] . "</td>";
                echo "<td>" . $row["total"] . "</td>";
                echo "<td class='action'><a href='edit_service.php?id=" . $row["service_id"] . "' class='link-dark'><i class='fa-solid fa-pen-to-square fs-5 me-3'></i></a>";
                echo "<a href='delete_service.php'id=" . $row["service_id"] . "' class='link-dark'><i class='fa-solid fa-trash fs-5'></i></a></td>";
                echo "</tr>";
            }
            } else {
                echo "<tr><td colspan='4'>No data available.</td></tr>";
            }
          ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"></td>
        </tr>
      </tfoot>
    </table>

    <div class="btn">
      <button>
        <a href="add_new_service.php">Add New Service</a>
      </button>
    </div>
  </body>
    <script>
      function hasVerticalScrollbar(element) {
        return element.scrollHeight > element.clientHeight;
      }

      const tbody = document.querySelector(".scrollable-table");

      if (hasVerticalScrollbar(tbody)) {
        tbody.classList.add("has-scrollbar");
      } else {
        tbody.classList.remove("has-scrollbar");
      }
</html>
        `;
      }

      // Update the page content based on the selected link
      var pageContainer = document.getElementById("pageContent");
      pageContainer.innerHTML = pageContent;
    }
  </script>
</html>
