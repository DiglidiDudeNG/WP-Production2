<?php
/*
Template Name: Contact
*/
?>
<?php get_header(); 
?>


<!-- Début de la page contact -->
<section id="contact">
	<div class="container">
		<h2>Contact</h2>
		<div class="row">
			<div class="col-md-4 col-sm-6 text-center">
				<i class="fa fa-automobile"></i>
				<address>
					<p class="contact-titre"><strong>Adresse</strong></p>
					<p>987 avenue Cartier</p>
					<p>Québec (Québec) G1F 5T6</p>
				</address>
			</div>
			
			<div class="col-md-4 col-sm-6 text-center">
				<i class="fa fa-phone"></i>
				<p class="contact-titre"><strong>Coordonées</strong></p>
				<p>(418) 123 4567 </p>
				<a href="mailto:info@salleperenthese.com"><p>info@salleperenthese.com</p></a>
			</div>
			
			<div class="col-md-4 col-sm-6 text-center">
				<i class="fa fa-clock-o"></i>
				<p class="contact-titre"><strong>Heures d'ouverture</strong></p>
				<p>Lundi au vendredi: 8h à 22h</p>
				<p>Samedi & dimanche: 8h à 23h</p>
			</div>
		</div>
		<div class="google-maps">
			<iframe class="text-center" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1365.495651613675!2d-71.22683106928797!3d46.80447721704898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cb896794d9a648d%3A0x33bec377fab7ba92!2s987+Avenue+Cartier%2C+Qu%C3%A9bec%2C+QC+G1R+2S2!5e0!3m2!1sfr!2sca!4v1425324474900" width="600" height="400" frameborder="0" style="border:0"></iframe>
		</div>		
	</div>
</section>
	<!-- fin du contenu de la page contact.php -->
	
	<div id="googleMap" style="width:500px;height:380px;"></div>

<?php get_footer(); ?>

<script
src="http://maps.googleapis.com/maps/api/js">
</script>


<script>
var myCenter=new google.maps.LatLng(51.508742,-0.120850);

function initialize()
{
var mapProp = {
  center: myCenter,
  zoom:5,
  mapTypeId: google.maps.MapTypeId.ROADMAP
  };

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position: myCenter,
  title:'Click to zoom'
  });

marker.setMap(map);

// Zoom to 9 when clicking on marker
google.maps.event.addListener(marker,'click',function() {
  map.setZoom(9);
  map.setCenter(marker.getPosition());
  });
     
google.maps.event.addListener(map,'center_changed',function() {
// 3 seconds after the center of the map has changed, pan back to the marker
  window.setTimeout(function() {
    map.panTo(marker.getPosition());
  },3000);
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
