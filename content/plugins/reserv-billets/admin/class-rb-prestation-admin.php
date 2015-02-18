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
	 *
	 * @action admin_init
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

		$prestation_metas = get_post_meta( $prestation->ID );
		
		if ( WP_DEBUG_DISPLAY ) :
			var_dump( $prestation );
			var_dump( $prestation_metas );
		endif;

		?><table width="100%">
			<tr>
				<td style="width: 20%"><label for="rb_prestation_spectacle_id"><?=__('Spectacle')?> :</label></td>
				<td>
					<select style="width: 40%" name="rb_prestation_spectacle_id" id="rb_prestation_spectacle_id">
					<?php
					/** @var WP_Query $loop_spectacles */
					$loop_spectacles = new WP_Query( ['post_type' => 'spectacle'] );

					while ($loop_spectacles->have_posts()) :
						$loop_spectacles->the_post(); ?>
						<option value="<?php the_ID(); ?>" <?php 
							selected( $prestation_metas['rb_prestation_spectacle_id'][0], get_the_ID() ); 
						?>><?php the_title(); ?></option>
					<?php endwhile; ?>
					</select>
				</td>
				<td rowspan="3" width="50%" style="background-color: #aaa; border-radius: 8px;" id="rb_preview_spectacle">
					
				</td>
			</tr>
	        <tr>
	            <td style="width: 20%"><label for="rb_prestation_date"></label><?=__('Date de la Prestation')?> :</td>
	            <td><input type="date" id="rb_prestation_date" name="rb_prestation_date" value="<?=$prestation_metas['rb_prestation_date'][0]?>" /></td>
	        </tr>
            <tr>
	            <td style="width: 20%"><label for="rb_prestation_heure"></label><?=__('Heure de la Prestation')?> :</td>
	            <td><input type="time" id="rb_prestation_heure" name="rb_prestation_heure" value="<?=$prestation_metas['rb_prestation_heure'][0]?>" /></td>
	        </tr>
	    </table>
        <?php
	}

	/**
	 * Sauvegarde les données des meta-data du post.
	 *
	 * Va utiliser les données $_POST envoyées par Wordpress lors de la sauvegarde.
	 *
	 * @action save_post
	 *
	 * @param int     $prestation_id    L'ID de la prestation.
	 * @param WP_Post $prestation       Une instance de la prestation.
	 */
	public function save_custom_post( $prestation_id, $prestation )
	{
		global $wpdb;
		
		// Checks save status
		$is_autosave = wp_is_post_autosave( $prestation_id );
		$is_revision = wp_is_post_revision( $prestation_id );
//		$is_valid_nonce = ( isset( $_POST[ 'rb_nonce' ] ) && wp_verify_nonce( $_POST[ 'rb_nonce' ], basename( __FILE__ ) ) ) ? true : false;
		$is_valid_nonce = true;
		
		// S'en va du script dépendamment si ça passe ou non.
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}
		
		// Checker si on a toutes les valeurs requises pour la prestation.
		if ( array_key_exists( 'rb_prestation_spectacle_id', $_POST ) && array_key_exists( 'rb_prestation_date', $_POST ) 
		        && array_key_exists( 'rb_prestation_heure', $_POST ) ) 
		{	
			// Mettre l'ID du Spectacle si celui-ci est valide.
			if ( $this->valider_spectacle_id( $_POST['rb_prestation_spectacle_id'] ) ) 
			{				
				// Updater le post_meta.
				update_post_meta( $prestation_id, 'rb_prestation_spectacle_id', $_POST['rb_prestation_spectacle_id'] );
			}
			
			// Mettre la date si elle est valide.
			if ( ! empty( $_POST['rb_prestation_date'] ) )
			{
				update_post_meta( $prestation_id, 'rb_prestation_date', $_POST['rb_prestation_date'] );
			}
			
			// Mettre l'heure si elle est valide.
			if ( ! empty( $_POST['rb_prestation_heure'] ) )
			{
				update_post_meta( $prestation_id, 'rb_prestation_heure', $_POST['rb_prestation_heure'] );
			}
		}
		else
		{
			return;
		}
	}

	/**
	 * Modifie les colonnes affichées dans la liste de prestations sur le panneau d'admin.
	 *
	 * @filter manage_prestation_posts_columns
	 *
	 * @param array $columns Les colonnes.
	 *
	 * @return array La nouvelle liste de colonnes.
	 */
	public function set_post_list_columns($columns)
	{
		unset( $columns['date'], /* $columns['title'], */ $columns['categories'],
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
	 * @action manage_prestation_posts_custom_column
	 *
	 * @param String $column    Le nom de la colonne.
	 * @param int    $post_id   L'ID du post courant dans la loop d'affichage de la liste.
	 */
	public function display_custom_columns_data( $column, $post_id )
	{
		global $post;

		switch ( $column )
		{
			// Le spectacle relié.
			case 'rb_spectacle':
				$spec_id = get_post_meta( $post_id, 'rb_prestation_spectacle_id', true );
				
				// Chercher le spectacle au ID spécifié.
				$spectacle = get_the_title($spec_id);
				
				// Checker si y'a un spectacle qui correspond.
				if ( empty( $spectacle ) ) :
					// Afficher que le message n'a pas été trouvé.
					echo __( 'Spectacle non-trouvé.' );
				else :
					// Afficher le titre du spectacle.
					printf( $spectacle );
				endif;
				
				break;

			// La date de la prestation
			case 'rb_date':
				$date = self::date_string_format(get_post_meta( $post_id, 'rb_prestation_date', true ));
				echo $date;
				break;

			// L'heure de la prestation.
			case 'rb_heure':
				$heure = get_post_meta( $post_id, 'rb_prestation_heure', true );
				echo $heure;
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
	private static function valider_date( $date )
	{
		$valide = true; // TODO à false
		$date = explode( '-', $date );
		
		for ( $i = 0; $i < count( $date ); $i ++ ) {
			$date[ $i ] = intval( $date[ $i ] );
		}

		if ( $date[0] ) {
			
		}

		return $valide;
	}

	/**
	 * Formate la date pour l'affichage.
	 */
	private static function date_string_format( $date )
	{
		$finalDate = $date;

		// TODO formater la date.
		
		return $finalDate;
	}

	/**
	 * Valider l'ID du spectacle
	 *
	 * @param int $id L'Id du spectacle.
	 *
	 * @return bool Vrai si l'ID du spectacle est correct,
	 *              Faux sinon.
	 */
	private function valider_spectacle_id( $id )
	{
		return ( get_post( $id )->post_type == 'spectacle' ? true : false );
	}
}
