<div class="page-header">
	<h1>Words</h1>
</div>

<div class="col-md-4">
	<p class="lead">This page shows the most significant words (tokens) in the corpus,
		based on a supervised nonparametric trend detection algorithm originally 
		developed in the context of social media (Twitter). These results&mdash;shown on the right and 
		listed on the left below&mdash;suggest terms of potential 
		interest to the user based on their likelihood of embodying significant trends. In addtion,
		we provide lists of top words based on simple counts, in the middle and right hand columns below.</p>
</div>
<div class="col-md-8">
	<?php
	$settings = array(
		'structured_data' => 'true',
		'structure' => array(
			'key' 			=> 't',
			'value' 		=> 'n',
			'tooltip' 		=> 't',
			'label' 		=> 't',
		),
		'back_colour' 		=> 'white',
		'stroke_colour' 	=> 'blue',
		'label_x' 			=> 'raw trend value',		
		'label_y' 			=> 'number of words',
		'back_stroke_width' => 0, 
		'axis_text_angle_h' => -45,
		'pad_top' 			=> 0,
  		'pad_bottom' 		=> 0,
  		'pad_left' 			=> 0,
  		'pad_right' 		=> 0,
  		'increment' 		=> 1,
  		'axis_font' 		=> 'arial', 
  		'bar_width' => 1,
  		'axis_font_size' => 12,
  		'label_font_size' => 14,	
	);
	$colors = array('blue');
	$links = array();
	$bg = draw_graph('BarGraph',$settings,$trend_distro,$colors,$links,400,800);
	print $bg;
	?>
</div>
<div class="col-md-4">
	<h2>Top <?php print $limit; ?> Trending Words</h2>
	<?php
	foreach($trending_words as $word) {
		$trend = $this->word->get_trend($word['word_str']); # Get an aggregate in the controller!
		$bg = sparkline($trend,2005,2015);
		#$trendiness = log($word['trendiness']);
		$trendiness = round($word['trendiness'],1);
		$word_url = base_url('word/item/'.$word['word_str']);
		print "<div class='data-item'>";
		print $bg;
		print "<a href='$word_url'>".$word['word_str']."</a>";
		print progress_bar('success',$trendiness,0,34	,number_format($trendiness));
		print "</div>";	
	}
	?>		
</div>
<div class="col-md-4">
	<h2>Top <?php print $limit; ?> Words in Corpus</h2>
	<p>The raw count of words in the corpus.</p>
	<?php
	foreach($words as $word) {
		$word_url = base_url('word/item/'.$word['word_str']);
		print "<div class='data-item'>";
		print "<a href='$word_url'>".$word['word_str']."</a>";
		print progress_bar('success',$word['word_freq'],0,$max_words,number_format($word['word_freq']));
		print "</div>";	
	}
	?>
</div>
<div class="col-md-4">
	<h2>Top <?php print $limit; ?> Words in Topics</h2>
	<p>The count of words that appear with high frequency in topics.</p>
    <?php
    foreach($words_in_topics as $word) {
        $vnow = $word['word_count'];
        $word_url = base_url('word/item/'.$word['word_str']);
        print "<div class='data-item'>";
        print "<a href='$word_url'>" . $word['word_str'] . "</a>";
        print progress_bar('success',$vnow, 0, $max_words, number_format($vnow)); 
        print "</div>";
    }
    ?>
</div>
