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
        color: #0b2b53;
      }

      .action {
        display: flex;
        justify-content: space-around;
      }

      .action a:nth-child(1) {
        padding-left: 150px;
      }

      .action a:nth-child(2) {
        padding-right: 150px;
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
        background-color: #0b2b53;
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
        background-color: #0b2b53;
        color: white;
      }
    </style>
    
  </head>
  <body>
    <table class="content-table">
      <thead>
        <tr>
          <th>Device Name</th>
          <th>Service</th>
          <th>Status</th>
          <th>Total</th>
        
        </tr>
      </thead>
      <tbody class="scrollable-table">
      <?php
            session_start();
            
            require __DIR__ . "\\..\\database.php";

            if (isset($_SESSION['user_id'])) {
              $user_id = $_SESSION['user_id'];
              // Use the user ID as needed
            } else {
              // User is not logged in or session expired
              echo "User is not logged in.";
            }
            
            // Read all rows from database table
            $sql = "SELECT orders.user_id, orders.total, devices.device_name, services.service_name, statuses.status_name
                    FROM orders
                    JOIN devices ON orders.device_id = devices.device_id
                    JOIN statuses ON devices.status_id = statuses.status_id
                    JOIN services ON devices.service_id = services.service_id
                    WHERE orders.user_id = ?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Retrieve the results
            $result = $stmt->get_result();

            // Check if query is executed properly
            if(! $result) {
                die("Invalid query: " . $mysqli->error($conn));
            }

            // Read data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . $row["device_name"] ."</td>
                <td>" . $row["service_name"] ."</td>
                <td>" . $row["status_name"] ."</td>
                <td>" . $row["total"] . " $" . "</td>
            </tr>";
            }
            ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"></td>
        </tr>
      </tfoot>
    </table>
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
    </script>
</html>