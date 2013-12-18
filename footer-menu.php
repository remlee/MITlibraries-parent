<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
		<div class="clear"></div>
	</div>



<!-- Load JS in Footer -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
if (typeof jQuery == 'undefined')
{
    document.write(unescape("%3Cscript src='js/jquery.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>
<script src="<?php bloginfo('template_directory') ?>/libs/datepicker/glDatePicker.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/js/jquery.cycle.js"></script>
<script src="<?php bloginfo('template_directory') ?>/libs/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php bloginfo('template_directory') ?>/libs/lightbox/js/lightbox.js"></script>
<script src="<?php bloginfo('template_directory') ?>/js/core.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="<?php bloginfo('template_directory') ?>/libs/infobox/infobox.js"></script>
<script>


$("#hero").cycle({
	fx: "fade",
	speed: 1500,
	pause: 0

});

// Javascript to enable link to tab
var url = document.location.toString();

if (url.match('#')) {
    $('.tabnav a[href=#'+url.split('#')[1]+']').tab('show') ;
} 

// Change hash for page-reload
$('.tabnav a').on('shown', function (e) {
    window.location.hash = e.target.hash;
})

</script>

<?php wp_footer(); ?>
</body>
</html>