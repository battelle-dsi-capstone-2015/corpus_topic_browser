<style type="text/css">
  .dba { background-color:#ffffdd; }
</style>
<h1><?php echo $page_title; ?></h1>
<a type="button" class="btn btn-default" href="<?php echo base_url(''); ?>">Home</a><br/>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Database</th>
    </tr>
  </thead>
  <tbody>
  <?php ksort($users); foreach($users as $userid => $name): ?>
    <?php 
    	$db = $course .'_'. $userid; 
    	$site_url = site_url('/data/view'); 
    ?>
    <tr class="<?php in_array($userid, $db_people) ? print 'dba' : print 'foo' ; ?>">
      <td><?php echo $userid; ?></td>   
      <td><?php echo $name; ?></td>   
      <td><a href="<?php echo base_url('/data/view/'.$userid); ?>"><?php echo $db; ?></a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>