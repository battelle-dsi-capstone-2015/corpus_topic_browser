<div class="page-header">
	<h1>Words</h1>
</div>


<div class="col-md-6">
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
<div class="col-md-6">
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
