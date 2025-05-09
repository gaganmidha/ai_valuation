<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assetName = $_POST['asset_name'];
    $description = $_POST['description'];

    // Upload files
    $uploadDir = 'uploads/';
    $photoPath = $uploadDir . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);

    $certPath = '';
    if (!empty($_FILES['certificate']['name'])) {
        $certPath = $uploadDir . basename($_FILES['certificate']['name']);
        move_uploaded_file($_FILES['certificate']['tmp_name'], $certPath);
    }

    // Simulated AI valuation
    $aiEstimate = rand(5000, 50000); // Random value for demo

    // Save data
    $data = [
        'asset' => $assetName,
        'description' => $description,
        'photo' => $photoPath,
        'certificate' => $certPath,
        'ai_estimate' => $aiEstimate,
        'status' => 'Awaiting Appraiser Review'
    ];

    $all = [];
    $file = 'data/valuations.json';
    if (file_exists($file)) {
        $all = json_decode(file_get_contents($file), true);
    }
    $all[] = $data;
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));

    echo "<h3>AI Estimated Value: ₹" . number_format($aiEstimate) . "</h3>";
    echo "<p>Forwarded to Appraiser for validation...</p>";
    echo '<a href="appraiser_validation.php">Go to Appraiser Validation</a>';
}
?>
