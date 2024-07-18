<?php
include 'templates/header.php';
include 'includes/db.php';
include 'includes/validate.php';

$name = $address = $phone = $annual_salary = $class_id = "";
$nameErr = $phoneErr = $salaryErr = $classErr = $addressErr = "";

$classes_without_teacher = $conn->query("
    SELECT class_id, class_name 
    FROM classes 
    WHERE class_id NOT IN (SELECT DISTINCT class_id FROM teachers WHERE class_id IS NOT NULL)
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate_input($_POST["name"]);
    $address = validate_input($_POST["address"]);
    $phone = validate_input($_POST["phone"]);
    $annual_salary = validate_input($_POST["annual_salary"]);
    $class_id = validate_input($_POST["class_id"]);
    $background_check = isset($_POST["background_check"]) ? 1 : 0;

    $valid = true;

    if (empty($name)) {
        $nameErr = "Name is required";
        $valid = false;
    }
    if (empty($address)) { 
        $addressErr = "Address is required";
        $valid = false;
    }


    if (!validate_phone($phone)) {
        $phoneErr = "Invalid phone format. Expected format: 123-456-7890";
        $valid = false;
    }

    if (!is_numeric($annual_salary)) {
        $salaryErr = "Invalid salary";
        $valid = false;
    }


    if ($valid) {
        $stmt = $conn->prepare("INSERT INTO teachers (name, address, phone, annual_salary, class_id, background_check) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdii", $name, $address, $phone, $annual_salary, $class_id, $background_check);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Teacher added successfully</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}
?>

<h2>Add New Teacher</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>">
        <span class="text-danger"><?php echo $nameErr;?></span>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>">
        <span class="text-danger"><?php echo $addressErr;?></span>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone;?>">
        <span class="text-danger"><?php echo $phoneErr;?></span>
    </div>
    <div class="mb-3">
        <label for="annual_salary" class="form-label">Annual Salary</label>
        <input type="text" class="form-control" id="annual_salary" name="annual_salary" value="<?php echo $annual_salary;?>">
        <span class="text-danger"><?php echo $salaryErr;?></span>
    </div>
    <div class="mb-3">
        <label for="class_id" class="form-label">Class</label>
        <select class="form-control" id="class_id" name="class_id">
            <option value="">Select Class</option>
            <?php while ($row = $classes_without_teacher->fetch_assoc()): ?>
                <option value="<?php echo $row['class_id']; ?>" <?php if ($row['class_id'] == $class_id) echo 'selected'; ?>><?php echo $row['class_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <span class="text-danger"><?php echo $classErr;?></span>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="background_check" name="background_check">
        <label class="form-check-label" for="background_check">Background Check</label>
    </div>
    <button type="submit" class="btn btn-primary">Add Teacher</button>
</form>

<?php include 'templates/footer.php'; ?>
