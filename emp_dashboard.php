<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
    <script
      src="https://kit.fontawesome.com/86b5c3aa15.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="employee_dashboard.css" />
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
          <a href="" onclick="changePage('tasks')">
            <i class="fa-solid fa-list-check"></i>
            <span class="nav-item">Tasks</span>
          </a>
        </li>

        <li>
          <a href="emp_login.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="nav-item">Logout</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="main-content" id="pageContent">
      <div class="default-container">
        <div class="default-box">
          <h1>Welcome to the Employee Panel!</h1>
          <p>Please select your preferred option from the sidebar.</p>
        </div>
      </div>
    </div>  
  </body>
  <script>
    function removeRow(rowId, deviceId) {
        // Remove the HTML row
        var row = document.getElementById(rowId);
        row.parentNode.removeChild(row);
        // Call the PHP script to update the database
        $.ajax({
          type: 'POST',
          url: 'reject_status.php',
          data: { device_id: deviceId },
          success: function(response) {
            // Request successful, remove the row
            var row = document.getElementById(rowId);
            if (row) {
              row.remove();
            }
          },
          error: function(xhr, status, error) {
            // Request failed, handle the error
            console.error(error);
          }
        });
      }

      function acceptRow(rowId, deviceId) {
        // Remove the HTML row
        var row = document.getElementById(rowId);
        row.parentNode.removeChild(row);
        // Call the PHP script to update the database
        $.ajax({
          type: 'POST',
          url: 'accept_status.php',
          data: { device_id: deviceId },
          success: function(response) {
            // Request successful, remove the row
            var row = document.getElementById(rowId);
            if (row) {
              row.remove();
            }
          },
          error: function(xhr, status, error) {
            // Request failed, handle the error
            console.error(error);
          }
        });
      }
    
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

      if (page === "devices") {
        xhr.open("GET", "devices.php", true);
        xhr.send();
      } else if (page === "tasks") {
        xhr.open("GET", "manage_statuses.php", true);
        xhr.send();
      }

      // Update the page content based on the selected link
      var pageContainer = document.getElementById("pageContent");
      pageContainer.appendChild = pageContent;
    }
  </script>
</html>
