<h2>Lijst van meldingen</h2>
<?php
if (is_array($content)) {
	foreach ($content as $report) {
		$disqus_url = BASE_URL.'meldingen/'.$report['id'].'#disqus_thread'; ?>
	<div class="mainpagereport">
		<?php
		$title = ucwords($report['companyname']);
		$time = date('d-m-Y H:i:s', strtotime($report['timestamp'].'+1hour'));
		?>
		<h3 class="reporttitle"><a href="bedrijven/<?php echo $report['company_id']; ?>"><?php echo $title; ?></a></h3>
		<h4 class="reportauthor">Door <?php echo ucwords($report['name']); ?> op <?php echo $time; ?></h4>
		<div class="reportcontent">
			<?php echo stripslashes($report['report']); ?>
		</div>
		<a class="readmore" href="meldingen/<?php echo $report['id']; ?>">Lees meer</a>
		<a class="commentcount" href="<?php echo $disqus_url; ?>" data-disqus-url="<?php echo $disqus_url; ?>" data-disqus-identifier="melding<?php echo $report['id']; ?>">0 reacties</a>
	</div>
	<?php } ?>
<script type="text/javascript">
var disqus_shortname = '<?php echo DISQUS_SHORTNAME; ?>';

(function () {
	var s = document.createElement('script'); s.async = true;
	s.type = 'text/javascript';
	s.src = '//' + disqus_shortname + '.disqus.com/count.js';
	(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>
<?php } else { ?>
Er kunnen op dit moment geen meldingen worden weergegeven
<?php } ?>