<?php
$file = 'data/valuations.json';
$all = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $finalValue = $_POST['final_value'];
    $all[$index]['final_value'] = $finalValue;
    $all[$index]['status'] = 'Approved by Admin';
    file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT));
    echo "<p>Valuation approved.</p><a href=''>Refresh</a>";
}
?>

<h2>Appraiser Review</h2>
<?php foreach ($all as $i => $item): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <strong><?= htmlspecialchars($item['asset']) ?></strong><br>
        Description: <?= nl2br(htmlspecialchars($item['description'])) ?><br>
        AI Estimate: ₹<?= number_format($item['ai_estimate']) ?><br>
        <img src="<?= $item['photo'] ?>" width="150"><br>
        Status: <?= $item['status'] ?><br><br>

        <?php if ($item['status'] === 'Awaiting Appraiser Review'): ?>
            <form method="POST">
                Final Appraised Value: <input type="number" name="final_value" required>
                <input type="hidden" name="index" value="<?= $i ?>">
                <input type="submit" value="Approve">
            </form>
        <?php elseif (isset($item['final_value'])): ?>
            Final Value: ₹<?= number_format($item['final_value']) ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
