<?php

/**
 * Le gestionnaire de tout ce qui a rapport avec le panneau administration
 * et l'entité « Prestation ».
 */
class RB_Prestation_Admin extends RB_Admin
{
	/**
	 * @var array Une liste d'arrays.
	 * TODO automatiser le rendu et la sauvegarde des metadata.
	 */
	private $metadatas = array(
		"date" => array(

		),
		"" => array(

		),
		"" => array(

		),
		"" => array(

		),
	);

	/**
	 * Constructeur. 'Nuff said.
	 *
	 * @param String $version Le numéro de version du plugin.
	 */
	public function __construct( $version )
	{
		parent::__construct( $version );
	}

	/**
	 * Retourne la liste des métadonnées assignées pour ce post-type.
	 *
	 * @return array
	 */
	public function getMetadatas()
	{
		return $this->metadatas;
	}

	public function enqueue_styles()
	{
		wp_enqueue_style(
			'rb-prestation-admin',   // Le nom de la feuille de style.
			plugin_dir_url( __FILE__ ) . 'css/rb-prestation-metabox.css', // Source
			array(),                /** Dépendances des handles de style.
		 * @see WP_Dependencies::add() */
			$this->version,         // Version
			FALSE                   // Media query specification
		);

		// TODO faire un wp_dequeue_style durant la désactivation.
	}

	/**
	 * Crée des metabox pour le panneau d'administration.
	 */
	public function add_info_meta_box()
	{
		// Ajouter un dashicon dans le titre.
		$metabox_title = 'Informations <span class="dashicons dashicons-store"></span>';

		// Ajouter la meta-box.
		add_meta_box(
			'rb-prestation-admin-info',        // valeur de l'attribut « id » dans la balise.
			$metabox_title, // Titre.
			array( $this, 'render_info_meta_box' ), // Callback qui va echo l'affichage.
			'prestation',                 // L'écran où est affiché le meta-box.
			'normal',                    // Le contexte. ex. "side", "normal" ou "advanced".
			'high'                       // La priorité.
		);
	}

	public function render_info_meta_box($prestation)
	{
		$prestation_date = get_post_meta( $prestation->ID, 'rb_prestation_date', true );
		var_dump( $prestation );
//		$prestation_heure = ;
		?><table>
	        <tr>
	            <td style="width: auto"><label for="rb_prestation_date"></label>Date de la Prestation</td>
	            <td><input type="date" id="rb_prestation_date" name="rb_prestation_date" value="<?php echo $prestation_date; ?>" /></td>
	        </tr>
            <tr>
	            <td style="width: auto"><label for="rb_prestation_heure"></label>Date de la Prestation</td>
	            <td><input type="time" id="rb_prestation_heure" name="rb_prestation_heure" value="<?php echo $presation_heure; ?>" /></td>
	        </tr>
	        <tr>
	            <td style="width: 150px">Spectacle</td>
	            <td>
	                <select style="width: 100px" name="rb_prestation_spectacle_id">
	                <?php
	                // TODO changer ça pour une liste de spectacles.
	                for ( $rating = 5; $rating >= 1; $rating -- ) { ?>
		                <option value="<?php /* echo $spectacle_id; */ ?>" <?php echo /* selected( $rating, $movie_rating ); */ ?>>
	                <?php echo $rating; ?> stars <?php } ?>
	                </select>
	            </td>
	        </tr>
	    </table><?php
	}

	/**
	 * Sauvegarde les données des meta-data du post.
	 *
	 * Va utiliser les données $_POST envoyées par Wordpress lors de la sauvegarde.
	 *
	 * @param int     $prestation_id    L'ID de la prestation.
	 * @param WP_Post $prestation       Une instance de la prestation.
	 */
	public function save_post_custom_meta( $prestation_id, $prestation )
	{

	}

	//	public function add_artiste_meta_box()
//	{
//		$metabox_title = '<h1>Informations sur la Prestation'
//		                 .'<span class="dashicons dashicons-shop icone-billets">'
//		                 .'</span></h1>';
//	}


}