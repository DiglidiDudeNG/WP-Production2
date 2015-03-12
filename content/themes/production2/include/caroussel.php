<section class="carousel2 container-fluid">
	<!-- ne pas changer le nom du ID sinon les boutons ne fonctionnent plus -->
	<div id="carousel-example-generic" class="slide carousel carousel-fade" data-ride="carousel">
	  <!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			
			<div class="item active image-un">
				<img src="<?php echo IMAGES; ?>/redhotchilipeppers-carousel.jpg" alt="Coldplay">
				<div class="carousel-caption">
					<h1>Red Hot Chili Peppers</h1>
					<h2>25 Avril 2015 à
					<span class="carousel-heure">20:00</span></h2>
					<button class="btn-savoir">En savoir plus</button>
				</div>
			</div>

			<div class="item image-deux">
				<img src="<?php echo IMAGES; ?>/alex-nevsky-carousel.jpg" alt="Roger Waters">
				<div class="carousel-caption">
					<h1>Alex Nevsky</h1>
					<h2>2 Mai 2015 à
					<span class="carousel-heure">20:00</span></h2>
					<button class="btn-savoir">En savoir plus</button>
				</div>
			</div>
			
			<div class="item image-trois">
				<img src="<?php echo IMAGES; ?>/imagine-dragons-carousel.jpg" alt="The Killers">
				<div class="carousel-caption">
					<h1>Imagine Dragons</h1>
					<h2>5 Mai 2015 à
					<span class="carousel-heure">20:00</span></h2>
					<button class="btn-savoir">En savoir plus</button>
				</div>
			</div>
		</div>
	</div>
</section>