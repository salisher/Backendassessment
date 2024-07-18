<?php
include 'templates/header.php';
include 'includes/db.php';

$result = $conn->query("SELECT * FROM parents");

if ($result->num_rows > 0) {
    echo "<h2>Parents List</h2>";
    echo "<div class='accordion' id='parentsAccordion'>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div class='accordion-item'>";
        echo "<h2 class='accordion-header' id='parentHeading{$row['parent_id']}'>";
        echo "<button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#parentCollapse{$row['parent_id']}' aria-expanded='true' aria-controls='parentCollapse{$row['parent_id']}'>";
        echo "{$row['name']}</button></h2>";
        
        echo "<div id='parentCollapse{$row['parent_id']}' class='accordion-collapse collapse' aria-labelledby='parentHeading{$row['parent_id']}' data-bs-parent='#parentsAccordion'>";
        echo "<div class='accordion-body'>";
        
        $pupils_result = $conn->query("SELECT * FROM pupils_parents pp JOIN pupils p ON pp.pupil_id = p.pupil_id WHERE pp.parent_id = {$row['parent_id']}");
        
        if ($pupils_result->num_rows > 0) {
            echo "<h4>Pupils:</h4>";
            echo "<ul>";
            while ($pupil_row = $pupils_result->fetch_assoc()) {
                echo "<li>{$pupil_row['name']} (ID: {$pupil_row['pupil_id']})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No pupils found for this parent.</p>";
        }
        
        echo "<p><strong>Address:</strong> {$row['address']}</p>";
        echo "<p><strong>Email:</strong> {$row['email']}</p>";
        echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    
    echo "</div>";
} else {
    echo "<div class='alert alert-info'>No parents found</div>";
}

include 'templates/footer.php';
?>
