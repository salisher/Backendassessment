<?php
include 'templates/header.php';
include 'includes/db.php';
include 'includes/validate.php';

$name = $address = $medical_info = $class_id = $parent1_id = $parent2_id ="";
$nameErr = $classErr = "";

$classes = $conn->query("SELECT class_id, class_name FROM classes");

$parents = $conn->query("SELECT parent_id, name FROM parents");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate_input($_POST["name"]);
    $address = validate_input($_POST["address"]);
    $medical_info = validate_input($_POST["medical_info"]);
    $class_id = validate_input($_POST["class_id"]);
    $parent1_id = validate_input($_POST["parent1_id"]);
    $parent2_id = validate_input($_POST["parent2_id"]);

    $valid = true;

    if (empty($name)) {
        $nameErr = "Name is required";
        $valid = false;
    }

    if (empty($class_id)) {
        $classErr = "Class is required";
        $valid = false;
    }

    if ($valid) {
        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare("INSERT INTO pupils (name, address, medical_info, class_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $address, $medical_info, $class_id);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $pupil_id = $stmt->insert_id;
            $stmt->close();
            
            if (!empty($parent1_id)) {
                $stmt = $conn->prepare("INSERT INTO pupils_parents (pupil_id, parent_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $pupil_id, $parent1_id);
                if (!$stmt->execute()) {
                    throw new Exception($stmt->error);
                }
                $stmt->close();
            }

            if (!empty($parent2_id) && $parent2_id != $parent1_id) {
                $stmt = $conn->prepare("INSERT INTO pupils_parents (pupil_id, parent_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $pupil_id, $parent2_id);
                if (!$stmt->execute()) {
                    throw new Exception($stmt->error);
                }
                $stmt->close();
            }

            $conn->commit();
            echo "<div class='alert alert-success'>Pupil and parents added successfully</div>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<h2>Add New Pupil</h2>
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
        <label for="medical_info" class="form-label">Medical Info</label>
        <textarea class="form-control" id="medical_info" name="medical_info"><?php echo $medical_info;?></textarea>
    </div>
    <div class="mb-3">
        <label for="class_id" class="form-label">Class</label>
        <select class="form-control" id="class_id" name="class_id">
            <option value="">Select Class</option>
            <?php while ($row = $classes->fetch_assoc()): ?>
                <option value="<?php echo $row['class_id']; ?>" <?php if ($row['class_id'] == $class_id) echo 'selected'; ?>><?php echo $row['class_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <span class="text-danger"><?php echo $classErr;?></span>
    </div>
    <div class="mb-3">
        <label for="parent1_id" class="form-label">Select Parent 1</label>
        <select class="form-control" id="parent1_id" name="parent1_id">
            <option value="">Select Parent</option>
            <?php while ($row = $parents->fetch_assoc()): ?>
                <option value="<?php echo $row['parent_id']; ?>" <?php if ($row['parent_id'] == $parent1_id) echo 'selected'; ?>><?php echo $row['parent_id'] . " " . $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="parent2_id" class="form-label">Select Parent 2</label>
        <select class="form-control" id="parent2_id" name="parent2_id">
            <option value="">Select Parent</option>
            <?php
            $parents->data_seek(0);
            while ($row = $parents->fetch_assoc()): ?>
                <option value="<?php echo $row['parent_id']; ?>" <?php if ($row['parent_id'] == $parent2_id) echo 'selected'; ?>><?php echo $row['parent_id'] . " " . $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <a href="create_parent.php" class="btn btn-secondary mb-3">Add New Parent</a>
    <button type="submit" class="btn btn-primary mb-3">Add Pupil</button>
</form>

<?php include 'templates/footer.php'; ?>
