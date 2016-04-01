<div class="page-header">
    <h1><?php print($page_title); ?></h1>
</div>

<?php 
if (isset($topics)) {
    print("<div class='well'>");
    foreach($topics as $topic) {
        print("<h4>{$topic['topic_id']}: {$topic['topic_words']}</h4>");
    }	
    print("</div>");
}
?>
<div class="col-md-6">
	<h2>Most Connected Documents</h2>
	<p>Documents with the lowest average Helsinger distance to other documents.</p>
	<?php
	foreach($connectors as $doc)
	{
		$doc_url = base_url('doc/item/'.$doc['doc_id']);
		$dist = round($doc['distance'],3);
		print("<div class='data-item'>");
		print("<a href='$doc_url'>" . $doc['title'] . "</a>");
		print progress_bar('success',$dist,0,1.4,$dist);
		print("</div>");		
	}
	?>
</div>
<div class="col-md-6">
	<h2>Most Lonely Documents</h2>
	<p>Documents with the highest average Helsinger distance to other documents.</p>
	<?php
	foreach($loners as $doc)
	{
		$doc_url = base_url('doc/item/'.$doc['doc_id']);
		$dist = round($doc['distance'],3);
		print("<div class='data-item'>");
		print("<a href='$doc_url'>" . $doc['title'] . "</a>");
		print progress_bar('success',$dist,0,1.4,$dist);
		print("</div>");		
	}
	?>
</div>