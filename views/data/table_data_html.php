<table class="data-table table <?php echo $table; ?>">
  <thead>
    <tr>
      <?php foreach (array_keys($results[0]) as $col): ?>
      <th><?php echo $col ?></th>	
      <?php endforeach; ?>
    </tr>
  </thead>
<tbody>
  <?php foreach ($results as $row): ?>
  <tr class="row">
    <?php foreach ($row as $key => $val): ?>
      <td class="cell <?php echo $key; ?>"><?php echo $val; ?></td>
    <?php endforeach; ?>
  </tr>
  <?php endforeach; ?>  
</tbody>
</table>