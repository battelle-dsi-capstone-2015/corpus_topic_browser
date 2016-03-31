<div class="page-header">
  <h1>Topics <?php print $topic_id_x; ?> &amp; <?php print $topic_id_y; ?></h1>
</div>
<div class="col-md-4">
	<h2>Similarity Index</h2>
	<p>A smaller value is closer</p>
	<p>
		<?php 
		print progress_bar('warning',$js_div,$js_div_ends['min'],$js_div_ends['max'],round($js_div,3));
		?>
	</p>
    <?php
    $img_x = base_url("assets/images/topic_plots/t{$topic_id_x}.png");
    $img_y = base_url("assets/images/topic_plots/t{$topic_id_y}.png");
    ?>
    <h2>Comparisons</h2>
    <p>
        <div class='lead'>
        	<?php print $topic_id_x; ?>:
        	<a href="<?php print base_url('topic/item/'.$topic_id_x);?>"><?php print($topic_info_x['topic_words']); ?></a>
        </div>
        <div class='lead'>
        	<?php print $topic_id_y; ?>:
        	<a href="<?php print base_url('topic/item/'.$topic_id_x);?>"><?php print($topic_info_y['topic_words']); ?></a>
        </div>
	</p>
	<h3><var>&alpha;</var></h3>
	<p>
        <?php print progress_bar('success',$topic_info_x['topic_alpha'],0,$alpha_stats['max'],$topic_info_x['topic_alpha']); ?>
        <?php print progress_bar('success',$topic_info_y['topic_alpha'],0,$alpha_stats['max'],$topic_info_y['topic_alpha']); ?>
    </p>
    <p>
    	<?php print(img($img_x)); ?>
	    <?php print(img($img_y)); ?>
    </p>
</div>

<div class="col-md-4">
   <h2>Common Docs</h2>
   <?php if (sizeof($common_docs) == 0) { print("These topics don't really have any documents in common."); } ?>
   <?php foreach ($common_docs as $doc) {
       $doc_url = base_url('doc/item/'.$doc['doc_id']);
       print "<p class=''><a href='$doc_url'>".$doc['title']."</a></p>";			
   } ?>
</div>

<div class="col-md-4">
    <h2>Common Words</h2>
    <div class="">
    <?php foreach($common_words as $word) {
        $word_url = base_url('word/item/'.$word['word_str']);
        print "<a href='$word_url'>".$word['word_str'].'</a> <span class="quiet"><small>'.$word['intersection']."</small></span> ";
    } ?>
    </div>
</div>