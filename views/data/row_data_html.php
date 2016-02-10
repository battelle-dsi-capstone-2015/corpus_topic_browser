<div class="record <?php echo $table; ?>"><?php foreach ($row as $key => $val): ?><?php if($val): ?>
  
  <div class="field <?php echo $key; ?>">
    <div class="field-label"><?php echo $key; ?></div>
    <div class="field-value"><?php echo $val; ?></div>
  </div><?php endif; ?><?php endforeach; ?>

</div>