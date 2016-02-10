<?php print implode('|', array_keys($results[0])) . "\n"; ?>
<?php foreach ($results as $row): ?>
<?php print implode('|', $row) . "\n"; ?>
<?php endforeach; ?>