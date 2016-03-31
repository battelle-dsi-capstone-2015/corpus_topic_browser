<!DOCTYPE html>
<html lang="en">
  <head>
  	
    <title>
    	<?php echo $this->config->item('site_slug'); ?> | <?php echo $page_title ?>
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url('assets/favicon.ico'); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/favicon.ico'); ?>" type="image/x-icon">

	<!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0-rc.1/jquery-ui.min.js"></script>
    
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <!-- Datatables -->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
    <script src="http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    
    <!-- Vis -->
    <link rel="stylesheet" href="<?php print base_url('assets/js/vis/vis.css'); ?>">
    <script src="<?php print base_url('assets/js/vis/vis.min.js'); ?>"></script>

    <!-- Chart JS -->
    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
    -->
    <!-- Chartist -->
    <!--
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    -->
    <!-- D3 -->
    <!--
    <script src="http://d3js.org/d3.v3.min.js"></script>
    -->
    
    <!--
    <script src="http://dimplejs.org/dist/dimple.v2.1.6.min.js"></script>
    -->
    
    <!-- LOCAL -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/default.css'); ?>">
    
  </head>
  <body>
  	<!--
    <div id="site-header">
      <div id="site-title"><a href="<?php echo base_url() ?>"><?php echo $this->config->item('site_title') ?></a></div>
    </div>
   -->
    <nav class="navbar navbar-default">
	  <div class="container-fluid">
	  	
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#"><b></b></a>
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	<li><a href='/battelle'>Home</a></li>
	        <li><a href="<?php echo base_url('topic/all'); ?>">Topics<span class="sr-only">(current)</span></a></li>
	        <li><a href="<?php echo base_url('doc/all'); ?>">Documents<span class="sr-only">(current)</span></a></li>
	        <li><a href="<?php echo base_url('word/all'); ?>">Words<span class="sr-only">(current)</span></a></li>
	        <li><a href="<?php echo base_url('data'); ?>">API</a></li>
	        <li><a href="/phpliteadmin.php" target="_blank">DB Browser</a></li>
	        <!--
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	        -->
	      </ul>
	      
	      <!--
	      <form class="navbar-form navbar-left" role="search">
	        <div class="form-group">
	          <input type="text" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	      </form>
	      -->
	      
	      <!--
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="#">Link</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li>
	      </ul>
	      -->
	      
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
    <div id="site-content">
      <?php if (isset($site_message)): ?>
      <b>Site Message</b>: <div id="site-message"><?php echo $site_message; ?></div>    
      <?php endif; ?>
