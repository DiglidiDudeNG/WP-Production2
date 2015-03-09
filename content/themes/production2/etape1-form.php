

	<ul>
		<li><?php echo $spectacle_titre ?></li>
		<li><?php echo $spectacle_prix ?>$</li>
		<li><?php echo $prestation_date ?></li>
		<li><?php echo $prestation_heure ?></li>
	</ul>
	<form action="<?php echo bloginfo('url'); ?>/achat" method="post">
		<label for="nb_billets">Nombre de billets : </label>
		<input type="text" name="nb_billets" id="nb_billets" value="2">
		<input type="hidden" name="etape" id="etape" value="2">
		<button type="submit" id="vers_etape_2" name="vers_etape_2">Allez à l'étape 2</button>
	</form>

	