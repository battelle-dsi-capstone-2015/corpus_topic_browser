<div class="page-header">
	<h1>
	    <small>Word</small>
	    <div><?php print($word_str); ?></div>
	</h1>
</div>


<div class="col-md-5">
    <h2>Related Topics</h2>
    <div><p>The amount of times this word appears in the documents made of the topic. [?]</p></div>
	<?php 
	$max = $max_words;
	foreach($topics as $topic) {
	    $w = round($topic['word_count']/$max,2) * 100;
	    $topic_url = base_url('topic/item/'.$topic['topic_id']); 
	    print("<div class='data-item'>");
		print("<a href='$topic_url'>");
		print($topic['topic_words']);
		print("</a>");
		print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$topic['topic_words']}' aria-valuemin='0' aria-valuemax='{$max}' style='width:{$w}%'>");
        print($topic['word_count']);
        print("</div>");
        print("</div>");
	    print("</div>");
	} 
	?>
</div>

<div class="col-md-7">
    <h2>Related Documents</h2>
    <div><p>Documents in which this word is the most frequent word.</p></div>
    <?php
	$max = $max_docwords;
    foreach ($docs as $doc) {
    	$w = round($doc['word_count']/$max,2) * 100;
    	$doc_url = base_url('doc/item/'.$doc['doc_id']);
		print("<div class='data-item'>");
		print("<a href='$doc_url'>".$doc['title']."</a>");
		print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$doc['word_count']}' aria-valuemin='0' aria-valuemax='{$max}' style='width:{$w}%'>");
        print($doc['word_count']);
        print("</div>");
        print("</div>");		
		print("</div>");
    }
	?>
  	
</div>
