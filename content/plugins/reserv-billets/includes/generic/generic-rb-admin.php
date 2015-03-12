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
	
	/** @var int $count_scripts */
	static $count_scripts = 0;
	/** @var int $count_stylesheets */
	static $count_stylesheets = 0;
	
	/** @var string Le nom du post-type. */
	protected $post_type;
	
	/* --- DÉBUT DES ARGS --- */
	
	/** @var string Le numéro de version du plugin. */
	protected $version;
	
	/** @var string        La classe du dashicon à utiliser. Vide ou null si on ne veux pas de dashicon. */
	public $dashicon;
	/** @var Array{string} Les noms des colonnes à enlever de la liste d'éléments du type de post. */
	public $hide_columns;
	/** @var Array{array}  La liste des fichiers CSS à enqueue. */
	public $styles;
	/** @var Array{array}  La liste des fichiers JS à enqueue. */
	public $scripts;
	/** @var Array{array}  La liste des metadatas */
	public $metadatas;
	/** @var Array{RB_Metabox}  La liste des metaboxes. */
	public $metaboxes;
	
	/** @noinspection PhpDocSignatureInspection */
	
	/**
	 * Constructeur.
	 *
	 * Inspiré de la méthode « register_post_type() » de WordPress, cette méthode permettra
	 * une abstraction à couper le souffle! (Si, si!)
	 *
	 * TODO: Rendre ce code-là encore plus **DRY** pour les sous-sections des arguments. _(styles, metaboxes, etc.)_
	 *
	 * @param string $post_type L'identifiant du post type. Doit être sans le slug du plugin. // TODO décider s'il faut
	 *     inclure le slug.
	 * @param array  $args      {
	 *      Les arguments pour la création des options du panneau d'administration.
	 *
	 *      @type string        $version            La version du plugin.
	 *      @type string|null   $dashicon           La classe du dashicon à utiliser. Vide ou null si on ne veux pas de
	 *     dashicon.
	 *      @type array         $hide_columns       Les noms des colonnes à enlever de la liste d'éléments du type de
	 *     post.
	 *      @type array         $styles             { --- ARRAY ---
	 *          Les styles à « enqueuer » dans la section admin.
	 *
	 *          @type array [0...n] { --- ARRAY ---
	 *              Les arguments de chaque style.
	 *
	 *              @type string $handle       Le nom du handle du style. Doit être unique.
	 *              @type string $filepath     Le chemin vers le fichier CSS par rapport à la position du fichier
	 *                                         de la classe héritant de RB_Admin.
	 *                                         TODO: vérifier si ça va pogner la bonne path malgré l'héritage.
	 *              @type array  $dependencies { --- ARRAY ---
	 *                  Les dépendances.
	 *                  TODO: Documenter les dépendances.
	 *                  TODO: Implémenter les dépendances.
	 *              }
	 *              @type float  $version      La version du style.
	 *              @type string $media        Le media-query visé. Ex: 'screen'
	 *          }
	 *      }
	 *      @type array         $scripts            { --- ARRAY ---
	 *          Les scripts à « enqueuer » dans la section admin.
	 *
	 *          @type array [0...n] { --- ARRAY ---
	 *              Les arguments de chaque script.
	 *              TODO implémenter les scripts.
	 *
	 *              @type string $handle        Le nom du script.
	 *              @type string $filepath      Le chemin vers le fichier JS par rapport à la position du fichier
	 *                                          de la classe héritant de RB_Admin.
	 *                                          TODO: vérifier si ça va pogner la bonne path malgré l'héritage.
	 *              @type array $dependencies   { --- ARRAY ---
	 *                  Les dépendances.
	 *                  TODO: Documenter les dépendances.
	 *                  TODO: Implémenter les dépendances.
	 *              }
	 *              @type float $version        La version du script.
	 *              @type bool  $in_footer      Vrai si le script doit être présent dans le footer,
	 *                                          Faux s'il doit être dans le head.
	 *          }
	 *      }
	 *      @type array         $metadatas          { --- ARRAY ---
	 *          Liste des metadatas pour le type de post.
	 *
	 *          @type array [ [a-Z](1,n) ] {--- ARRAY ---
	 *              Les arguments pour chaque metadata.
	 * 
	 *              @type string       $type          Le type d'input.
	 *              @type string       $label         Le label affiché dans l'interface.
	 *              @type mixed        $default       La valeur par défaut.
	 *              @type string       $validate_cb   La fonction de callback de la validation de la metadata. Vide si
	 *     y'en a pas.
	 *              @type bool         $is_saved      Vrai si la valeur doit être sauvegardée.
	 *              @type bool         $in_columns    Vrai si la metadata doit se retrouver dans les colonnes dans le
	 *     panneau d'admin.
	 *              @type string       $is_query      Vrai si c'est une référence à une valeur ailleurs, pognée par un
	 *     WP_Query.
	 *              @type array(mixed) $metabox_query Les arguments pour le query dans la metabox.
	 *              @type array(mixed) $column_query  Les arguments pour la query dans l'affichage de la valeur dans la
	 *     colonne.
	 *          }
	 *      }
	 *      @type array         $metaboxes          { --- ARRAY ---
	 *          Liste des metaboxes pour l'édition d'un post du post-type.
	 *
	 *          @type array $[0...n] { --- ARRAY ---
	 *              Un meta-box.
	 *
	 *              @type string $id            Attribut 'ID' de l'élément HTML affiché.
	 *              @type string $title         Le titre affiché dans son header. Peut contenir du HTML.
	 *              @type bool   $show_dashicon Vrai si le Dashicon doit être affiché après le titre de la metabox.
	 *              @type string $dashicon      La classe du dashicon à afficher. Si vide, ce sera un dashicon par
	 *     défaut.
	 *              @type string $screen        L'écran où le metabox est affiché. Sera fort probablement le post_type.
	 *              @type string $context       Le contexte. ex: 'side', 'normal' ou 'advanced'
	 *              @type string $priority      La priorité. ex: 'core'
	 *          }
	 *      }
	 * }
	 * TODO: Ajouter tout le reste des arguments qu'on peut mettre.
	 *
	 * @return WP_Error|bool Vrai si ça a marché, ou un objet WP_Error sinon.
	 */
	public function __construct( $post_type, array $args )
	{
		/* -------------------------------- */
		/* ----- POST-TYPE AVANT TOUT ----- */
		/* -------------------------------- */
		
		// Vérifier si le post_type est valide.
		if ( empty( $post_type ) || strlen( $post_type ) > 20 )
		{
			// Envoyer une exception, vu qu'il faut avoir un post-type valide
			wp_die( __( __FUNCTION__.': Les noms de Post Types doivent être entre 1 et 20 caractères de longueur.' ) );
		}
		
		// Assigner le nom du post_type.
		$this->post_type = $post_type;
		
		/* ------------------------------ */
		/* ----- VALEURS PAR DÉFAUT ----- */
		/* ------------------------------ */
		
		// Valeurs par défaut dans le root.
		$defaults = array(
			'version'      => $this->get_version(),
			'dashicon'     => '',
			'hide_columns' => array( 'date' ),
			'styles'       => array(), /** @see $defaults_styles */
			'scripts'      => array(), /** @see $defaults_scripts */
			'metadatas'    => array(), /** @see $defaults_metadatas */
			'metaboxes'    => array(), /** @see $defaults_metaboxes */
		);
		
		// Valeurs par défaut des styles.
		$defaults_styles = array(
			'handle'       => null,
			'filepath'     => "css/rb_admin_default.css", // Une feuille de style par défaut, 'cuz why not!
			'dependencies' => array(),
			'version'      => 1.0,
			'media'        => 'screen',
		);
		
		// Valeurs par défaut des scripts.
		$defaults_scripts = array(
			'handle'       => null,
			'filepath'     => "js/rb_admin_default.js",
			'dependencies' => array(),
			'version'      => 1.0,
			'in_footer'    => true,
		);
		
		/* ------------------------------------------ */
		/* ----- PARSAGE DES ARGUMENTS PRIMAIRE ----- */
		/* ------------------------------------------ */
		
		// Passer les arguments par défaut à l'aide d'une fonction de WordPress. (Merci, WordPress!)
		$args = wp_parse_args( $args, $defaults ); 
		
		// Transformer l'array d'arguments en objet afin de faciliter la validation.
		$args = (object) $args;
		
		// Initialiser un compteur.
		$counter = 0;
						
		/* ---------------- */
		/* ---- STYLES ---- */
		/* ---------------- */
		
		// Instancier l'array des styles.
		$this->styles = array();
		
		// Checker si les styles ont été inclus.
		if ( !empty( $args->styles ) )
		{
			// Vérifier si la liste de styles est bien un array. (Même s'il est vide!)
			if ( !is_array( $args->styles ) )
			{
				// Envoyer une exception, vu qu'il faut des styles bien formés pour continuer.
				wp_die( __( "Les styles du panneau d'admnistration pour « ".__CLASS__." » sont mal formés!" ) );
			}
			
			// Parcourir les styles.
			foreach ( $args->styles as $style )
			{
				// Mettre les valeurs de style par défaut au style courant.
				$style = wp_parse_args( $style, $defaults_styles );
				
				// Checker si le handle ET le path ont été inclus dans le style.			
				if ( ! array_key_exists( 'handle', $style ) || ! array_key_exists( 'filepath', $style ) ) {
					// Envoyer une exception, vu qu'on a besoin d'un handle et d'un filepath obligatoirement.
					wp_die( __( "Les tables associatives de styles doivent être formées correctement." ) );
				}
				
				// Checker si les dépendences ont été inclues dans le style.
				if ( array_key_exists( 'dependencies', $style ) ) {
					// Checker si les dépendences sont vides ou non.
					if ( ! is_array( $style['dependencies'] ) || empty( $style['dependencies'] ) ) {
						// Mettre les dépendances à un array vide si elles sont pas un array rempli.
						// Notez que je n'affiche pas d'erreurs, vu que j'pas sûr quoi faire à date avec les dépendances!
						$style['dependencies'] = array();
					}
					// TODO: Implémenter les dépendances.
				} else { // Sinon mettre les dépendances du style courant à null.
					$style['dependencies'] = array();
				}
				
				// Ajouter le style.
				$this->styles[] = $style;
				
				// Ajouter 1 au compteur.
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
		
		/* ------------------- */
		/* ----- SCRIPTS ----- */
		/* ------------------- */
		
		// Instancier l'array des scripts.
		$this->scripts = array();
		
		// Vérifier si les scripts ne sont pas vides.
		if ( ! empty( $args->scripts ) )
		{
			// Vérifier si la liste de scripts est bien un array. (Même s'il est vide!)
			if ( !is_array( $args->scripts ) )
			{
				// Envoyer une exception, vu qu'il faut des scripts bien formés pour continuer.
				wp_die( __( "Les scripts du panneau d'admnistration pour « ".__CLASS__." » sont mal formés!" ) );
			}
			
			// Parcourir les scripts.
			foreach ( $args->scripts as $script )
			{
				// Mettre les valeurs de script par défaut au script courant.
				$script = wp_parse_args( $script, $defaults_scripts );
				
				// Checker si le handle ET le path ont été inclus dans le script.
				if ( !is_string( $script['handle'] ) || !is_file( $script['filepath'] ) )
				{
					// Envoyer une exception, vu qu'on a besoin d'un handle et d'un filepath obligatoirement.
					wp_die( __( "La table associative du script ".$script['id']." doit être formée correctement." ) );
				}
				
				// Checker si les dépendences sont vides ou non.
				if ( ! is_array( $script['dependencies'] ) || empty( $script['dependencies'] ) )
				{
					// Mettre les dépendances à un array vide si elles sont pas un array rempli.
					// Note: je n'affiche pas d'erreurs, vu que j'pas sûr quoi faire à date avec les dépendances!
					$script['dependencies'] = array();
					// TODO: Implémenter les dépendances.
				}
				else  // Sinon mettre les dépendances du script courant à null.
				{
					$script['dependencies'] = array();
				}
				
				// TODO effectuer le reste des validations.
				
				// Ajouter le script.
				$this->scripts[] = $script;
				
				// Ajouter 1 au compteur.
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
		
		/* ------------------- */
		/* ---- METADATAS ---- */
		/* ------------------- */
		
		// Vérifier si les metaboxes sont pas mises par défaut.
		if ( ! empty( $args->metadatas ) )
		{
			// Parcourir chaque metabox.
			foreach ( $args->metadatas as $key => $metadata_args )
			{
				// Créer l'objet RB_Metadata à l'aide des arguments.
				$metadata_args = new RB_Metadata( $metadata_args, $post_type, $key );
				
				// Ajouter la metadata.
				$this->metadatas[$key] = $metadata_args;
				
				// Incrémenter le compteur, au cas où on en a de besoin.
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
		
		/* ------------------- */
		/* ---- METABOXES ---- */
		/* ------------------- */
		
		// Instancier l'array des metaboxes.
		$this->metaboxes = array();
		
		// Vérifier si les metaboxes sont pas mises par défaut.
		if ( ! empty( $args->metaboxes ) )
		{
			// Parcourir chaque metabox.
			foreach ( $args->metaboxes as $metabox_args )
			{
				$meta_keys = null;
				
				// Checker si les metadatas sont inclus dans les paramètres.
				if ( array_key_exists( 'metadatas', $metabox_args ) )
				{
					$meta_keys = $metabox_args['metadatas'];
					unset($metabox_args['metadatas']);
				}
				
				// Créer un nouvel objet RB_Metabox.
				$metabox_obj = new RB_Metabox( $metabox_args, $post_type );
				$nb_metadatas = count( $meta_keys );
				
				if ( is_array( $meta_keys ) && $nb_metadatas > 0 )
				{
					for ( $i = 0; $i < $nb_metadatas; $i++ )
					{
						if ( array_key_exists( $meta_keys[$i], $this->metadatas ) )
						{
							/** @var RB_Metadata $metadata_instance */
							$metadata_instance = $this->metadatas[$meta_keys[$i]];
							$metabox_obj->add_metadata( $metadata_instance );
						}
					}
				}
				
				// Ajouter la metabox.
				$this->metaboxes[] = $metabox_obj;
				
				// Incrémenter le compteur, au cas où on en a de besoin.
				$counter++;
			}
		}
	}
	
	/**
	 * Affiche un message d'erreur à partir des infos entrées.
	 *
	 * Cette méthode garde mon code DRY lors de la création de messages d'erreurs.
	 *
	 * @param string $code Le code d'erreur.
	 * @param string $msg Le message d'erreur à afficher.
	 * @param string $fonction La fonction où fut causée l'erreur.
	 * @param string $version La version de WP.
	 *
	 * @deprecated
	 * @return \WP_Error
	 */
	public function afficher_msg_erreur( $code, $msg, $fonction='', $version='' )
	{
		$version = ( ! empty( $version ) && is_float( $version ) )
				? $version
				: $this->get_version();
		_doing_it_wrong( $fonction, __( $msg ), $version );
		return new WP_Error( $code, __( $msg ) );
	}
	
	/**
	 * Pousse toutes les feuilles de styles requises du plugin pour le panneau d'administration.
	 *
	 * @action admin_enqueue_styles
	 */
	public function enqueue_styles()
	{	
		foreach ( $this->styles as $style ) 
		{
			if ( WP_DEBUG_DISPLAY ) {
				var_dump( array( 'Feuile de style #' . self::$count_stylesheets, $style ) );
				self::$count_stylesheets++;
			}
			
			wp_enqueue_style(
				$style['handle'],         // Le nom de la feuille de style.
				plugin_dir_url( __FILE__ ) . $style['filepath'], // Source
				$style['dependencies'],   /** Dépendances des handles de style.
										   * @see WP_Dependencies
										   * @see WP_Dependencies::add()
										   * TODO: voir « WP_Dependencies() »
										   */
				$this->version,           // Version
				$style['media']           // Media query specification
			);
		}
		
		// TODO: faire un wp_dequeue_style durant la désactivation.
	}
	
	/**
	 * Pousse tous les scripts .js requis du plugin pour le panneau d'administration.
	 *
	 * @action admin_enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		foreach ( $this->scripts as $script ) 
		{
			if ( WP_DEBUG_DISPLAY ) {
				var_dump( array( 'Script #' . self::$count_scripts, $script ) );
				self::$count_scripts++;
			}
			
			wp_enqueue_script(
				$script['handle'],         // Le nom de la feuille de style.
				plugin_dir_url( __FILE__ ) . $script['filepath'], // Source
				$script['dependencies'],   /** Dépendances des handles de style.
											* @see WP_Dependencies
											* @see WP_Dependencies::add()
											* TODO: voir « WP_Dependencies() » 
											*/
				$this->version,             // Version
				$script['in_footer']        // Vrai si le script doit être ajouté dans le footer.
			);
		}
		
		// TODO: faire un wp_dequeue_script durant la désactivation.
	}
	
	/**
	 * Crée les metaboxes pour la page d'édition des éléments du post-type courant.
	 *
	 * @action admin_init
	 *
	 * @var RB_Metabox $metabox
	 */
	public function add_all_meta_boxes()
	{
		global $post;
		
		/** @var RB_Metabox $metabox */
		$metabox = null;
		
		// Parcourir toute les metaboxes.
		foreach ($this->metaboxes as $metabox)
		{
			// Ajouter la metabox.
			$metabox->add();
		}
	}
	
	/**
	 * Sauvegarde les données des meta-data du post.
	 *
	 * Va utiliser les données $_POST envoyées par Wordpress lors de la sauvegarde.
	 *
	 * TODO: transformer « save_custom_post » pour que ça soit compatible avec la nouvelle structure.
	 *
	 * @action save_post
	 *
	 * @param int     $post_id L'ID de la prestation.
	 * @param WP_Post $post    Une instance de la prestation.
	 * @param Bool    $update  Vrai si le post est une update.
	 */
	public final function save_custom_post( $post_id, $post, $update )
	{
		if ( $this->post_type != $post->post_type )
			return;
		
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		// TODO: effectuer la validation par NOnce.
		// $is_valid_nonce = ( isset( $_POST[ 'rb_nonce' ] ) && wp_verify_nonce( $_POST[ 'rb_nonce' ], basename( __FILE__ ) ) ) ? true : false;
		$is_valid_nonce = true;
		
		// S'en va du script dépendamment si ça passe ou non.
		if ( $is_autosave || ! $is_valid_nonce ) 
			return;
		
		// Parcourir la table des clés.
		/** @var RB_Metadata $metadata */
		foreach ( $this->metadatas as $metadata )
		{
			$key = $metadata->get_key();
			
			// Passer à la valeur suivante dans l'array si la clé est interne.
			if ( $this->key_is_internal( $key ) )
				continue;
			
			// Vérifier si la clé existe dans le $_POST.
			$metadata->update( $post_id );
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
	public final function set_post_list_columns( $columns )
	{
		$retour = array();
		
		// Enlever toutes les colonnes à enlever.
		foreach ( $this->hide_columns as $hidden_column_name )
			unset( $columns[ $hidden_column_name ] );
		
		//var_dump( $columns );
		
		// Ajouter toutes les colonnes à ajouter.
		/**
		 * @var int $key
		 * @var RB_Metadata $metadata
		 */
		foreach ( $this->metadatas as $key => $metadata )
		{
			if ( $metadata->is_in_columns() )
			{
				$retour[$key] = __( $metadata->get_key() );
			}
		}
		
		unset( $columns['date'] );
		
		return array_merge( $columns, $retour );
	}
	
	/**
	 * Afficher les colonnes personnalisés qui montrent les données
	 *
	 * TODO: transformer « display_custom_columns_data » pour que ça soit compatible avec la nouvelle structure.
	 * 
	 * @action manage_{POST-TYPE}_posts_custom_column
	 *
	 * @param string $column  Le nom de la colonne.
	 * @param int    $post_id L'ID du post courant dans la loop d'affichage de la liste.
	 */
	public final function display_custom_columns_data( $column, $post_id )
	{
		global $post;
		
		/** @var RB_Metadata $col */
		$col = $this->metadatas[$column];
		
		// Si ça doit être affiché dans les colonnes...
		if ( $col->is_in_columns() )
		{
			$meta_value = get_post_meta( $post_id, $column, true );
			if ( WP_DEBUG_DISPLAY )
				var_dump($meta_value);
			
			// Si la valeur affichée doit être une référence à une autre valeur...
			if ( $col['is_query'] ) 
			{
				
				if ( array_key_exists( 'meta_ref', $col['column_query'] ) )
				{
					$meta_ref = $col['column_query']['meta_ref'];
					
					unset( $col['column_query']['meta_ref'] );
					
					$ref = get_post( $meta_value );
				}
				
				array_merge( $col['column_query'], array(
					'meta_value' => $meta_value,
				) );
				
				// Effectuer la Query.
				$query = new WP_Query( $col['column_query'] );
				if ( $query->have_posts() ) 
				{
					$query->the_post();
					echo get_the_title();
				}
			}
			else
			{
				echo $meta_value;
			}
		}
		
		// TODO adapter aux metadatas qui font des références.
	}
	
	/**
	 * Assigne la posibilité de trier des posts par rapport aux colonnes personnalisées.
	 * 
	 * @filter manage_edit-{POST-TYPE}_sortable_columns
	 * 
	 * @param Array $columns Les colonnes déjà triables.
	 *
	 * @return Array Les colonnes triables, incluant nos colonnes personnalisées.
	 */
	public final function sort_custom_columns( $columns )
	{
		foreach ( $this->metadatas as $key => $data )
			$columns[$key] = $key;
		
		return $columns;
	}
	
	/**
	 * Ajoute la requête de triage pour chaque type.
	 *
	 * //* @filter request
	 * @action pre_get_posts
	 *
	 * @param WP_Query $query
	 *
	 * @return array L'array mergé, ou pas mergé; who knows.
	 * 
	 */
	public final function orderby_custom_columns( $query )
	{
		// Si c'est la query principale et si y'a un get de type "orderby"...
		if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) 
		{
			// Passer dans tous les metadatas qui sont affichés dans les colonnes...
			foreach ( $this->metadatas as $meta_key => $meta_object )
			{
				// Si c'est la bonne clée dans l'ordering.
				if ( $meta_key == $orderby )
				{
					// Assigner la clé de la metadata dans le query.
					$query->set( 'meta_key', $meta_key );
					
					if ( $meta_object[''] )
					{
						
					}
				}
			}
		}
	}
	
	/**
	 * Retourne vrai si le nom de clé entré est interne à Wordpress.
	 * 
	 * Check si ya un '_' au début du nom de la clé. 
	 * 
	 * @param string|int $key Le nom de la clé.
	 *
	 * @return bool Vrai si la clé est interne.
	 */
	final public function key_is_internal($key)
	{
		$keyt = trim($key);
		
		return ( $keyt{0} == '_' );
	}
	
	/**
	 * Retourne le numéro de version du plugin.
	 *
	 * @return string Le numéro de version du plugin.
	 */
	final public function get_version()
	{
		return $this->version;
	}
}
