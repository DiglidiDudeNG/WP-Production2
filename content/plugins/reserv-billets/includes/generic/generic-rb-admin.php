<?php

/**
 * Class RB_Admin
 *
 * Classe abstraite pour les classes qui configurent le panneau d'administration.
 */
abstract class RB_Admin 
{
	/** @var String Le numéro de version du plugin. */
	protected $version;
	/** @var Array{String} La liste des fichiers CSS à enqueue. */
	public $css;
	/** @var String La classe pour le dashicon. */
	public $dashicon;
	
	/** @var Array{String} Les données de la metabox. */
	public $admin_metabox = array(
		'title' => 'Billets pour le Spectacle'
	);
	
	/**
	 * Constructeur. 'Nuff said.
	 * 
	 * Inspiré de la méthode « register_post_type() » de WordPress, cette méthode permettra 
	 * une abstraction à couper le souffle! (Si, si!)
	 * 
	 * @param array $args {
	 *      Les arguments pour la création des options du panneau d'administration.
	 *      
	 *      @type string        $version            La version du plugin.
	 *      @type array|null    $styles             {
	 *          Les styles à « enqueuer » dans la section admin.
	 *          
	 *          @type string $handle       Le nom du handle du style. Doit être unique.
	 *          @type string $filepath     Le chemin vers le fichier CSS par rapport à la position du fichier de la classe.
	 *                                     TODO vérifier si ça va pogner la bonne path malgré l'héritage.
	 *          @type array  $dependencies {
	 *              Les dépendances.
	 *              TODO arranger les dépendances.
	 *          }
	 *          @type array  $
	 *      }
	 * }
	 *
	 * @throws \Exception Pas encore choisi pourquoi en envoyer une.
	 */
	public function __construct( array $args )
	{
		$defaults_prestation_admin = array(
			'version' => /* $this->get_version()*/'',
			'styles' => array(
				array(
					'handle' => 'rb_prestation_admin',
					'filepath' => 'css/rb-prestation-admin.css',
				)
			),
			'' => ''
		);
		
		// Passer les arguments par défaut à l'aide d'une fonction de WordPress. (Merci, WordPress!)
		$args = wp_parse_args( $args, $defaults_prestation_admin );
		
		// Transformer l'array en objet.
		$args = (object) $args;
		
		// Checker si le tag de version a été inclu.
		if ( array_key_exists( 'version', $args ) ) 
			$this->version = $args['version'];
		
		// Initialiser un compteur.
		$counter = 0;
		
		// Checker si les styles ont été inclus.
		if ( array_key_exists( 'styles', $args ) ) 
		{
			// Parcourir les styles.
			foreach ( $args['styles'] as $style ) 
			{
				// Checker si le handle ET le path ont été inclus dans le style.			
				if ( array_key_exists( 'handle', $style ) && array_key_exists( 'filepath', $style ) ) {
					$this->css[ $counter ]['handle'] = $style['handle'];
					$this->css[ $counter ]['filepath'] = $style['filepath'];
				} else {
					// Envoyer une exception, vu qu'on a besoin d'un handle et d'un filepath obligatoirement.
					return new WP_Error('rb_admin_badly_formed_style_arg', __( "RB: L'argument de styles doit être bien formé." ));
				}
				
				// Checker si les dépendences ont été inclues dans le style.
				if ( array_key_exists( 'dependencies', $style ) ) {
					// Checker si les dépendences sont vides ou non. TODO implémenter les dépendences.
					if ( !is_array( $style['dependencies'] || empty( $style['dependencies'] ) ) ) {
						// Mettre les dépendances à un array vide si elles sont pas un array rempli.
						$this->css[ $counter ]['dependencies'] = array();
					} else {
						// Mettre les dépendances dans les params du style courant.
						$this->css[ $counter ]['dependencies'] = $style['dependencies'];
					}
				} else {
					// Mettre les dépendances du style courant à null.
					$this->css[ $counter ]['dependencies'] = array();
				}
				
				// Ajouter 1 au compteur.
				$counter ++;
			}
		}
		else
		{
			return new WP_Error( 'rb_admin_1', "" );
		}
		
		// Réinitialiser le compteur.
		$counter = 0;
		
		$this->metabox = $args['metabox_args'];
	}
	
	/**
	 * Pousse toutes les feuilles de styles requises du plugin pour le panneau d'administration.
	 */
	public function enqueue_styles()
	{
		foreach ( $this->css as $css ) {
			wp_enqueue_style(
				$css['handle'],   // Le nom de la feuille de style.
				plugin_dir_url( __FILE__ ) . $css['path'], // Source
				$css['dependencies'],    /** Dépendances des handles de style.
			                 * @see WP_Dependencies::add() */
				$this->version,   // Version
				'all'             // Media query specification
			);
		}
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
		$metabox_title = '<h1>' . $this->admin_metabox
		                 . '<span class="dashicons ' . $this->$dashicon . '">'
		                 . '</span></h1>';
		
		// Ajouter la meta-box.
		add_meta_box(
			'rb-spectacle-admin',        // valeur de l'attribut « id » dans la balise.
			$metabox_title, // Titre.
			array( $this, 'render_meta_box' ), // Callback qui va echo l'affichage.
			'spectacle',                 // L'écran où est affiché le meta-box.
			'normal',                    // Le contexte. ex. "side", "normal" ou "advanced".
			'core'                       // La priorité.
		);
		// TODO faire un remove_meta_box() durant la désactivation.
	}
	
	/**
	 * Retourne la liste des métadonnées assignées pour ce post-type.
	 *
	 * @return array
	 */
	public function get_metadatas()
	{
		return $this->metadatas;
	}
	
	/**
	 * Crée des metabox pour le panneau d'administration.
	 *
	 * @action admin_init
	 */
	public function add__meta_box()
	{
		// Ajouter un dashicon dans le titre.
		$metabox_title = 'Informations sur la Prestation <span class="dashicons dashicons-tickets-alt"></span>';
		
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
	public function render_info_meta_box( $prestation )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		
		// Pogner toutes les metadonnées.
		$prestation_metas = get_post_meta( $prestation->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY ) :
//			var_dump( $prestation );
			var_dump( $prestation_metas );
		endif;
		
		?>
		<table width="100%">
		<tr>
		<td style="width: 25%"><label for="rb_prestation_spectacle_id"><?=__( 'Spectacle' )?> :</label></td>
		<td>
		<select style="width: 95%" name="rb_prestation_spectacle_id" id="rb_prestation_spectacle_id">
		<?php
		/** @var WP_Query $loop_spectacles */
		$loop_spectacles = new WP_Query( [ 'post_type' => 'spectacle' ] );
		
		while ( $loop_spectacles->have_posts() ) :
			$loop_spectacles->the_post(); ?>
			<option value="<?php the_ID(); ?>" <?php
			selected( $prestation_metas['rb_prestation_spectacle_id'][0], get_the_ID() );
			?>><?php the_title(); ?></option>
		<?php endwhile; ?>
		</select>
		</td>
		<td rowspan="3" style="width: 50%; background-color: #aaa; border-radius: 8px;" id="rb_preview_spectacle">
		
		</td>
		</tr>
		<tr>
			<td><label for="rb_prestation_date"></label><?=__( 'Date de la Prestation' )?> :</td>
			<td><input type="date" id="rb_prestation_date" name="rb_prestation_date"
			           value="<?=$prestation_metas['rb_prestation_date'][0]?>" /></td>
		</tr>
		<tr>
			<td><label for="rb_prestation_heure"></label><?=__( 'Heure de la Prestation' )?> :</td>
			<td><input type="time" id="rb_prestation_heure" name="rb_prestation_heure"
			           value="<?=$prestation_metas['rb_prestation_heure'][0]?>" /></td>
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
	 * @param int     $prestation_id L'ID de la prestation.
	 * @param WP_Post $prestation    Une instance de la prestation.
	 */
	public function save_custom_post( $prestation_id, $prestation )
	{
		global $wpdb;
		
		// Checks save status
		$is_autosave = wp_is_post_autosave( $prestation_id );
		$is_revision = wp_is_post_revision( $prestation_id );
		// TODO effectuer la validation par NOnce.
		// $is_valid_nonce = ( isset( $_POST[ 'rb_nonce' ] ) && wp_verify_nonce( $_POST[ 'rb_nonce' ], basename( __FILE__ ) ) ) ? true : false;
		$is_valid_nonce = true;
		
		// S'en va du script dépendamment si ça passe ou non.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}
		
		// Checker si on a toutes les valeurs requises pour la prestation.
		if ( array_key_exists( 'rb_prestation_spectacle_id', $_POST ) && array_key_exists( 'rb_prestation_date', $_POST )
		     && array_key_exists( 'rb_prestation_heure', $_POST )
		) {
			// Mettre l'ID du Spectacle si celui-ci est valide.
			if ( $this->valider_spectacle_id( $_POST['rb_prestation_spectacle_id'] ) ) // Updater le post_meta.
			{
				update_post_meta( $prestation_id, 'rb_prestation_spectacle_id', $_POST['rb_prestation_spectacle_id'] );
			} else {
				return;
			}
			
			// Mettre la date si elle est valide.
			if ( ! empty( $_POST['rb_prestation_date'] ) ) // Updater le post_meta.
			{
				update_post_meta( $prestation_id, 'rb_prestation_date', $_POST['rb_prestation_date'] );
			} else {
				return;
			}
			
			// Mettre l'heure si elle est valide.
			if ( ! empty( $_POST['rb_prestation_heure'] ) ) // Updater le post_meta.
			{
				update_post_meta( $prestation_id, 'rb_prestation_heure', $_POST['rb_prestation_heure'] );
			} else {
				return;
			}
			
			// Mettre le titre du post dans une variable.
			//			$titre = get_the_title( $_POST['rb_prestation_spectacle_id'] ) . " - " .  ;
			$titre = __( "Prestation" ) . " #" . $prestation->ID;
			
			// Le titre.
			$wpdb->update( $wpdb->posts, array( 'post_title' => $titre ), array( 'ID' => $prestation_id ) );
		} else // Sinon
		{
			// Retourner sans rien faire. Duh.
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
	public function set_post_list_columns( $columns )
	{
		unset( $columns['date'], /* $columns['title'], */
			$columns['categories'],
			$columns['author'], $columns['tags'], $columns['comments'] );
		
		return array_merge( $columns,
		                    array(
			                    'rb_spectacle' => __( 'Spectacle' ),
			                    'rb_date' => __( 'Date' ),
			                    'rb_heure' => __( 'Heure' ),
		                    )
		);
	}
	
	/**
	 * Afficher les colonnes personnalisés qui montrent les données
	 *
	 * @action manage_prestation_posts_custom_column
	 *
	 * @param String $column  Le nom de la colonne.
	 * @param int    $post_id L'ID du post courant dans la loop d'affichage de la liste.
	 */
	public function display_custom_columns_data( $column, $post_id )
	{
		global $post;
		
		switch ( $column ) {
			// Le spectacle relié.
			case 'rb_spectacle':
				$spec_id = get_post_meta( $post_id, 'rb_prestation_spectacle_id', true );
				
				// Chercher le spectacle au ID spécifié.
				$spectacle = get_the_title( $spec_id );
				
				// Checker si y'a un spectacle qui correspond.
				if ( empty( $spectacle ) ) // Afficher que le message n'a pas été trouvé.
				{
					echo __( 'SPECTACLE INCONNU' );
				} else // Afficher le titre du spectacle.
				{
					print $spectacle;
				}
				break;
			
			// La date de la prestation
			case 'rb_date':
				echo self::date_string_format( get_post_meta( $post_id, 'rb_prestation_date', true ) );
				break;
			
			// L'heure de la prestation.
			case 'rb_heure':
				echo get_post_meta( $post_id, 'rb_prestation_heure', true );
				break;
		}
	}
	
	/**
	 * Assigne la posibilité de trier des posts par rapport aux colonnes personnalisées.
	 *
	 * @param Array $columns Les colonnes déjà triables.
	 *
	 * @return Array Les colonnes triables, incluant nos colonnes personnalisées.
	 */
	public function sort_custom_columns( $columns )
	{
		$columns['rb_prestation_spectacle_id'] = 'rb_prestation_spectacle_id';
		$columns['rb_prestation_date'] = 'rb_prestation_date';
		$columns['rb_prestation_heure'] = 'rb_prestation_heure';
		
		return $columns;
	}
	
	/**
	 * Ajoute la requête de triage pour chaque type.
	 *
	 * @filter request
	 *
	 * @param $vars
	 *
	 * @return array
	 */
	public function orderby_custom_columns( $vars )
	{
		foreach ( $this->get_metadatas() as $metadata ) {
			if ( isset( $vars['orderby'] ) && $metadata == $vars['orderby'] ) {
				
				$args = array(
					'meta_key' => $metadata,
					'orderby' => 'meta_value_num'
				);
				
				$vars = array_merge( $vars, $args );
			}
		}
		
		return $vars;
	}
	
	/**
	 * Pogne le custom field depuis la boucle.
	 *
	 * TODO meilleur doc pour get_custom_field
	 *
	 * @param $field_name
	 *
	 * @return mixed
	 * @deprecated
	 */
	function get_custom_field( $field_name )
	{
		return get_post_meta( get_the_ID(), $field_name, true );
	}
	
	/**
	 * Retourne le numéro de version du plugin.
	 *
	 * @return String Le numéro de version du plugin.
	 */
	function get_version()
	{
		return $this->version;
	}
}
