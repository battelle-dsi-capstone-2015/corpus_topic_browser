<div class="page-header col-md-12">
    <div class="col-md-6">
	<h1>
	    <small>Word</small>
	    <div><?php print($word_str); ?></div>
	</h1>
	</div>
	<div class="col-md-6">
		<div>
		<?php $bg = bar_graph1($trend,300,400,'year','frequency',2005,2015); print($bg); ?>
		</div>
		<table class="table">
			<tr>
				<td>Prevelance (ttf)</td>
				<td><?php print $score['ttf'];?></td>
			</tr>
			<tr>
				<td>Specificity (idf)</td>
				<td><?php print round($score['idf'],4);?></td>
			</tr>
			<tr>
				<td>DF</td>
				<td><?php print $score['df'];?><br /></td>
			</tr>		
		</table>
	</div>
</div>


<div class="col-md-5">
    <h2>Related Topics</h2>
    <div><p>The amount of times this word appears in the documents made of the topic.</p></div>
	<?php 
	foreach($topics as $topic) {
	    #$w = round($topic['word_count']/$max,2) * 100;
	    $vnow = $topic['word_count'];
	    $topic_url = base_url('topic/item/'.$topic['topic_id']); 
	    print("<div class='data-item'>");
		print("<a href='$topic_url'>");
		print($topic['topic_words']);
		print("</a>");
		print progress_bar('success',$vnow,0,$max_words,$vnow);
	    print("</div>");
	} 
	?>
</div>

<div class="col-md-7">
    <h2>Related Documents</h2>
    <div><p>Documents in which this word is the most frequent word.</p></div>
    <?php
    $vmin = 0;
	$vmax = $max_docwords;
    foreach ($docs as $doc) {
        $vnow = $doc['word_count'];
    	$doc_url = base_url('doc/item/'.$doc['doc_id']);
		print("<div class='data-item'>");
		print("<a href='$doc_url'>".$doc['title']."</a>");
		print progress_bar('success',$vnow,$vmin,$vmax,$vnow);
		print("</div>");
    }
	?>
  	
</div>
