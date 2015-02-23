<?php

/**
 * RB_Spectacle
 * ===========
 *
 * Le contrôleur principal des spectacles.
 * 
 * TODO rendre **DRY**.
 * 
 * 
 * NOTES POUR LES SPECTACLES:
 * ajouter 2 photos a chaque spectacles ........ 
 * champs
	 * url de l'artiste   
	 * facebook de l'artiste  
	 * prix
	 * categorie (rock-alternatif, pop, seventies)
 *
 * @package RB
 */
class RB_Spectacle extends RB_Section
{
	/** @const string Le nom de la slug par défaut. */
	const SLUG_DEFAULT = 'spectacle';
	
	/** @var string Le nom de la classe à créer. */
	public $admin_class = 'RB_Spectacle_Admin';

	/**
	 * Constructeur. Fais pas mal de choses.
	 *
	 * @access public
	 * @param null|RB_Loader $loader Le loader qui va être appelé pour les hooks.
	 */
	public function __construct( RB_Loader $loader )
	{
		parent::__construct( 'spectacle', $loader ); // TODO: Change the autogenerated stub
	}

	/**
	 * Charge les dépendances du programme.
	 *
	 * Lorsqu'on crée une nouvelle
	 *
	 * @access public
	 * @see RB::load_all_dependencies
	 */
	public function load_dependencies()
	{
		// Inclure les fonctions d'administration, si on est loggé en tant qu'admin.
		// Ça va réduire le load.
		if ( $this->is_admin ) {
			/** @noinspection PhpIncludeInspection */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rb-spectacle-admin.php';
		}
	}
	
	/**
	 * Crée L'objet admin.
	 *
	 * Devra comprendre une variable « $args » qui comprends les arguments de la classe correspondante 
	 * qui hérite de RB_Admin.
	 */
	public function creer_objet_admin()
	{
		// Définir la table d'arguments.
		$args = array(
			'version' => $this->get_version(),
			'styles' => array(
				array(
					'handle' => $this->slug . 'spectacle_admin',
					'filepath' => 'css/rb-spectacle-admin.css',
				)
			),
			'scripts' => array(
				// TODO ajouter des scripts si possible.
			),
			'metaboxes' => array(
				array(
					'id' => 'rb_spectacle_infobox',
					'title' => 'Infos générales du Spectacle',
					'show_dashicon' => true,
					'callback' => 'info', // sera 'render_spectacle_info_metabox'
					'screen' => 'spectacle',
					'context' => 'normal',
					'priority' => 'high',
					
				)
			),
		);
		
		// Créer l'objet qui gère le panneau d'administration.
		$this->admin = new $this->admin_class( self::SLUG_DEFAULT, $args );
	}

	/* ################################ */
	/* DÉBUT DES FONCTIONS DE CALLBACKS */
	/* ################################ */

	/**
	 * Crée le post type `Spectacle`
	 */
	public function create_post_type()
	{
		// Déclarer les labels du post-type.
		$labels = array(
			'name'                => _x( 'Spectacles', 'Post Type General Name', '/langage' ),
			'singular_name'       => _x( 'Spectacle', 'Post Type Singular Name', '/langage' ),
			'menu_name'           => __( 'Spectacle', '/langage' ),
			'parent_item_colon'   => __( 'Parent', '/langage' ),
			'all_items'           => __( 'Tous les Spectacles', '/langage' ),
			'view_item'           => __( 'Voir les infos du Spectacle', '/langage' ),
			'add_new_item'        => __( 'Ajouter un Spectacle', '/langage' ),
			'add_new'             => __( 'Ajouter', '/langage' ),
			'edit_item'           => __( 'Éditer les infos du Spectacle', '/langage' ),
			'update_item'         => __( 'Mettre à jour les infos du Spectacle', '/langage' ),
			'search_items'        => __( 'Chercher un Spectacle', '/langage' ),
			'not_found'           => __( 'Non-trouvé', '/langage' ),
			'not_found_in_trash'  => __( 'Non-trouvé dans la corbeille', '/langage' ),
		);

		// Déclarer les arguments du rewrite pour le post-type.
		$rewrite = array(
			'slug'                => 'spectacle',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		// Déclarer les arguments principaux du post-type.
		$args = array(
			'label'               => __( 'spectacle', '/langage' ),
			'description'         => __( 'Un spectacle.', '/langage' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'taxonomies'          => array( 'category' ), // TODO être sûr s'il faut pas ajouter les "post_tags"
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25, // Sous les commentaires.
			'menu_icon'           => 'dashicons-store', // Icône bin sympa
			'can_export'          => true, // Pour faire des backups.
			'has_archive'         => true, // Eh, why not?
			'exclude_from_search' => false, // On veut être capable de les rechercher.
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'page', // C'est pas vraiment un post.
		);

		// Enregistre le post-type à l'aide de la liste d'arguments.
		register_post_type( 'spectacle', $args );
	}
}
