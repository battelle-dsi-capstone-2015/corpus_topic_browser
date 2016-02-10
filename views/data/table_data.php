<?php $colkey = array(); foreach ($field_info as $f) { $colkey[$f->name] = $f->primary_key; } ?>
<h1><?php echo $page_title; ?></h1>
<p>
<a type="button" class="btn btn-default" href="<?php echo base_url('data/view/'); ?>">All tables</a><br/>
</p>
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
  <tr>
    <?php foreach ($row as $col => $val): ?>
    <td valign="top" class="<?php echo $col;?>">
      <?php if($colkey[$col]): ?>
      <a href="<?php echo base_url('data/view/'.$table.'/html/'.$col.'/'.urlencode($val)); ?>"><?php echo $val; ?></a>
      <?php else: ?>
      <?php echo $val; ?>
      <?php endif; ?>
    </td>
    <?php endforeach; ?>
  </tr>  
<?php endforeach; ?>
</tbody>
</table>