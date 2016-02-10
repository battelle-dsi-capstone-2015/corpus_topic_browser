<?php
  foreach($rows as $row) {
    print implode('|', array_values($row)) . "\n";
  }
?>
