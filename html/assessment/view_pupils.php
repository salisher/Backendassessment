<?php
include 'templates/header.php';
include 'includes/db.php';

$result = $conn->query("SELECT * FROM pupils");

if ($result->num_rows > 0) {
    echo "<h2>Pupils List</h2>";
    echo "<div class='accordion' id='pupilsAccordion'>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='accordion-item'>";
        echo "<h2 class='accordion-header' id='pupilHeading{$row['pupil_id']}'>";
        echo "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#pupilCollapse{$row['pupil_id']}' aria-expanded='true' aria-controls='pupilCollapse{$row['pupil_id']}'>";
        echo "{$row['name']}</button></h2>";
        
        echo "<div id='pupilCollapse{$row['pupil_id']}' class='accordion-collapse collapse' aria-labelledby='pupilHeading{$row['pupil_id']}' data-bs-parent='#pupilsAccordion'>";
        echo "<div class='accordion-body'>";
        
        echo "<p><strong>ID:</strong> {$row['pupil_id']}</p>";
        echo "<p><strong>Address:</strong> {$row['address']}</p>";
        echo "<p><strong>Medical Info:</strong> {$row['medical_info']}</p>";
        echo "<p><strong>Class ID:</strong> {$row['class_id']}</p>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>No pupils found</div>";
}

include 'templates/footer.php';
?>
