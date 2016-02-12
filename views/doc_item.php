<div class="page-header">
	<h1>
		<small>Document</small>
		<div>
			<span class='doc-item-title'><?php print($doc['title']); ?></span><br/>
		    <span class='doc-item-year'><?php print($doc['year']); ?></span> | 
		    <span class='doc-item-authors'><?php print($doc['authors']); ?></span>
	    </div>
	</h1>
</div>

<div class="col-md-5">
    <h2>Abstract</h2>
    <div class="foo-panel panel-default">
        <div class="foo-panel-body">
            <?php print($doc['abstract']); ?>
        </div>
        <div class="foo-panel-footer" style="margin-top:1em;">
            <div class="label label-primary">Document <?php echo $doc_id; ?></div>
            <?php if ($doc['cite_count']): ?>
            <div class="label label-success">Cited by <?php print($doc['cite_count']); ?></div>
            <?php endif; ?>
            <div class="label label-default">
                <a style='color:white;' href="http://google.com/search?q=<?php print($doc['doi']); ?>" target="_blank">
                    DOI:<?php print($doc['doi']); ?>
                </a>
            </div>
        </div>
    </div>	
</div>

<div class="col-md-3">
	<h2>Topic Entropy</h2>
	<p>This topic entropy for this document.</p>
	<?php
		$max = $entropy['max'];
		$h = round($entropy['this'],2);
		$w = round($entropy['this']/$max,2) * 100;
        print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-info' role='progressbar' aria-valuenow='{$h}' aria-valuemin='0' aria-valuemax='{$max}' style='width: {$w}%'>");
        print($h);
        print("</div>");
        print("</div>");
	?>
    <h2>Related Topics</h2>
    <p>The topic mixture of this document.</p>
    <?php
    foreach($topics as $topic) {
    	$w = round($topic['topic_weight'],2) * 100;
        $topic_url = base_url('topic/item/'.$topic['topic_id']);
        print("<div class='data-item'>");
        print("<a title='{$topic['topic_weight']}' href='$topic_url'>");
        print("<p>".$topic['topic_words']."</p>");
        print("</a>");
        print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$w}' aria-valuemin='0' aria-valuemax='100' style='width: {$w}%'>");
        print($w.'%');
        print("</div>");
        print("</div>");
        print("</div>");
    }
    ?>
    <!--
    <h2>Topic Entropy</h2>
    <table class="data-box">
    	<tr>
    		<td>This document</td>
    		<td><?php print($entropy['this']); ?></td>
    	</tr>
    	<tr>
    		<td>Average</td>
    		<td><?php print($entropy['avg']); ?></td>
    	</tr>
    	<tr>
    		<td>Max</td>
    		<td><?php print($entropy['max']); ?></td>
    	</tr>
    	<tr>
    		<td>Min</td>
    		<td><?php print($entropy['min']); ?></td>
    	</tr>
    </table>
    -->
</div>

<div class="col-md-4">
    <h2>Related Documents</h2>
    <div>
	    <p>These are the top ten related documents to the current document. A document
	    	is related to the current one if it also has a high topic weight for the dominant 
	    	topic of the current document.</p>    	
    </div>
    <?php
    foreach($docs as $doc) {
        $doc_url = base_url('doc/item/'.$doc['doc_id']);
        print("<div class='data-item'>");
        print("<a href='$doc_url'>");
        print($doc['title']);
        print("</a>");
        print("</div>");
    }
    ?>
</div>
<!--
<?php
	$labels = array();
	$data = array();
	$svg = array();
	foreach($topic_distro as $r) {
		$labels[] = "'".$r['topic_words']."'";
		$data[] = $r['topic_weight'];
	}
?>
<script>
new Chartist.Bar('.ct-chart', {
	labels: [<?php print(implode(',',$labels)); ?>],
	series: [[<?php print(implode(',',$data)); ?>]]
}, 
{
	seriesBarDistance: 1,
	reverseData: true,
	horizontalBars: true,
	axisY: {
		offset: 70
	}
});
</script>
-->