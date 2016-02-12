<div class="page-header">
	<h1>Topics</h1>
</div>


<div class="col-md-6">
	<h2>Topics by Alpha (&alpha;)</h2>
	<div>
		<p>The &alpha; value of a topic is a measure of the frequency with which it appears in the corpus. Topics with a
		high &alpha; appear in many documents with a high weight; as such, they often refer to very general themes, such as the genre of 
		the document collection itself. Topics with a low &alpha; value are outliers, and may appear in one or two
		documents.</p></div>
<?php
$min = $alpha_stats['min'];
$max = $alpha_stats['max']; 
foreach($topics as $topic) {
    $alpha = $topic['topic_alpha'];
	$w = round(($topic['topic_alpha'] - $min)/($max - $min),2) * 100;
	$topic_url = base_url('topic/item/'.$topic['topic_id']);
	print("<div class='data-item'>");
	print("<p style='font-size:110%;'><a href='$topic_url'>" . $topic['topic_words'] . "</a></p>");
    print("<div class='progress'>");
    print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$alpha}' aria-valuemin='{$min}' aria-valuemax='{$max}' style='width:{$w}%'>");
    #print("<span class='sr-only'>{$w}%</span>");
    print($topic['topic_alpha']);
    print("</div>");
    print("</div>");	
	#print("<div class='data-bar' style='width:{$w}%;'><small>{$topic['topic_alpha']}</small></div>");
	print("</div>");
}
?>	
</div>

<div class="col-md-6">
	<h2 style="text-align:center;">Documents by Topic Entropy (H)</h2>
	<div>
		<p>Topic entropy refers to the degree to which topic weights are equally distributed in a document. In 
			a high entropy document, the weighting of individual topics is less pronounced, tending toward an equiprobable
			distribution; in a low entropy document, fewer topics have a disproportionate weight. Documents with very high 
			entropy may be empty. Documents with very low entropy may have a high thematic specificity.</p>
	</div>
	<?php
	foreach($bars as $bar) {
		$w = round($bar['n'] / $nmax, 2) * 100;
		$h_start = round($bar['h'],2);
		$h_end = round($bar['m'],2);
		$doc_url = base_url("doc/by_entropy/$h_start/$h_end");
		print("<div class='data-item'>");
		print("<p><a href='$doc_url'>H >= $h_start and < $h_end</a></p>");
	    print("<div class='progress'>");
	    print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$bar['n']}' aria-valuemin='0' aria-valuemax='{$nmax}' style='width:{$w}%'>");
	    print($bar['n']);
	    print("</div>");
		print("</div>");
		print("</div>");
	}
	?>
</div>	
