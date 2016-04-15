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
    <div class="lead">
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
    <div>
    	<p>This entropy of the document reflects the mixture of the topics it contains. A
    		very low entropy document will contain one topic in a high concentration; a high
    		entropy document will contain many topics. This measure may indicate how focused a 
    		document is, or how many ideas are being combined within it. A very high entropy 
    		document is frequently very small or even empty.</p>
    </div>
    <?php
    $vmin = 0;
    $vmax = round($entropy['max'],3);
    $vnow = round($entropy['this'],3);
    print progress_bar('info',$vnow,$vmin,$vmax,$vnow);
    ?>
  <h2>Topic Mixture</h2>
  <?php
 $vmin = 0;
 $vmax = 1;
  foreach($topics as $topic) {
     $vnow = round($topic['topic_weight'],2);
     $topic_url = base_url('topic/item/'.$topic['topic_id']);
     print("<div class='data-item'>");
     print("<a title='{$topic['topic_weight']}' href='$topic_url'>");
     print("<p>".$topic['topic_words']."</p>");
     print("</a>");
     print progress_bar('success',$vnow,$vmin,$vmax,$vnow);
     print("</div>");
  }
  ?>
  <h2>Top Words</h2>
  <div>
  	<p>The most frequently appearing words in this document.</p>
  </div>
  <?php
    $vmin = 0;
    $vmax = $max_words;
      foreach($words as $word) {
        $vnow = $word['word_count'];
        $word_url = base_url('word/item/'.$word['word_str']);
        print("<div class='data-item'>");
        print("<a href='$word_url'>{$word['word_str']}</a>");
        print progress_bar('success',$vnow,$vmin,$vmax,$vnow);
        print("</div>");
      }
  ?>
</div>

<div class="col-md-4">
    <h2>Nearest Documents</h2>
    <div>
        <p>These are documents are similar to the current
        document by virtue of their distribution over topics.
        This similarity is calculated as the Helinger Distance, 
        which is roughly proportional to the Jensen-Shannon Divergence,
        but much less expensive to compute. Note that the average 
        distance between documents in this corpus is 
        <b><?php print round($avg_distance,3); ?></b>.</p>
    </div>
    <?php
    $vmin = 0;
    $vmax = 1;
    foreach($related_docs as $doc) {
        $vnow = round($doc['distance'],3);    
        $doc_url = base_url('doc/item/'.$doc['doc_id_2']);
        print("<div class='data-item'>");
        print("<a href='$doc_url'>".$doc['title']."</a>");
        print progress_bar('success',$vnow,0,1.4,$vnow);
        print("</div>");
    }
    ?>
</div>
