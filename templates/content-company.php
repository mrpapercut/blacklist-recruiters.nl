<h2><?php echo ucwords($content['companyname']); ?></h2>

<div class="detailcompany">
	<h3 class="numberReports">Aantal meldingen: <?php echo count($content['reports']); ?></h3>
	<ul id="companyreports">
	<?php
	if (count($content['reports']) > 0) {
		foreach($content['reports'] as $report) {
			$ts = date('d-m-Y H:i:s', strtotime($report['timestamp'].'+1hour'));
			$reportname = $ts;
			$class = null;
			$title = null;

			if (strtotime($report['timestamp']) < strtotime('-12 months')) {
				$class = 'older-1year';
				$title = 'This report is more than 1 year old';
			} elseif (strtotime($report['timestamp']) < strtotime('-6 months')) {
				$class = 'older-6months';
				$title = 'This report is more than 6 months old';
			}

			echo '<li data-id="'.$report['id'].'" class="'.$class.'" title="'.$title.'"><a href="meldingen/'.$report['id'].'">'.$reportname.'</a></li>'."\n";
		}
	}
	?>
	</ul>
</div>