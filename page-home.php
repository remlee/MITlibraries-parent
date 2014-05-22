<?php 
	get_header();
?>

	<div class="search--lib-resources">
		<h2>Search in</h2>
		<select name="" id="">
			<option value="">Option #1</option>
			<option value="">Option #2</option>
			<option value="">Option #3</option>
			<option value="">Option #4</option>
			<option value="">Option #5</option>
		</select>
		<label>for</label>
		<input type="text">
		<label>by</label>
		<select name="" id="">
			<option value="">Option #1</option>
			<option value="">Option #2</option>
			<option value="">Option #3</option>
			<option value="">Option #4</option>
			<option value="">Option #5</option>
		</select>
	</div>
	<div class="hours-locations">
		<h2>Hours &amp; Locations</h2>
		<?php get_template_part('inc/location', 'info'); ?>
		<a href="/map">View Map</a>
		<a href="/study" class="study">Find a Study Space</a>
		<h3><a href="/hours" class="button">All Hours &amp; Locations</a></h3>
	</div>
	<div class="news-events">
		<h2>News &amp; Events</h2>
		<div class="item-1"><h3></h3></div>
		<div class="item-2"><h3></h3></div>
		<script>
			$.get('/news', function(data) {
				var newsItem1 = $(data).find('h2[data-post-number="0"]').text();
				var newsItem2 = $(data).find('h2[data-post-number="1"]').text();
				$('.item-1 h3').append(newsItem1);
				$('.item-2 h3').append(newsItem2);
			});
			// $('.item-1').load('/news h2[data-post-number="0"]');
			// $('.item-2').load('/news h2[data-post-number="1"]');
		</script>
	</div>
	<div class="guides-experts">
		<h2>Research Guides &amp; Experts</h2>
	</div>

<?php 
	get_footer();
?>