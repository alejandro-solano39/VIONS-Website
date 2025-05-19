<?php
include('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $source = $_POST['source']; 
    $link = $_POST['link'];

    $sql = "INSERT INTO source_links (source, link) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$source, $link])) {
        echo "Link saved successfully.";
    } else {
        echo "There was an error saving the link.";
    }
}
?>
