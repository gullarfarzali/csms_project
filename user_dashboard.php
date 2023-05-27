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
    <link rel="stylesheet" href="user_dashboard.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="top">
        <div class="logo"><span></span></div>
        <i class="fa-solid fa-bars" id="btn"></i>
      </div>

      <ul>
        <li>
          <a href="" onclick="changePage('devices')">
            <i class="fa-solid fa-laptop-code"></i>
            <span class="nav-item">Devices</span>
          </a>
        </li>

        <li>
          <a href="" onclick="changePage('request')">
            <i class="fa-solid fa-code-pull-request"></i>
            <span class="nav-item">Request</span>
          </a>
        </li>

        <li>
          <a href="user_login.php">
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
        // Send a message in case it is needed
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

      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          document.getElementById("pageContent").innerHTML = xhr.responseText;
        }
      };

      // Change content of the page depending on the choice
      if (page === "devices") {
        xhr.open("GET", "devices.php", true);
        xhr.send();
      } else if (page === "request") {
        xhr.open("GET", "request.php", true);
        xhr.send();
      }
      }
  </script>
</html>
