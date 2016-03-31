<div class="page-header">
	<h1>Words</h1>
</div>

<div class="col-md-4">
	<h2>Top <?php print $limit; ?> Trending Words</h2>
	<p>The result of a supervised machine learning algorithm.</p>
	<?php
	foreach($trending_words as $word) {
		$word_str = $word['word_str'];
		$trend_distro = $this->word->get_trend_distro($word_str);
		$bg = sparkline($graph,$trend_distro,2005,2015);
		$trendiness = log($word['trendiness']);
		#$img_src = "http://studio1.shanti.virginia.edu/capstone/sites/default/files/styles/medium/public/wordplots/{$word_str}.png";
		#$img_props = array(
	    #    'src'   => $img_src,
	    #    'width' => '100',
	    #    'height'=> '25'
		#);
		$word_url = base_url('word/item/'.$word['word_str']);
		print "<div class='data-item'>";
		print $bg;
		#print img($img_props);
		print "<a href='$word_url'>".$word['word_str']."</a>";
		print progress_bar('success',$trendiness,0,100,number_format($trendiness));
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
