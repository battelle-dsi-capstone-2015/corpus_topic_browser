</div>
<div id="site-footer">
	<p>
		<strong>&copy; 2016 SHANTI, DSI, UVA</strong>
		| Page rendered in <strong>{elapsed_time}</strong> seconds 
		| <?php echo  (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
		<hr/>
		<div style="margin:0 auto;width:auto;">
		<span class="glyphicon glyphicon-star" aria-hidden="true"></span> O N T O L I G E N T&nbsp;&nbsp;&nbsp;D E S I G N <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
		</div>
		<!-- | <a href="/user_guide/">CI User Guide</a> -->
	</p>
	<?php if (isset($status_message)): ?> 
	<p><?php print $status_message;?></p>
	<?php endif; ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.data-table').DataTable();
});
</script>
</body>
</html>