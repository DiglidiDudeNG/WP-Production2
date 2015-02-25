<?php

/**
 * RB_Spectacle_Admin
 * ===========
 *
 * Le gestionnaire de tout ce qui a rapport avec le panneau administration
 * et l'entité « Spectacle ».
 *
 * @package RB
 * @see RB_Spectacle::define_admin_hooks()
 */
class RB_Spectacle_Admin extends RB_Admin
{
	const BASE_SLUG = 'rb_prestation';
	public $dashicon = 'dashicons-store';
	
	/**
	 * Constructeur.
	 *
	 * @param string $post_type L'identifiant du Post-Type.
	 * @param array  $args      Les arguments.
	 */
	public function __construct( $post_type, $args )
	{
		parent::__construct( $post_type, $args );
	}

	/**
	 * Ajoute un submenu dans le menu des Spectacles.
	 */
	public function add_option_menu_spectacle()
	{
		// Ajouter le sous-menu "Configurations" dans le menu des Spectacles.
		add_submenu_page (
			'edit.php?post_type=spectacle', // Slug du parent.
			'Options des Spectacles',
			'Configurations', // Titre sur les menus
			'manage_options', // Seulement accessible si le user peut changer les options.
			'rb_spectacle_options', // Le slug de la page.
			'my_admin_page_function', // La fonction reliée à l'affichage de la page.
									  // TODO faire une fonction pour l'affichage de la page.
			'none', // Aucune icône.
			'25'
		);
	}
	
	 
	/**
	 * Effectue un rendu de la metabox des informations.
	 *
	 * @param WP_Post $spectacle
	 */
	public function render_spectacle_info_metabox( $spectacle )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		
		// Pogner toutes les metadonnées.
		$spectacle_metas = get_post_meta( $spectacle->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY )
			var_dump( $spectacle_metas );
		
		// Effectue la recherche des metadonnées.
		foreach ( $this->metadatas as $meta_key => $meta_args )
		{
			
		}
		
		?>
		<table width="100%">
		<tr>
			<td style="width: 25%"><label for="rb_spectacle_liste_prestation_id"><?php
					echo $this->metadatas['rb_spectacle_liste_prestation_id']['name'];
					?> :</label></td>
			<td>
				<ul>
				<?php
				$args = $this->metadatas['rb_spectacle_list_prestation_id']['metabox_query'];
				
				/** @var WP_Query $loop_prestation */
				$loop_prestation = new WP_Query( $args );
				
				if ($loop_prestation->post_count == 0) echo "<li><b>Aucune.</b> <a href='".admin_url()."post-new.php?post_type=prestation'>Ajouter --></a></li>";
				
				while ( $loop_prestation->have_posts() ) :
					$loop_prestation->the_post(); ?>
					<li><?php
					the_ID();
					?> : <?php
					the_title();
					echo " (".get_post_meta( get_the_ID(), 'rb_prestation_date', true ).")";
					?></li>
				<?php endwhile; ?>
				</ul>
			</td>
		</tr>
		<tr>
			<td><label for="rb_spectacle_artiste_site_url"><?=
					$this->metadatas['rb_spectacle_artiste_site_url']['name']?> :</label></td>
			<td><input type="url" id="rb_spectacle_artiste_site_url" name="rb_spectacle_artiste_site_url"
			           value="<?=$spectacle_metas['rb_spectacle_artiste_site_url'][0]?>" /></td>
		</tr>
		<tr>
			<td><label for="rb_spectacle_artiste_facebook_url"><?=
					$this->metadatas['rb_spectacle_artiste_facebook_url']['name']?> :</label></td>
			<td><input type="url" id="rb_spectacle_artiste_facebook_url" name="rb_spectacle_artiste_facebook_url"
			           value="<?=$spectacle_metas['rb_spectacle_artiste_facebook_url'][0]?>" /></td>
		</tr>
		<tr>
			<td><label for="rb_spectacle_prix"><?=
					$this->metadatas['rb_spectacle_prix']['name']?> :</label></td>
			<td><input type="number" id="rb_spectacle_prix" name="rb_spectacle_prix" 
				       min="1.00" max="999.00" step="0.01" value="<?=$spectacle_metas['rb_spectacle_prix'][0]?>" /> $</td>
		</tr>
		</table>
	<?php
	}
	
	/**
	 * @param \WP_Post $post
	 *
	 * @return mixed|void
	 */
	public function render_default_metabox( $post )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		
		// Pogner toutes les metadonnées.
		$post_metas = get_post_meta( $post->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY )
			var_dump( $post_metas );
	}
	
	
}

