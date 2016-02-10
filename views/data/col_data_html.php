<div class="<?php echo $table; ?>">
  <?php foreach ($rows as $row): ?>
  <div class="record">
    <?php foreach ($row as $key => $val): ?>
      <?php if($val): ?>
      <div class="field <?php echo $key; ?>">
        <div class="field-label" style="display:none;"><?php echo $key; ?></div>
        <div class="field-value"><?php echo $val; ?></div>
      </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>  
  <?php endforeach; ?>
</div>