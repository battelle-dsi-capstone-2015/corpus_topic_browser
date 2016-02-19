<div class="page-header">
	<h1><small>Topic <?php print $topic_id; ?></small>
		<div><?php print($topic_info['topic_words']); ?></div>
	</h1>
</div>

<div id="topic-item-words" class="col-md-2">
	<h2>Topic Alpha</h2>
	<?php print progress_bar('success',$topic_info['topic_alpha'],0,$alpha_stats['max'],$topic_info['topic_alpha']); ?>
	
    <h2>Top Phrases</h2>
    <?php foreach($phrases as $phrase) {
        print("<p>");
        print($phrase['topic_phrase']);
        print("</p>");
    }
    ?>

    <h2>Top Words</h2>
    <?php
    $vmax = $max_words; // Max words for the whole corpus; may want to change this to for the topic
    $vmin = 0;
    foreach($words as $word) {
        $vnow = $word['word_count'];
        $word_url = base_url('word/item/'.$word['word_str']);
		print("<div class='data-item'>");
        print("<a href='$word_url'>".$word['word_str']."</a>");
		print progress_bar('success',$vnow,$vmin,$vmax,$vnow);
        print("</div>");
    }
    ?>
</div>

<div class="col-md-6">
	<?php $doc_url = base_url('doc/by_topic/'.$topic_id); ?>
    <h2>Related Documents</h2>
    <div>
        <p>This list shows the <b>top 25 documents</b> which contain the highest concentrations of this topic. The data 
    	bars show the percentage of this topic's concentration in each document.</p>
    	<p>Overall, there are <span class="btn btn-danger"><a  style="color:white;" href="<?php print($doc_url);?>"><?php print($doc_count); ?> 
    	documents</a></span> for which this topic accounts for <b>at least 10%</b> of its words.</p>
    </div>
    <?php
    $vmin = 0;
    $vmax = 1;
    foreach($docs as $doc_id => $doc) {
        $doc_url = base_url('doc/item/'.$doc_id);
        $vnow = round($doc['topic_weight'],2);
		$label = ($vnow * 100) . '%';
        print("<div class='data-item'>");
		print progress_bar('success',$vnow,$vmin,$vmax,$label);
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
    <div>
    	<p>Nearness of topics based on 
    		<a target='_blank' href="https://en.wikipedia.org/wiki/Jensen%E2%80%93Shannon_divergence">Jensen-Shannon Divergence</a>.
    		A lower value means the topic is closer to the current topic. 
    	</p>
    </div>
    <?php 
    $vmin = 0;
    $vmax = 1;
    foreach($topics as $topic_id => $topic) {
        $vnow = round($topic['js_div'],3);
    	$topic_url = base_url('topic/item/'.$topic_id);
    	print("<div class='data-item'>");
		print("<a href='$topic_url'>".$topic['topic_words']."</a>");
		print progress_bar('warning',$vnow,$vmin,$vmax,$vnow);
		print("</div>");
    }
	?>
</div>
