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
	
	/** @var string La classe pour le dashicon. */
	public $dashicon;
	/** @var Array{array} La liste des fichiers CSS à enqueue. */
	public $styles;
	/** @var Array{array} La liste des fichiers JS à enqueue. */
	public $scripts;
	/** @var Array{array} La liste des metadatas */
	public $metadatas;
	/** @var Array{array} La liste des metaboxes. */
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
	 *          Les metadatas pour le type de post.
	 *
	 *          @type array [0...n] {--- ARRAY ---
	 *              Les arguments pour chaque metadata.
	 *              TODO implémenter les argumnets de chaque script.
	 *
	 *              @type string
	 *          }
	 *      }
	 *      @type array         $metaboxes          { --- ARRAY ---
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
		
		if ( WP_DEBUG_DISPLAY )
			var_dump($post_type);
		
		// Vérifier si le post_type est valide.
		if ( empty( $post_type ) || strlen( $post_type ) > 20 )
		{
			// Envoyer une exception, vu qu'il faut avoir un post-type valide
			// TODO: Mettre la bonne version de WP.
			return $this->afficher_msg_erreur( 'rb_admin_post_type_length_invalid',
			                                   'Les noms de Post Types doivent être entre 1 et 20 caractères de longueur.', __FUNCTION__ );
		}
		// TODO: Trouver un moyen efficace de faire la vérification de la création du post_type.
		//elseif ( ! post_type_exists( $post_type ) ) // Sinon vérifier si le post_type existe.
		//{
		//	// Envoyer une exception, vu qu'il faut avoir un post-type déjà enregistré afin de styler son administration.
		//	// TODO: Mettre la bonne version de WP.
		//	return $this->afficher_msg_erreur( 'rb_admin_post_type_undefined',
		//	                                   "Les post types doivent exister avant de définir leurs options du panneau d'admin.", __FUNCTION__ );
		//}
		
		// Assigner le nom du post_type.
		$this->post_type = $post_type;
		
		/* ------------------------------ */
		/* ----- VALEURS PAR DÉFAUT ----- */
		/* ------------------------------ */
		
		// Valeurs par défaut dans le root.
		$defaults = array(
			'version'   => $wp_version,
			'dashicon'  => '',
			'styles'    => array(), /** @see $defaults_styles */
			'scripts'   => array(), /** @see $defaults_scripts */
			'metaboxes' => array(), /** @see $defaults_metaboxes */
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
		
		// Valeurs par défaut des métadonnées.
		$defaults_metadatas = array(
			'' => '',
		);
		
		// Valeurs par défaut des metaboxes.
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
				// TODO: Mettre la bonne version de WP.
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
					// TODO: Mettre la bonne version de WP.
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
				// TODO: Mettre la bonne version de WP.
				wp_die( __( "Les scripts du panneau d'admnistration pour « ".__CLASS__." » sont mal formés!" ) );
			}
			
			// Parcourir les scripts.
			foreach ( $args->scripts as $script )
			{
				// Mettre les valeurs de script par défaut au script courant.
				$script = wp_parse_args( $script, $defaults_scripts );
				
				// Checker si le handle ET le path ont été inclus dans le script.			
				if ( ! array_key_exists( 'handle', $script ) || ! array_key_exists( 'filepath', $script ) ) {
					// Envoyer une exception, vu qu'on a besoin d'un handle et d'un filepath obligatoirement.
					// TODO: Mettre la bonne version de WP.
					wp_die( __( "Les tables associatives de scripts doivent être formées correctement." ) );
				}
				
				// Checker si les dépendences ont été inclues dans le script.
				if ( array_key_exists( 'dependencies', $script ) ) {
					// Checker si les dépendences sont vides ou non.
					if ( ! is_array( $script['dependencies'] ) || empty( $script['dependencies'] ) ) {
						// Mettre les dépendances à un array vide si elles sont pas un array rempli.
						// Notez que je n'affiche pas d'erreurs, vu que j'pas sûr quoi faire à date avec les dépendances!
						$script['dependencies'] = array();
					}
					// TODO: Implémenter les dépendances.
				} else { // Sinon mettre les dépendances du script courant à null.
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
		
		// Instancier l'array des metadatas.
		$this->metadatas = array();
		
		// Vérifier si les metaboxes sont pas mises par défaut.
		if ( ! empty( $args->metadatas ) )
		{
			// Parcourir chaque metabox.
			foreach ( $args->metadatas as $metadata )
			{
				// Mettre les valeurs de style par défaut au style courant.
				$metadata = wp_parse_args( $metadata, $defaults_metadatas );
				
				// Vérifier si l'id existe.
				if ( empty( $metadata['id'] ) )
				{
					// Si c'est pas un array, on affiche un msg d'erreur.
					wp_die( __( "Les tables associatives des metadatas doivent être formées correctement." ) );
				}
				
				// Vérifier si le name est une string et qu'il n'est pas vide.
				if ( ! array_key_exists( 'name', $metadata ) || ! is_string( $metadata['name'] )  )
				{
					// Si c'est pas un name valide, on affiche un message d'erreur.
					wp_die( __( "Un des noms de vos metadatas doit être formé correctement." ) );
				}
				
				// TODO effectuer le reste des validations.
				
				// Ajouter la metadata.
				$this->metadatas[] = $metadata;
				
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
			foreach ( $args->metaboxes as $metabox )
			{
				$metabox = wp_parse_args( $metabox, $defaults_metaboxes );
				
				// Vérifier si l'id existe.
				if ( empty( $metabox['id'] ) )
				{
					// Si c'est pas un array, on affiche un msg d'erreur.
					wp_die( __( "Les tables associatives des metaboxes doivent être formées correctement." ) );
				}
				
				// Vérifier si le title est une string et qu'il n'est pas vide.
				// TODO: Probablement assigner un template pour les titles, vu que c'est essentiellement composé de HTML.
				if ( ! array_key_exists( 'title', $metabox ) || ! is_string( $metabox['title'] )  )
				{
					// Si c'est pas un title valide, on affiche un message d'erreur.
					wp_die( __( "Le titre de vos metaboxes doivent être formés correctement." ) );
				}
				
				// TODO effectuer le reste des validations.
				
				// Ajouter la metabox.
				$this->metaboxes[] = $metabox;
				
				// Incrémenter le compteur, au cas où on en a de besoin.
				$counter++;
			}
			
			// Réinitialiser le compteur.
			$counter = 0;
		}
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
	 * 
	 * @deprecated
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
		if ( WP_DEBUG_DISPLAY )
			var_dump($this->styles);
		
		foreach ( $this->styles as $style ) {
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
		if ( WP_DEBUG_DISPLAY )
			var_dump($this->scripts);
		
		foreach ( $this->scripts as $script ) {
			wp_enqueue_script(
				$script['handle'],         // Le nom de la feuille de style.
				plugin_dir_url( __FILE__ ) . $script['filepath'], // Source
				$script['dependencies'],   /** Dépendances des handles de style.
			                                * @see WP_Dependencies
			                                * @see WP_Dependencies::add()
			                                * TODO: voir « WP_Dependencies() » 
			                                */
				$this->version,         // Version
				$script['in_footer']    // Vrai si le script doit être ajouté dans le footer.
			);
		}
		
		// TODO: faire un wp_dequeue_script durant la désactivation.
	}
	
	/**
	 * Crée les metaboxes pour la page d'édition des éléments du post-type courant.
	 *
	 * @action admin_init
	 */
	public function add_all_meta_boxes()
	{
		if ( WP_DEBUG_DISPLAY )
			var_dump($this->metaboxes);
		
		foreach ($this->metaboxes as $metabox)
		{
			// S'il faut afficher le dashicon dans la metabox courante, mettre le HTML requis!
			// TODO: adapter ça pour les templates.
			$dashicon_html = $metabox['show_dashicon'] ? '<span class="dashicons ' . $metabox['dashicon'] . '"></span>' : '';
			
			// Former le titre de la metabox.
			$metabox_title = '<h1>' . $metabox['title'] . $dashicon_html . '</h1>';
			
			// Définir le nom de la fonction de callback.
			$metabox_callback = sprintf( 'render_%s_metabox', $metabox['callback'] );
			
			// Ajouter la meta-box.
			add_meta_box(
				$metabox['id'],                    // Attribut « id » dans la balise.
				$metabox_title,                    // Titre dans le header du metabox.
				array( $this, $metabox_callback ), // Callback qui va echo l'affichage.
				$this->post_type,                  // L'écran où est affiché le meta-box.
				$metabox['context'],               // Le contexte. ex. "side", "normal" ou "advanced".
				$metabox['priority']               // La priorité.
				// TODO: Savoir si on doit inclure les callback_args.
			);
			
			// TODO: faire un remove_meta_box() durant la désactivation.
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
	 * Effectue un rendu de la metabox des informations.
	 *
	 * @param WP_Post $prestation
	 */
	public function render_info_metabox( $post )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) ) 
			return;
		
		if ( function_exists('render_'.$this->post_type.'_info_metabox' ) );
			return call_user_func( array( $this, 'render_'.$this->post_type.'_info_metabox' ), $post );
		
		// Pogner toutes les metadonnées.
		$post_metas = get_post_meta( $post->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY )
			var_dump( $post_metas );
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
	 */
	public function save_custom_post( $post_id, $post )
	{
		global $wpdb;
		
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		// TODO: effectuer la validation par NOnce.
		// $is_valid_nonce = ( isset( $_POST[ 'rb_nonce' ] ) && wp_verify_nonce( $_POST[ 'rb_nonce' ], basename( __FILE__ ) ) ) ? true : false;
		$is_valid_nonce = true;
		
		// Appeler une fonction similaire dans l'enfant si celle-ci existe.
		// Ex: « save_prestation »
		if ( function_exists('save_'.$this->post_type ) );
			return call_user_func( array( $this, 'save_'.$this->post_type ), $post_id, $post );
		
		// S'en va du script dépendamment si ça passe ou non.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}
		
		// Checker si on a toutes les valeurs requises.
		
		// Pogner toutes les clés du post.
		$custom_keys = get_post_custom_keys($post_id);
		
		// Parcourir la table des clés.
		foreach ( $custom_keys as $key )
		{
			// Vérifier si la clé est interne.
			if ( key_is_internal( $key ) )
			{
				continue;
			} // Passer à la valeur suivante dans ce cas-là.
			
			// Vérifier si la clé existe dans le $_POST.
			if ( array_key_exists( $key, $_POST ) )
			{
				// Déclarer la variable de validation à Vrai.
				$valide = true;
				
				// Vérfier si la fonction de validation n'est pas vide...
				if ( ! empty( $this->metadatas[ $key ]['validate_fn'] ) )
				{
					// ...et si la fonction existe.
					if ( function_exists( $this->metadatas[ $key ]['validate_fn'] ) )
					{
						// Valider la donnée.
						if ( call_user_func( array( $this, $this->metadatas[ $key ] ), $data ) )
							// Mettre à jour la valeur de la metadata avec celle du $_POST.
							update_post_meta( $post_id, $key, $_POST[$key] );
						else // Si la fonction a retournée FAUX.
							// Retourner une erreur.
							wp_die( __( "La validation de la donnée" . $key . "a échouée !" ) );
					}
					else // Si la fonction n'existe pas.
					{
						// Retourner une erreur.						
						wp_die( __( "La fonction de validation pour " . $key . " n'existe pas !" ) );
					}
				}
				elseif ( ! empty( $_POST[ $key ] ) ) // Sinon si la valeur de la clé dans $_POST n'est pas vide.
				{
					// Mettre à jour la valeur de la metadata avec celle du $_POST.
					update_post_meta( $post_id, $key, $_POST[$key] );
				}
				else
				{ // Dans le cas échéant.
					wp_die( __( "La valeur de la clé " . $key . " était vide !" ) );
				}
				
				// Si non-valide, retourner.
				if ( ! $valide ) return;
			}
		}
		
		do_action( 'rb_'.$this->post_type.'_metas_saved' );
	}
	
	/**
	 * Modifie les colonnes affichées dans la liste de prestations sur le panneau d'admin.
	 *
	 * TODO: transformer « set_post_list_columns » pour que ça soit compatible avec la nouvelle structure.
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
	 * TODO: transformer « display_custom_columns_data » pour que ça soit compatible avec la nouvelle structure.
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
				} 
				else // Afficher le titre du spectacle.
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
	 * TODO: transformer « sort_custom_columns » pour que ça soit compatible avec la nouvelle structure.
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
	 * TODO: transformer « orderby_custom_columns » pour que ça soit compatible avec la nouvelle structure.
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
	 * Retourne vrai si le nom de clé entré est interne à Wordpress.
	 * 
	 * Check si ya un '_' au début du nom de la clé. 
	 * 
	 * @param $key Le nom de la clé.
	 *
	 * @return bool Vrai si la clé est interne.
	 */
	function key_is_internal($key)
	{
		$keyt = trim($key);
		return ( $keyt{0} == '_' );
	}
	
	/**
	 * Pogne le custom field depuis la boucle.
	 *
	 * TODO: meilleur doc pour get_custom_field
	 * TODO: transformer « get_custom_field » pour que ça soit compatible avec la nouvelle structure.
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
	public final function get_version()
	{
		return $this->version;
	}
}
