<script>
	var topics = <?php print(json_encode($topics)); ?>;
	d3.select('body').selectAll('p')
		.data(topics)
		.enter()
		.append('table')
		.text(function(d){
			return d.topic_words + ' (' + d.topic_alpha + ")\n";
		})
		.style('color', function(d){
			if (d.topic_alpha >= .05) {
				return 'red';
			}
			if (d.topic_alpha <= .03) {
				return 'green';
			}
		}).style('text-align', 'right');
</script>