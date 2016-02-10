<h1><?php echo $page_title; ?></h1>
<table class="table">
<?php foreach($tables as $table): ?>
  <tr>
    <td><?php echo $table; ?></td>
    <td><a href="<?php echo base_url('data/view/'.$table); ?>">HTML (View)</a></td>
    <td><a href="<?php echo base_url('data/view/'.$table) .'/text'; ?>">CSV</a></td>
    <td><a href="<?php echo base_url('data/view/'.$table) .'/json'; ?>">JSON</a></td>
    <td><a href="<?php echo base_url('data/view/'.$table) .'/html'; ?>">HTML (Embed)</a></td>
  </tr>
<?php endforeach; ?>
</table>