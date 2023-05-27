<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5">Manage Services</nav>

    <div class="container">
      <?php 
      session_start();
      
      require_once "admin_auth_check.php";
      
      if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        ' . $msg . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      ?>
      <table class="table table-hover text-center">
        <thead class="table-dark">
        <th scope="col">ID</th>
          <th scope="col">Service</th>
          <th scope="col">Total</th>
          <th scope="col">Action</th>
        </thead>
        <tbody>
          <?php
            require __DIR__ . "database.php";
              $sql = "SELECT * FROM services";

              $result = $mysqli->query($sql);

              while($row = $result->fetch_assoc()){
                
                $_SESSION['service_id'] = $row['service_id'];
          ?>
          <tr>
            <td><?php echo $row["service_id"]; ?></td>
            <td><?php echo $row["service_name"]; ?></td>
            <td><?php echo $row["total"]; ?></td>
            <td><a href="edit_service.php?id=<?php echo $row["service_id"] ?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                <a href="delete_service.php?id=<?php echo $row["service_id"] ?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a></td>
          </tr>
          <?php }?>
        </tbody>
    </table>
    <a href="add_new_service.php" class="btn btn-dark mb-3">Add New</a> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
