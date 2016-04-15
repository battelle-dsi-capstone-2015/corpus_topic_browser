<div class="page-header">
	<h1>Topics</h1>
</div>
<div class="col-md-7">
	<h2>Topics by Alpha (&alpha;)</h2>
	<div>
		<p>The &alpha; value of a topic is a measure of the frequency with which it appears in the corpus. Topics with a
		high &alpha; appear in many documents with a high weight; as such, they often refer to very general themes, such as the genre of 
		the document collection itself. Topics with a low &alpha; value are outliers, and may appear in one or two
		documents.</p></div>
<?php
$vmin = $alpha_stats['min'];
$vmax = $alpha_stats['max']; 
foreach($topics as $topic) {
	$trend = $trends['t'.$topic['topic_id']];
	$bg = sparkline($trend,2005,2015);
    $vnow = $topic['topic_alpha'];
	$topic_url = base_url('topic/item/'.$topic['topic_id']);
	$img_url = base_url("assets/images/topic_plots/t{$topic['topic_id']}.png");
	print("<div class='data-item'>");
	print("<p style='font-size:110%;'>");
	print $bg;   
	print("<a href='$topic_url'>" . $topic['topic_words'] . "</a> <span class='text-muted'><small>T-". $topic['topic_id']."</small></span></p>");
	print progress_bar('success',$vnow,$vmin,$vmax,$vnow);
	print("</div>");
}
?>	
</div>

<div class="col-md-5">
	<h2>Documents by Topic Entropy (H)</h2>
	<div>
		<p>Topic entropy refers to the degree to which topic weights are equally distributed in a document. In 
			a high entropy document, the weighting of individual topics is less pronounced, tending toward an equiprobable
			distribution; in a low entropy document, fewer topics have a disproportionate weight. Documents with very high 
			entropy may be empty. Documents with very low entropy may have a high thematic specificity.</p>
	</div>
	<?php
	$vmin = 0;
	$vmax = $nmax;
	foreach($bars as $bar) {
	    $vnow = $bar['n'];
		$h_start = round($bar['h'],2);
		$h_end = round($bar['m'],2);
		$doc_url = base_url("doc/by_entropy/$h_start/$h_end");
		print("<div class='data-item'>");
		print("<p><a href='$doc_url'>H >= $h_start and < $h_end</a></p>");
		print progress_bar('info',$vnow,$vmin,$vmax,$vnow);
		print("</div>");
	}
	?>
</div>	
