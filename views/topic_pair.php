<div class="page-header">
  <h1>Topic Pair <?php print $topic_id_x; ?> + <?php print $topic_id_y; ?></h1>
</div>
<table class="table table-condensed">

</td>

  <tr>
    <td>&nbsp;</td>
    <td>
      <b>Topic <?php print $topic_id_x; ?>:</b> 
      <strong><?php print($topic_info_x['topic_words']); ?></strong>
      <small>
      <?php 
	 foreach($phrases_x as $phrase) 
	 {
         print ' | ' . $phrase['topic_phrase'];
    	 }
    	 ?>
      </small>
    </td>
    <td>
      <b>Topic <?php print $topic_id_y; ?>:</b>
      <strong><?php print($topic_info_y['topic_words']); ?></strong>
      <small>
	<?php 
	 foreach($phrases_y as $phrase) 
	 {
	 print ' | ' . $phrase['topic_phrase'];
	 }
	 ?>			
      </small>
    </td>
  </tr>
  
  <tr>
    <td align="right">
      Common Docs
    </td>
    <td colspan="2">
      <?php
	 if (sizeof($common_docs) == 0) 
	 {
	 print("These topics don't really have any documents in common.");
	 }
	 foreach ($common_docs as $doc) 
	 {
	 $doc_url = base_url('doc/item/'.$doc['doc_id']);
	 print "<div><a href='$doc_url'>".$doc['title']."</a></div>";			
	 }
	 ?>
    </td>
  </tr>
  
  <tr>
    <td align="right">
      Common Words
      <small>Ranked by intersection</small>
    </td>
    <td colspan="2">
      <?php
	 foreach($common_words as $word) 
	 {
	 $word_url = base_url('word/item/'.$word['word_str']);
	 print "<a href='$word_url'>".$word['word_str'].'</a> (<span class="quiet">'.$word['intersection']."</span>) ";
	 }
	 ?>
    </td>
  </tr>
  <tr>
    <td align="right">Alpha</td>
    <td><?php print progress_bar('success',$topic_info_x['topic_alpha'],0,$alpha_stats['max'],$topic_info_x['topic_alpha']); ?></td>
    <td><?php print progress_bar('success',$topic_info_y['topic_alpha'],0,$alpha_stats['max'],$topic_info_y['topic_alpha']); ?></td>
  </tr>
  <tr>
    <td align="right">Top Words</td>
    <td>
      <?php
	 foreach($words_x as $word) {
	 $vnow = $word['word_count'];
	 $word_url = base_url('word/item/'.$word['word_str']);
	 print("<div class='data-item'>");
	 print("<a href='$word_url'>".$word['word_str']."</a>");
	 print progress_bar('success',$vnow,0,$max_words,$vnow);
	 print("</div>");
	 }
	 ?>
    </td>
    <td>
      <?php
	 foreach($words_y as $word) {
	 $vnow = $word['word_count'];
	 $word_url = base_url('word/item/'.$word['word_str']);
	 print("<div class='data-item'>");
	 print("<a href='$word_url'>".$word['word_str']."</a>");
	 print progress_bar('success',$vnow,0,$max_words,$vnow);
	 print("</div>");
	 }
	 ?>			
    </td>
  </tr>
  <tr>
    <td align="right">Nearest Topics</td>
    <td>
      <?php 
	 foreach($topics_x as $topic_id => $topic) {
      $vnow = round($topic['js_div'],3);
      $topic_url = base_url('topic/item/'.$topic_id);
      print("<div class='data-item'>");
	print("<a href='$topic_url'>".$topic['topic_words']."</a>");
	print progress_bar('warning',$vnow,0,1,$vnow);
	print("</div>");
      }
      ?>			
    </td>
    <td>
      <?php 
	 foreach($topics_y as $topic_id => $topic) {
      $vnow = round($topic['js_div'],3);
      $topic_url = base_url('topic/item/'.$topic_id);
      print("<div class='data-item'>");
	print("<a href='$topic_url'>".$topic['topic_words']."</a>");
	print progress_bar('warning',$vnow,0,1,$vnow);
	print("</div>");
      }
      ?>			
    </td>
  </tr>
</table>
