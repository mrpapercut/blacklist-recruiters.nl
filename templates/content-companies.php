<h2>Lijst van gemelde recruitmentbureaus</h2>


<div class="overviewcompanies">
	<p>Tussen haakjes staat het aantal meldingen per bedrijf.</p>
	<br>
	<ul>
	<?php
	foreach ($content as $company) {
        $em = '1.'.str_pad($company['reportcount'], 2, '0', STR_PAD_LEFT).'em';
		echo '<li data-id="'.$company['id'].'">
            <a href="bedrijven/'.$company['id'].'" style="font-size:'.$em.';line-height:'.$em.'">
            '.ucwords($company['companyname']).' ('.$company['reportcount'].')
            </a>
        </li>'."\n";
	}
	?>
	</ul>
</div>