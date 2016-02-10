<div class="page-header">
	<h1><?php print($page_title); ?></h1>
</div>

<?php
foreach($docs as $doc) {
	$doc_url = base_url('doc/item/'.$doc['doc_id']);
	print("<div>");
	print("<span class='label label-default'>".$doc['topic_entropy']."</span> ");
	print("<a href='$doc_url'>".$doc['title'])."</a>";
	print("</div>");	
}
?>