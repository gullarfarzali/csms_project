<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .table-container {
            width: 80%;
            margin: 0 auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .table-container th,
        .table-container td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table-container th {
            background-color: #f2f2f2;
        }

        .table-container tr:hover {
            background-color: #f5f5f5;
        }

        .table-container .status {
            max-width: 150px;
        }

        .table-container .comments {
            width: 100%;
        }

        .table-container .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
<script>
        $(document).ready(function() {
        $('.btn.btn-primary').click(function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            var selectedOption = $(this).closest('tr').find('.status').val();
            var device_id = $(this).closest('tr').find('.hidden-variable').val();
            var comments = $(this).closest('tr').find('.comments').val(); 

            $.ajax({
                url: 'edit_status.php',
                type: 'POST',
                data: { selectedValue: selectedOption, id: device_id, comments: comments},
                success: function(response) {
                // Reload the page
                location.reload();
        },
                error: function(xhr, status, error) {
                console.log(error);
                }
            });
        });
        });
    </script>
    <div class="container">
        <h1>All Devices</h1>
        <br>
        <div class="table-container">
            <form action="edit_status.php" method="POST">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                    require __DIR__ . 'database.php';

                    session_start();


                    // Retrieve employee ID based on the email from the session
                    $email = $_SESSION['email'];

                    $sql = "SELECT employee_id FROM employees WHERE email = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($emp_id);
                    $stmt->fetch();
                    $stmt->close();

                    $id = $emp_id;

                    // Retrieve devices and their associated services for the employee
                    $sql = "SELECT services.service_name, devices.device_name, devices.comments, devices.device_id, statuses.status_name
                            FROM devices
                            JOIN services ON devices.service_id = services.service_id
                            JOIN statuses ON devices.status_id = statuses.status_id
                            WHERE devices.employee_id = ?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    $sql = "SELECT status_name from statuses WHERE NOT status_id = 2 AND NOT status_id = 6";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute();
                    $result_statuses = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Display data of each row
                        while ($row = $result->fetch_assoc()) {?>
                                <tr>
                                    <td><?php echo $row['device_name'] ?></td>
                                    <td><?php echo $row['service_name'] ?></td>
                                    <td><?php echo $row['status_name'] ?></td>
                                    <td>
                                        <select name='status' class= 'status'>
                                        <?php 
                                            while ($row_options = $result_statuses->fetch_assoc()) {
                                                $statusName = $row_options['status_name'];
                                                ?>
                                                <option value="<?php echo $statusName; ?>"><?php echo $statusName; ?></option>
                                                <?php
                                            }
                                            $result_statuses->data_seek(0);
                                            ?>
                                        <input type="hidden" class="hidden-variable" value="<?php echo $row['device_id'] ?>">
                                    </td>
                                    <td><input type="text" name="comments" id="comments" class="comments" value="<?php echo $row['comments'] ?>"></td>
                                    <td>  
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </td>
                                </tr>
                            <?php  }  
                            } ?>  
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
