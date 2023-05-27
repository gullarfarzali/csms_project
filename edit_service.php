<?php

session_start();

require_once "admin_auth_check.php";

require __DIR__ . "\\..\\database.php";

$id = $_GET["id"];

if (isset($_POST["submit"])) {
    $service_name = $_POST['service_name'];
    $total = $_POST['total'];

    $stmt = $mysqli->stmt_init();

    $sql = "UPDATE services SET `service_name`=?, total=? WHERE service_id = ?";
    $stmt->prepare($sql);
    $stmt->bind_param("sdd",$service_name,$total,$id);

    if ($stmt->execute()) {
    header("Location: admin_dashboard.php?msg=Data updated successfully");
    } else {
    echo "Failed: " . $mysqli->error;
    }
    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin crud</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="edit_service_s.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="navbar navbar-light text-white bg-primary justify-content-center fs-3 mb-5 py-3"
    >
      <h2>Edit Services</h2>
    </nav>

    <?php

      $id = $_GET["id"];

      $sql = "SELECT * FROM services WHERE service_id = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("i",$id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $mysqli->close();
    ?>

    <!-- Edit service form -->
    <div class="container">
      <div class="register">
        <h2 class="updateService">Update <span>Service</span></h2>
        <div class="registerform-main">
          <form action="edit_service.php?id=<?php echo $row['service_id']; ?>" method="POST">
            <div class="inputbox">
              <i class="fa-solid fa-briefcase"></i>
              <input
                type="text"
                name="service_name"
                class="box"
                value="<?php echo $row['service_name'] ?>"
                required
              />
            </div>
            <div class="inputbox">
              <i class="fa-solid fa-money-bill"></i>
              <input
                type="text"
                name="total"
                class="box"
                value="<?php echo $row['total'] ?>"
                required
              />
            </div>
            <button type="submit" class="btn btn-success" name="submit">
              Update
            </button>
          </form>
        </div>
        <div class="extras">
          <a href="admin_dashboard.php" class="back">Cancel</a>
        </div>
      </div>
    </div>
  </body>
</html>
