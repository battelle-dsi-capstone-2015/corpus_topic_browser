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
	
	var table = $('.data-table').DataTable();
 	table.column( '0:visible' ).order( 'desc' ).draw();
 	
 	/* BEGIN AUTOCOMPLETE */
 	$(function() {
 		
  		function split(val) {
        	return val.split(/,\s*/);
        }
        function extractLast(term) {
        	return split(term).pop();
        }
        
        $('#search-type').on('change',function(){
        	$('#search-string').val('');
        })

        $("#search-string").on( "keydown", function(event) {
        	if (event.keyCode === $.ui.keyCode.TAB && $(this).data("autocomplete").menu.active) {
            	event.preventDefault();
           	}
       	}).autocomplete({
        	source: function(request, response) {
        		searchType = $('#search-type').val();
        		searchUrl = "<?php echo base_url();?>/"
            		+searchType
            		+"/get_string/"
            		+extractLast(request.term);
            	$.getJSON( searchUrl,{},response);
            },
            search: function() {
                var term = extractLast(this.value);
                if (term.length < 1) {
                    return false;
                }
            },
            focus: function() {
                return false;
            },
            select: function(event, ui) {
                //var terms = split(this.value);
                //terms.pop();
                //terms.push(ui.item.value);
                //terms.push("");
                //this.value = terms.join( "," );
                this.value = ui.item.label;
                searchType = $('#search-type').val();
                itemUrl =  "<?php echo base_url('/'); ?>" + searchType + '/item/' + ui.item.value;
                window.location.href = itemUrl;
                //$('#search-list').append("<a href='"+itemUrl+"'>"+ui.item.label+"</a> ");
                return false;
            }
        });          
 	});
	/* END AUTOCOMPLETE */

});
</script>
</body>
</html>