<?php
include 'templates/header.php';
include 'includes/db.php';
include 'includes/validate.php';

$name = $address = $email = $phone = "";
$nameErr = $emailErr = $phoneErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate_input($_POST["name"]);
    $address = validate_input($_POST["address"]);
    $email = validate_input($_POST["email"]);
    $phone = validate_input($_POST["phone"]);

    $valid = true;

    if (empty($name)) {
        $nameErr = "Name is required";
        $valid = false;
    }

    if (!validate_email($email)) {
        $emailErr = "Invalid email format";
        $valid = false;
    }

    if (!validate_phone($phone)) {
        $phoneErr = "Invalid phone format. Expected format: 123-456-7890";
        $valid = false;
    }

    if ($valid) {
        $stmt = $conn->prepare("INSERT INTO parents (name, address, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $address, $email, $phone);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Parent added successfully</div>";
            header("Location: create_pupil.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}
?>

<h2>Add New Parent</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>">
        <span class="text-danger"><?php echo $nameErr;?></span>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email;?>">
        <span class="text-danger"><?php echo $emailErr;?></span>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone;?>">
        <span class="text-danger"><?php echo $phoneErr;?></span>
    </div>
    <button type="submit" class="btn btn-primary">Add Parent</button>
</form>

<?php include 'templates/footer.php'; ?>