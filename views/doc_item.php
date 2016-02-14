<div class="page-header">
   <h1>
     <small>Document</small>
     <div>
       <div class='doc-item-title'><?php print($doc['title']); ?></div>
       <div>
	       <span class='doc-item-year'><?php print($doc['year']); ?></span> | 
    	   <span class='doc-item-authors'><?php print($doc['authors']); ?></span>
       </div>
     </div>
   </h1>
</div>

<div class="col-md-4">
  <h2>Abstract</h2>
  <div>
    <div>
      <?php print($doc['abstract']); ?>
    </div>
    <div style="margin-top:1em; margin-bottom:2rem;">
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

<div class="col-md-4">
  <h2>Topic Entropy</h2>
  <?php
     $max = $entropy['max'];
     $h = round($entropy['this'],2);
     $w = round($entropy['this']/$max,2) * 100;
     print progress_bar('info',$h,0,$max,$w,$h);
     ?>
  <h2>Topic Mixture</h2>
  <?php
  foreach($topics as $topic) {
     $w = round($topic['topic_weight'],2) * 100;
     $topic_url = base_url('topic/item/'.$topic['topic_id']);
     print("<div class='data-item'>");
     print("<a title='{$topic['topic_weight']}' href='$topic_url'>");
     print("<p>".$topic['topic_words']."</p>");
     print("</a>");
     print progress_bar('success',$w,0,100,$w,"$w%");
     print("</div>");
  }
  ?>
  <h2>Top Words</h2>
  <div>
  	<p>The most frequently appearing words in this document.</p>
  </div>
  <?php
  foreach($words as $word) {
  	$w = round($word['word_count']/$max_words,2) * 100;
	$word_url = base_url('word/item/'.$word['word_str']);
	print("<div class='data-item'>");
	print("<a href='$word_url'>{$word['word_str']}</a>");
	print progress_bar('success',$word['word_count']*10,0,$max_words*10,$w,$word['word_count']);
	print("</div>");
  }
  ?>
     
</div>

<div class="col-md-4">
  <h2>Related Documents</h2>
  <div>
    <p>These are ten documents that are related to the current
      document because they share a top topic. These documents,
      however, may contain that topic in a higher concentration than
      the current. A better measure of document similarity would
      compare all topics and their distribution.</p>
  </div>
  <?php
  foreach($docs as $doc) {
     $doc_url = base_url('doc/item/'.$doc['doc_id']);
     $w = round($doc['topic_weight'],2) * 100;
     print("<div class='data-item'>");
     print("<a href='$doc_url'>");
     print($doc['title']);
     print("</a>");
     print progress_bar('success',$w,0,100,$w,"$w%");
     print("</div>");
  }
  ?>
</div>
