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
	$w = round(($topic['topic_alpha'] - $min)/($max - $min),2) * 100;
	$topic_url = base_url('topic/item/'.$topic['topic_id']);
	print("<div class='data-item'>");
	print("<p><a href='$topic_url'>" . $topic['topic_words'] . "</a></p>");
    print("<div class='progress'>");
    print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$w}' aria-valuemin='0' aria-valuemax='100' style='width: {$w}%'>");
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
	<h2 style="text-align:center;">Topic Entropy Distribution for this Corpus</h2>
	<div class="ct-chart ct-perfect-fourth"></div>
</div>	
<?php
	$labels = array();
	$data = array();
	foreach($topic_entropy as $r) {
		$labels[] = $r['h'];
		$data[] = $r['n'];
	}
?>
<script>
new Chartist.Bar('.ct-chart', {
	labels: [<?php print(implode(',',$labels)); ?>],
	series: [[<?php print(implode(',',$data)); ?>]]
}, 
{
	//seriesBarDistance: 1,
	//reverseData: false,
	//horizontalBars: false,
	axisY: {
		
	},
	axixX: {
		
	},
});
</script>