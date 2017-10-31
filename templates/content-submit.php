<div class="page-warning" id="js-warning">Om een melding te kunnen maken moet U JavaScript aan hebben staan. De rest van de website kan zonder JavaScript gebruikt worden</div>

<h2>Maak een melding</h2>

<form id="submitreport" action="" method="POST">
	<fieldset>
		<caption>
			<p>Met het formulier hieronder kunt U melding maken van slechte recruiter-ervaringen. Deze worden bekeken voordat ze geplaatst worden om onbetrouwbare meldingen en/of scheldpartijen te filteren.</p>
			<p>Wees alstublieft oprecht in de meldingen, vermijdt onjuiste verklaringen, verdraaiingen en blijf bij de feiten. Namen van individuele recruiters worden verwijderd, lees in onze <a href="faq">F.A.Q.</a> waarom.</p>
			<p>Wilt U liever via e-mail uw ei kwijt of wilt U bestanden meesturen? Dat kan op <a href="mailto:melding@blacklist-recruiters.nl">melding@blacklist-recruiters.nl</a>.</p>
			<p>Voor meer informatie, lees <a href="faq">onze F.A.Q. hier</a>.</p>
		</caption>
		<div class="formRow">
			<label for="name">Uw naam:</label><input id="name" name="name" type="text" placeholder="Laat leeg om anoniem te melden">
		</div>
		<div class="formRow">
			<label for="company">Bedrijf van recruiter:</label>
			<select id="company" name="company">
				<option value="">Selecteer een bedrijf</option>
				<?php foreach($content as $company) { ?>
				<option value="<?php echo $company['id']; ?>"><?php echo ucwords($company['companyname']); ?></option>
				<?php } ?>
				<option value="other">Ander bedrijf, namelijk:</option>
			</select>
			<input type="text" id="newcompany">
		</div>
		<div class="formRow textarea">
			<label for="report">Uw melding:</label>
			<textarea name="report" id="report"></textarea>
		</div>
		<div class="formRow">
			<label for="peoplecheck">Hoeveel is twee maal twee?</label>
			<input type="text" id="peoplecheck">
		</div>
		<div class="formRow">
			<input type="submit" id="submitbtn" value="Verstuur" disabled>
		</div>
	</fieldset>
</form>