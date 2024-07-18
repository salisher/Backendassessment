<?php
include 'templates/header.php';
include 'includes/db.php';

$result = $conn->query("SELECT * FROM teachers");

if ($result->num_rows > 0) {
    echo "<h2>Teachers List</h2>";
    echo "<div class='accordion' id='teachersAccordion'>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='accordion-item'>";
        echo "<h2 class='accordion-header' id='teacherHeading{$row['teacher_id']}'>";
        echo "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#teacherCollapse{$row['teacher_id']}' aria-expanded='true' aria-controls='teacherCollapse{$row['teacher_id']}'>";
        echo "{$row['name']}</button></h2>";
        
        echo "<div id='teacherCollapse{$row['teacher_id']}' class='accordion-collapse collapse' aria-labelledby='teacherHeading{$row['teacher_id']}' data-bs-parent='#teachersAccordion'>";
        echo "<div class='accordion-body'>";
        
        echo "<p><strong>ID:</strong> {$row['teacher_id']}</p>";
        echo "<p><strong>Address:</strong> {$row['address']}</p>";
        echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
        echo "<p><strong>Annual Salary:</strong> {$row['annual_salary']}</p>";
        echo "<p><strong>Class ID:</strong> {$row['class_id']}</p>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>No teachers found</div>";
}

include 'templates/footer.php';
?>
