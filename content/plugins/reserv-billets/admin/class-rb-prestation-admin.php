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
		'date' => array(
			'nope' => 'nope',
		),
		'' => array(

		),
		'd' => array(

		),
		'e' => array(

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

	/**
	 * @param WP_Post $prestation
	 */
	public function render_info_meta_box($prestation)
	{
		if ( ! current_user_can( 'edit_posts' ) )
			return;

		$selected = '';

		var_dump( $prestation );

		$prestation_date = get_post_meta( $prestation->ID, 'rb_prestation_date', true );
		$prestation_heure = get_post_meta( $prestation->ID, 'rb_prestation_heure', true );
		$prestation_spectacle_id = get_post_meta( $prestation->ID, 'rb_prestation_spectacle_id', true );

		?><table width="100%">
			<tr>
				<td style="width: 20%"><label for="rb_prestation_spectacle_id">Spectacle :</label></td>
				<td>
					<select style="width: 40%" name="rb_prestation_spectacle_id" id="rb_prestation_spectacle_id">
					<?php
					/** @var WP_Query $loop_spectacles */
					$loop_spectacles = new WP_Query(
						array(
							'post_type' => 'spectacle',
						)
					);

					while ($loop_spectacles->have_posts()) :
						$loop_spectacles->the_post();

						/** @var String $selected */
						$selected = $prestation_spectacle_id == the_ID() ? "selected" : '';
						?>
						<option value="<?php the_ID(); ?>" <?=$selected?>><?php the_title(); ?></option>
					<?php endwhile; ?>
					</select>
				</td>
			</tr>
	        <tr>
	            <td style="width: 20%"><label for="rb_prestation_date"></label>Date de la Prestation :</td>
	            <td><input type="date" id="rb_prestation_date" name="rb_prestation_date" value="<?php echo $prestation_date; ?>" /></td>
	        </tr>
            <tr>
	            <td style="width: 20%"><label for="rb_prestation_heure"></label>Heure de la Prestation :</td>
	            <td><input type="time" id="rb_prestation_heure" name="rb_prestation_heure" value="<?php echo $prestation_heure; ?>" /></td>
	        </tr>
	    </table>
        <?php
	}

	/**
	 * Sauvegarde les données des meta-data du post.
	 *
	 * Va utiliser les données $_POST envoyées par Wordpress lors de la sauvegarde.
	 *
	 * @param int     $prestation_id    L'ID de la prestation.
	 * @param WP_Post $prestation       Une instance de la prestation.
	 */
	public function save_custom_post( $prestation_id, $prestation )
	{
		if ( ! current_user_can( 'edit_posts' ) )
			return;

		// Checker si c'est bien le post_type courant.
		if ( $prestation->post_type == 'prestation' )
		{
			// Mettre l'ID du Spectacle si celui-ci est valide.
			if ( array_key_exists( 'rb_prestation_spectacle_id', $_POST )
			     && $this->valider_spectacle_id( $_POST['rb_prestation_spectacle_id'] ) )
			{
				update_post_meta( $prestation_id, 'rb_prestation_spectacle_id', $_POST['rb_prestation_spectacle_id'] );
			}

			// Mettre la date si elle est valide.
			if ( array_key_exists( 'rb_prestation_date', $_POST ) && !empty( $_POST['rb_prestation_date'] ) )
			{
				update_post_meta( $prestation_id, 'rb_prestation_date', $_POST['rb_prestation_date'] );
			}

			// Mettre l'heure si elle est valide.
			if ( array_key_exists( 'rb_prestation_heure', $_POST ) && !empty( $_POST['rb_prestation_heure'] ) )
			{
				update_post_meta( $prestation_id, 'rb_prestation_heure', $_POST['rb_prestation_heure'] );
			}
		}
	}

	/**
	 * Modifie les colonnes affichées dans la liste de prestations sur le panneau d'admin.
	 *
	 * @param array $columns Les colonnes.
	 *
	 * @return array La nouvelle liste de colonnes.
	 */
	public function set_post_list_columns($columns)
	{
		unset( $columns['date'], $columns['title'], $columns['categories'],
			$columns['author'], $columns['tags'], $columns['comments'] );

		return array_merge( $columns,
			array(
				'rb_spectacle' => __('Spectacle'),
				'rb_date' => __('Date'),
				'rb_heure' => __('Heure'),
			)
		);
	}

	/**
	 * Afficher les colonnes personnalisés qui montrent les données
	 *
	 * @param String $column    Le nom de la colonne.
	 * @param int    $post_id   L'ID du post courant dans la loop d'affichage de la liste.
	 */
	public function display_custom_columns_data( $column, $post_id )
	{
		global $post;

		switch ( $column )
		{
			case 'rb_spectacle':
				echo get_post_meta( $post->id, 'rb_prestation_spectacle_id', true );
				break;

			case 'rb_date':
				echo get_post_meta( $post->id, 'rb_prestation_date', true );
				break;

			case 'rb_heure':
				echo get_post_meta( $post->id, 'rb_prestation_heure', true );
				break;
		}
	}

	/**
	 * Valide la date entrée.
	 *
	 * @param $date
	 *
	 * @return bool Vrai si ça marche, faux si non.
	 */
	private function valider_date($date)
	{
		$valide = false;
		$date = explode( '-', $date );
		$dateAssoc = array();

		for ( $i = 0; $i < count( $date ); $i ++ ) {
			$date[ $i ] = intval( $date[ $i ] );
		}

		if ( $date[0] ) {

		}

		return $valide;
	}

	/**
	 * Valider l'ID du spectacle
	 *
	 * @param int $id L'Id du spectacle.
	 *
	 * @return bool Vrai si l'ID du spectacle est correct,
	 *              Faux sinon.
	 */
	private function valider_spectacle_id($id)
	{
		$valide = true;

		// TODO valider l'ID du spectacle.

		return $valide;
	}
}