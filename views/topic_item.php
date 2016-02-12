<div class="page-header">
	<h1><small>Topic<?php #echo $topic_id; ?></small>
		<div><?php print($topic_info['topic_words']); ?></div>
	</h1>
</div>

<div id="topic-item-words" class="col-md-2">

    <h2>Top Phrases</h2>
    <div class="foo-list-group">
    <?php foreach($phrases as $phrase) {
        print("<p class='foo-list-group-item'>");
        print($phrase['topic_phrase']);
        print("</p>");
    }
    ?>
    </div>

    <h2>Top Words</h2>
    <?php
    $max = $words[0]['word_count'];
	$min = 0; 
    foreach($words as $word) {
    	$w = round(($word['word_count'] - $min)/($max - $min),2) * 100;
        $word_url = base_url('word/item/'.$word['word_str']);
		print("<div class='data-item'>");
        print("<a href='$word_url'>".$word['word_str']."</a>");
        print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$w}' aria-valuemin='0' aria-valuemax='100' style='width: {$w}%'>");
        print($word['word_count']);
        print("</div>");
        print("</div>");
        print("</div>");
    }
    ?>
</div>

<div class="col-md-6">
	<?php $doc_url = base_url('doc/by_topic/'.$topic_id); ?>
    <h2>Related Documents</h2>
    <div>
        <p>This list shows the <b>top 25 documents</b> which contain the highest concentrations of this topic. The data 
    	bars show the percentage of this topic's concentration in each document. Overall, there are <b><a href="<?php print($doc_url);?>"><?php print($doc_count); ?> 
    	documents</a></b> for which this topic accounts for <b>at least 10%</b> of its words.</p>
    </div>
    <?php
    foreach($docs as $doc_id => $doc) {
        $doc_url = base_url('doc/item/'.$doc_id);
		$w = round($doc['topic_weight'],2) * 100;	
        print("<div class='data-item'>");
        print("<div class='progress'>");
        print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$w}' aria-valuemin='0' aria-valuemax='100' style='width: {$w}%'>");
        print((round($doc['topic_weight'],2) * 100) . '%');
        print("</div>");
        print("</div>");
        print("<h4><a href='$doc_url'>".$doc['title']."</a></h4>");
        print("<div><p><b>".$doc['year']."</b> | ". $doc['authors']."</p></div>");
        print("<div id='doc-$doc_id' class='_collapse'><p>".$doc['abstract'].'</p></div>');
        print("<span class=''><a href='http://google.com/search?q={$doc['doi']}' target='_blank'>DOI:{$doc['doi']}</a></span> ");
        print("</div>");				
    }
    ?>
</div>

<div id="topic-item-topics" class="col-md-3">
    <h2>Nearest Topics</h2>
    <?php 
    foreach($topics as $topic_id => $topic) {
    	$w = round($topic['js_div'],2) * 100;
    	$topic_url = base_url('topic/item/'.$topic_id);
    	print("<div class='data-item'>");
		print("<a href='$topic_url'>");
		print($topic['topic_words']);
		print("</a>");
		#print("<div class='data-bar' style='margin-top:.5em; width:{$w}%;'><small>{$w}%</small></div>");
		print("</div>");
    }
	?>
</div>
