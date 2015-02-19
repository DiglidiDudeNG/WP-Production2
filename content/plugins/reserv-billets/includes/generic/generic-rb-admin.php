<?php

/**
 * Class RB_Admin
 *
 * Classe abstraite pour les classes qui configurent le panneau d'administration.
 */
abstract class RB_Admin 
{
	/** @const BASE_SLUG Le début des slugs utilisés. 
	 *  @note  Si cette classe est utilisée dans un autre plugin, il serait sage de changer cette variable !
	 */
	const BASE_SLUG = 'rb_';
	
	/** @var string Le nom du post-type. */
	protected $post_type;
	
	/* --- DÉBUT DES ARGS --- */
	
	/** @var string Le numéro de version du plugin. */
	protected $version;
	/** @var Array{object} La liste des fichiers CSS à enqueue, en objets. */
	public $styles;
	/** @var string La classe pour le dashicon. */
	public $dashicon;
	/** @var Array{object} La liste des metaboxes, en objets. */
	public $metaboxes;
	
	/** @noinspection PhpDocSignatureInspection */
	
	/**
	 * Constructeur. 'Nuff said.
	 * 
	 * Inspiré de la méthode « register_post_type() » de WordPress, cette méthode permettra 
	 * une abstraction à couper le souffle! (Si, si!)
	 * 
	 * @global $wp_version La version courante de WP.
	 * 
	 * @param string $post_type L'identifiant du post type. Doit être sans le slug du plugin. // TODO décider s'il faut inclure le slug.
	 * @param array  $args      {
	 *      Les arguments pour la création des options du panneau d'administration.
	 *
	 *      @type string        $version            La version du plugin.
	 *      @type string|null   $dashicon           La classe du dashicon à utiliser. Vide ou null si on ne veux pas de dashicon.
	 *      @type array|null    $styles             { --- ARRAY ---
	 *          Les styles à « enqueuer » dans la section admin.
	 *          
	 *          @type array [0...n] { --- ARRAY ---
	 *              Un style.
	 * 
	 *              @type string $handle       Le nom du handle du style. Doit être unique.
	 *              @type string $filepath     Le chemin vers le fichier CSS par rapport à la position du fichier de la classe.
	 *                                         TODO vérifier si ça va pogner la bonne path malgré l'héritage.
	 *              @type array  $dependencies { --- ARRAY ---
	 *                  Les dépendances.
	 *                  TODO Documenter les dépendances.
	 *                  TODO Implémenter les dépendances.
	 *              }
	 *              @type string $media        Le media-query visé. Ex: 'screen'
	 *          }
	 *      }
	 *      @type array $metaboxes { --- ARRAY ---
	 *          Liste de metaboxes.
	 * 
	 *          @type array $[0...n] { --- ARRAY ---
	 *              Un meta-box.
	 * 
	 *              @type string $id            Attribut 'ID' de l'élément HTML affiché.
	 *              @type string $title         Le titre affiché dans son header. Peut contenir du HTML.
	 *              @type bool   $show_dashicon Vrai si le Dashicon doit être affiché après le titre de la metabox.
	 *              @type string $dashicon      La classe du dashicon à afficher.
	 *                                          Si vide, ce sera celle définie à la racine des args.
	 *              @type string $callback      Le nom de la fonction appelée qui va afficher le HTML intérieur.
	 *              @type string $context       Le contexte. ex: "side", "normal" ou "advanced".
	 *              @type string $priority      La priorité. ex: 'core'
	 *          }
	 *      }
	 * }
	 * @return WP_Error|bool Vrai si ça a marché, ou un objet WP_Error sinon.
	 */
	public function __construct( $post_type, array $args )
	{
		// Valeurs par défaut dans le root.
		$defaults = array(
			'version'   => $wp_version,
			'dashicon'  => '',
			'styles'    => array(), /** @see $defaults_styles */
			'metaboxes' => array(), /** @see $defaults_metaboxes */
		);
		
		// Valeurs par défaut des styles.
		$defaults_styles = array(
			'handle'       => null,
			'filepath'     => "css/rb_admin_default.css", // Une feuille de style par défaut, 'cuz why not!
			'dependencies' => array(),
			'media'        => 'screen',
		);
		
		// Vérifier si le post_type est valide.
		if ( empty( $post_type ) || strlen( $post_type ) > 20 )
		{
			// Envoyer une exception, vu qu'il faut avoir un post-type valide
			// TODO mettre la bonne version de WP.
			return $this->afficher_msg_erreur( 'rb_admin_post_type_length_invalid',
			                                   'Les noms de Post Types doivent être entre 1 et 20 caractères de longueur.', __FUNCTION__ );
		}
		elseif ( ! post_type_exists( $post_type ) ) // Sinon vérifier si le post_type existe.
		{
			// Envoyer une exception, vu qu'il faut avoir un post-type déjà enregistré afin de styler son administration.
			// TODO mettre la bonne version de WP.
			return $this->afficher_msg_erreur( 'rb_admin_post_type_undefined',
			                                   "Les post types doivent exister avant de définir leurs options du panneau d'admin.", __FUNCTION__ );
		}
		
		// Assigner le nom du post_type.
		$this->post_type = $post_type;
		
		// Les valeurs par défaut des metaboxes.
		$defaults_metaboxes = array(
				'id'            => null,
				'title'         => 'Metabox',
				'show_dashicon' => false,
				'dashicon'      => '',
				'callback'      => null,
				'screen'        => $this->post_type,
				'context'       => 'default',
				'priority'      => null,
		);
		
		// Passer les arguments par défaut à l'aide d'une fonction de WordPress. (Merci, WordPress!)
		$args = wp_parse_args( $args, $defaults );
		
		// Transformer l'array d'arguments en objet afin de faciliter la validation.
		$args = (object) $args;
		
		// Initialiser un compteur.
		$counter = 0;
		
		// Checker si les styles ont été inclus.
		if ( !empty( $args->styles ) )
		{
			// Vérifier si la liste de styles est bien un array. (Même s'il est vide!)
			if ( !is_array( $args->styles ) )
			{
				// Envoyer une exception, vu qu'il faut des styles bien formés pour continuer.
				// TODO mettre la bonne version de WP.
				return $this->afficher_msg_erreur( 'rb_admin_badly_formed_styles', 
				                                   "Les styles du panneau d'admnistration pour « ".__CLASS__." » sont mal formés!", __FUNCTION__ );
			}
			
			// Parcourir les styles.
			foreach ( $args->styles as $style ) 
			{
				// Transformer le style en objet.
				$style = (object) $style;
				
				// Checker si le handle ET le path ont été inclus dans le style.			
				if ( $style->handle === null || $style->filepath === null ) {
					// Envoyer une exception, vu qu'on a besoin d'un handle et d'un filepath obligatoirement.
					// TODO mettre la bonne version de WP.
					return $this->afficher_msg_erreur( 'rb_admin_badly_formed_style_arg', 
					                                   "Les tables associatives de styles doivent être formées correctement.", __FUNCTION__ );
				}
				
				// Checker si les dépendences ont été inclues dans le style.
				if ( $style->dependencies !== null ) {
					// Checker si les dépendences sont vides ou non.
					if ( ! is_array( $style->dependencies ) || empty( $style->dependencies ) ) {
						// Mettre les dépendances à un array vide si elles sont pas un array rempli.
						// Notez que je n'affiche pas d'erreurs, vu que j'pas sûr quoi faire à date avec les dépendances!
						$style->dependencies = array();
					}
					// TODO implémenter les dépendences.
				} else { // Sinon mettre les dépendances du style courant à null.
					$style->dependencies = array();
				}
				
				// Ajouter le style.
				$this->styles[] = $style;
				
				// Ajouter 1 au compteur.
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
		
		// Vérifier si les metaboxes sont pas mises par défaut.
		if ( ! empty( $args->metaboxes ) )
		{
			// Parcourir chaque metabox.
			foreach ( $args->metaboxes as $metabox )
			{
				// Transformer l'array metabox en objet.
				$metabox = (object) $metabox;
				
				// Vérifier si l'id existe.
				if ( ! empty( $metabox->id ) )
				{
					// TODO c'qu'il faut faire durant la vérification.
				}
				else
				{
					// Si c'est pas un array, on affiche un msg d'erreur.
					return $this->afficher_msg_erreur( 'rb_admin_badly_formed_metabox_args',
					                                   "RB: Les tables associatives des metaboxes doivent être formées correctement.", __FUNCTION__ );
				}
				
				// Vérifier si le title est une string et qu'il n'est pas vide.
				// TODO probablement assigner un template pour les titles, vu que c'est essentiellement composé de HTML.
				if ( is_string( $metabox->title ) && ! empty( $metabox->title ) )
				{
					
				}
				else
				{
					// Si c'est pas un title valide, on affiche un message d'erreur.
					return $this->afficher_msg_erreur( 'rb_admin_badly_formed_metabox_title',
					                                   "RB: Le titre de vos metaboxes doivent être formés correctement.", __FUNCTION__ );
				}
				
				// Ajouter la metabox.
				$this->metaboxes[] = $metabox;
				
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
		
		// Retourner true, vu qu'on n'a pas retourné d'erreur!
		return true;
	}
	
	/**
	 * Affiche un message d'erreur à partir des infos entrées.
	 * 
	 * Cette méthode garde mon code DRY lors de la création de messages d'erreurs.
	 * 
	 * @param string $code     Le code d'erreur.
	 * @param string $msg      Le message d'erreur à afficher.
	 * @param string $fonction La fonction où fut causée l'erreur.
	 * @param string $version  La version de WP.
	 */
	public function afficher_msg_erreur( $code, $msg, $fonction='', $version='' )
	{
		$version = ( ! is_string( $version ) || empty( $version ) ) 
					? $this->get_version() 
					: $version;
		_doing_it_wrong( $fonction, __( $msg ), $version );
		return WP_Error( $code, __( $msg ) );
	}
	
	/**
	 * Pousse toutes les feuilles de styles requises du plugin pour le panneau d'administration.
	 */
	public function enqueue_styles()
	{
		foreach ( $this->styles as $css ) {
			wp_enqueue_style(
				$css->handle,   // Le nom de la feuille de style.
				plugin_dir_url( __FILE__ ) . $css->filepath, // Source
				$css->dependencies,    /** Dépendances des handles de style.
			                            * @see WP_Dependencies::add() */
				$this->version,   // Version
				$css->media       // Media query specification
			);
		}
		// TODO faire un wp_dequeue_style durant la désactivation.
	}
	
	/**
	 * Crée les metaboxes pour la page d'édition des éléments du post-type courant.
	 *
	 * @action admin_init
	 */
	public function add_all_meta_boxes()
	{
		foreach ($this->metaboxes as $metabox)
		{
			// S'il faut afficher le dashicon dans la metabox courante, mettre le HTML requis!
			// TODO adapter ça pour les templates.
			$dashicon_html = $metabox->show_dashicon ? '<span class="dashicons ' . $metabox->dashicon . '"></span>' : '';
			
			// Former le titre de la metabox.
			$metabox_title = '<h1>' . $dashicon_html . $metabox->title . '</h1>';
			
			// Ajouter la meta-box.
			add_meta_box(
					$metabox->id,                      // Attribut « id » dans la balise.
					$metabox_title,                    // Titre dans le header du metabox.
					array( $this, 'render_meta_box' ), // Callback qui va echo l'affichage.
					$this->post_type,                  // L'écran où est affiché le meta-box.
					$metabox->context,                 // Le contexte. ex. "side", "normal" ou "advanced".
					$metabox->priority                 // La priorité.
					// TODO Savoir si on doit inclure les callback_args.
			);
			
			// TODO faire un remove_meta_box() durant la désactivation.
		}
	}
	
	/**
	 * Retourne la liste des métadonnées assignées pour ce post-type.
	 *
	 * @return array La liste de metadatas.
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
	 * @param string $column  Le nom de la colonne.
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
	 * @return string Le numéro de version du plugin.
	 */
	function get_version()
	{
		return $this->version;
	}
}
