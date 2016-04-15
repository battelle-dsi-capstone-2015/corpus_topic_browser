<div class="page-header">
    <h1><?php print($page_title); ?></h1>
</div>

<div class="col-md-4">
	<p class="lead">This page represents the corpus in terms of inter-document distances.
	Distance in this case refers to the Helsinger distance between documents, based on their
	topic mixtures. Documents with similar topic mixtures&mdash;similar topics in similar 
	concentrations&mdash;are closer than those with different mixtures.
	The graph on the right shows the distribution of distances, the mode being <b><tt>0.76</tt></b>.</p>
</div>
<div class="col-md-8">
	<?php
	$settings = array(
		'structured_data' => 'true',
		'structure' => array(
			'key' => 'd',
			'value' => 'n',
			'tooltip' => "d",
			'label' => 'd',
		),
		'back_colour' => '#fff',
		'stroke_colour' => 'blue',
		'label_x' => 'Helinger distance',		
		'label_y' => 'number of document dyads',
		'back_stroke_width' => 0, 
		'pad_top' => 0,
  		'pad_bottom' => 0,
  		'pad_left' => 0,
  		'pad_right' => 0,
  		'bar_width' => 5,
  		'axis_font_size' => 12,
  		'label_font_size' => 14,	
	);
	$colors = array('blue');
	$links = array();
	$bg = draw_graph('BarGraph',$settings,$helsinger_distro,$colors,$links,400,800);
	print $bg;
	?>
</div>
<div class="col-md-6">
	<h2>Most Connected Documents</h2>
	<p>Top 100 documents with the lowest average Helsinger distance to other documents. 
		These tend to have low topic entropy.</p>
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
	<h2>Most Lonely (Least Connected) Documents</h2>
	<p>Top 100 documents with the highest average Helsinger distance to other documents.
		These tend to have high topic entropy.</p>
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