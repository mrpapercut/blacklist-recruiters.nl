<?php if($content['report']['allowed'] == '0') { ?>
<div class="page-warning">Deze melding is nog niet geplaatst en wacht op controle van de beheerder.</div>
<?php } ?>

<h2>Melding over <?php echo ucwords($content['report']['companyname']); ?></h2>

<div class="detailreport">
	<span class="author">Door <?php echo ucwords($content['report']['name']); ?> op <?php echo date('d-m-Y H:i:s', strtotime($content['report']['timestamp'].'+1hour')); ?></span>
	<div class="reportcontent">
		<?php echo stripslashes($content['report']['report']); ?>
	</div>

	<?php if (is_array($content['otherreports']) && count($content['otherreports']) > 0) { ?>
	<div class="otherreports">
		<h3>Andere meldingen over <?php echo ucwords($content['report']['companyname']); ?>:</h3>
		<ul>
		<?php foreach ($content['otherreports'] as $report) {
			$li = '<li data-id="'.$report['id'].'"><a href="meldingen/'.$report['id'].'">';
			$li .= date('d-m-Y H:i:s', strtotime($report['timestamp'].'+1hour'));
			$li .= '</a></li>'."\n";

			echo $li;
		} ?>
		</ul>
	</div>
	<?php } ?>
</div>

<div class="detailreport">
	<div id="disqus_thread"></div>
	<script type="text/javascript">
		var disqus_shortname = 'blacklistrecruiters',
			disqus_identifier = 'melding<?php echo $content['report']['id']; ?>';

		(function() {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

</div>