<div class="page-header">
	<h1>
	    <small>Word</small>
	    <div><?php print($word_str); ?></div>
	</h1>
</div>


<div class="col-md-5">
    <h2>Related Topics</h2>
    <div><p>The amount of times this word appears in the modeled corpus. The maxinum number
    of any word is <kbd><?php print($max_words); ?></kbd>.</p></div>
	<?php 
	#$max = $topics[0]['word_count']; 
	$max = $max_words;
	$min = 0;
	foreach($topics as $topic) {
	    $w = round(($topic['word_count'] - $min)/($max - $min),2) * 100;
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
    <?php
    foreach ($docs as $doc) {
    	$doc_url = base_url('doc/item/'.$doc['doc_id']);
		print("<div class='data-item'><a href='$doc_url'>".$doc['title']."</a></div>");
    }
	?>
  	
</div>
