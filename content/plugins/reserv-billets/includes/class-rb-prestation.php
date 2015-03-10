<?php

/**
 * Class RB_Prestation
 *
 * Les prestations.
 */
class RB_Prestation extends RB_Section
{
	/** @const  String Le nom de la slug par défaut. */
	const DEFAULT_SLUG = 'prestation';
	const DEFAULT_NB_BILLETS = 500;
	
	/** @var RB_Prestation_Admin L'objet d'administration du post_type Prestation. */
	public $admin;

	/**
	 * Constructeur. Fais pas mal de choses!
	 *
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct( 'prestation' );
	}

	/**
	 * Charge les dépendances du programme.
	 *
	 * Lorsqu'on crée une nouvelle
	 *
	 * @access public
	 * @see    RB::load_all_dependencies
	 */
	public function load_dependencies()
	{
		if ( $this->is_admin ) {
			/** @noinspection PhpIncludeInspection */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rb-'.$this->post_type.'-admin.php';
		}
	}
	
	/**
	 * Crée L'objet admin.
	 *
	 * Devra comprendre une variable nommée $args comprenant les arguments.
	 *
	 * @return mixed
	 */
	public function creer_objet_admin()
	{
		$default_billets = get_option('rb_billets_par_defaut', null);
		
		// Définir la table d'arguments.
		$args = array(
			'version'       => $this->get_version(),
			'dashicon'      => '',
			'hide_columns'  => array( 'date', 'author', 'comments' ),
			'styles'        => array( // Les styles
				array( // Un style par défaut.
					'handle'   => $this->slug . 'prestation_admin',
					'filepath' => 'css/rb-prestation-admin.css',
				)
			),
			'scripts' => array( // Les scripts.
				// TODO ajouter des scripts si possible.
			),
			'metadatas' => array( // Les Metadatas.
				'rb_prestation_spectacle_id' => array( // L'ID du spectacle relié.
					'label'          => 'Spectacle',
					'default'        => '0',
					'in_columns'     => true,
					'is_query'       => true,
					'render_cb'      => array($this, 'render_rb_prestation_spectacle_id'),
				),
				'rb_prestation_date' => array( // La date.
					'label'      => 'Date',
					'default'    => date("dd-MM-yyyy"),
					'in_columns' => true,
					'render_cb'  => array($this, 'render_rb_prestation_date'),
				),
				'rb_prestation_heure' => array( // L'heure.
					'label'      => 'Heure',
					'default'    => '19:00',
					'in_columns' => true,
					'render_cb'  => array($this, 'render_rb_prestation_heure'),
				),
				'rb_prestation_nb_billets' => array( // Le nombre de billets restants.
					'label'      => 'Billets restants',
					'default'    => is_null($default_billets) 
									? /*TRUE:*/  self::DEFAULT_NB_BILLETS 
									: /*FALSE:*/ $default_billets,
					'in_columns' => true,
					'render_cb'  => array($this, 'render_rb_prestation_nb_billets'),
				),
			),
			'metaboxes' => array(
				array( // La metabox générale.
					'id'            => 'rb_prestation_general',
					'title'         => 'Infos générales de la Prestation',
					'show_dashicon' => true,
					'screen'        => 'prestation',
					'context'       => 'normal',
					'priority'      => 'high',
					'metadatas'     => [ 'rb_prestation_spectacle_id', 'rb_prestation_date', 'rb_prestation_heure' ],
				),
				array( // La metabox des billets.
					'id'            => 'rb_prestation_billets',
					'title'         => 'Nb de billets restants',
					'show_dashicon' => true,
					'dashicon'      => 'tickets-alt',
					'screen'        => 'prestation',
					'context'       => 'side',
					'priority'      => 'low',
					'metadatas'     => [ 'rb_prestation_nb_billets' ],
				)
			),
		);
		
		$nomClasse = __CLASS__."_Admin";
		
		// Créer l'objet qui gère le panneau d'administration.
		return new $nomClasse( $this->post_type, $args );
	}

	/**
	 * Définit les hooks spécifiques au panneau d'administration des Prestations.
	 *
	 * @access  protected
	 * @see     RB::define_all_admin_hooks
	 */
	protected function define_other_hooks()
	{
		// Ajoutez c'que vous voulez là !
	}

	/**
	 * Crée le post-type.
	 */
	public function create_post_type()
	{
		// Déclarer les labels du post-type.
		$labels = array(
			'name'                => _x( 'Prestations', 'Post Type General Name', '/langage' ),
			'singular_name'       => _x( 'Prestation', 'Post Type Singular Name', '/langage' ),
			'menu_name'           => __( 'Prestation', '/langage' ),
			'parent_item_colon'   => __( 'Faisant parti du Spectacle: ', '/langage' ),
			'all_items'           => __( 'Toutes les Prestations', '/langage' ),
			'view_item'           => __( 'Voir Prestation', '/langage' ),
			'add_new_item'        => __( 'Ajouter une Prestation', '/langage' ),
			'add_new'             => __( 'Ajouter', '/langage' ),
			'edit_item'           => __( 'Éditer les infos de la Prestation', '/langage' ),
			'update_item'         => __( 'Mettre à jour les infos de la Prestation', '/langage' ),
			'search_items'        => __( 'Chercher une Prestation', '/langage' ),
			'not_found'           => __( 'Non-trouvé', '/langage' ),
			'not_found_in_trash'  => __( 'Non-trouvé dans la corbeille', '/langage' ),
		);

		// Déclarer les arguments du rewrite pour le post-type.
		$rewrite = array(
			'slug'                => 'prestation',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		// Déclarer les arguments principaux du post-type.
		$args = array(
			'label'               => __( 'prestation', '/langage' ),
			'description'         => __( 'Une prestation.', '/langage' ),
			'labels'              => $labels,
			'supports'            => array( '' ),
			'taxonomies'          => array( '' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25, // Sous les commentaires.
			'menu_icon'           => 'dashicons-tickets-alt', // Icône bin sympa
			'can_export'          => true, // Pour faire des backups.
			'has_archive'         => true, // Eh, why not?
			'exclude_from_search' => true, // On veut PAS être capable de les rechercher.
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post', // C'est pas vraiment un post.
		);

		// Enregistre le post-type à l'aide de la liste d'arguments.
		register_post_type( 'prestation', $args );
	}
	
	/**
	 * render_rb_prestation_spectacle_id
	 * 
	 * @param int         $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_prestation_spectacle_id( $post_id, $metadata )
	{
		global $post;
		
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$posts = get_posts(array(
			'post_type'      => 'spectacle',
            'posts_per_page' => '-1',
        ));
		
		if ( ! empty( $posts ) ) 
		{
			$retour = "<select name='" . $metadata->get_key() . "' id='" . $metadata->get_key() . "'>\n";
			
			/** @var WP_Post $post */
			foreach ($posts as $post) 
			{
				$retour .= '<option value="'.$post->ID.'" '.selected($post->ID, $valeur, false).' >'
				           .$post->post_title.'</option>';
			}
			
			$retour .= "</select>\n";
		}
		else
		{
			$retour = "<p>Aucun spectacle trouvé.</p>";
		}
		
		return $retour;
	}
	
	/**
	 * render_rb_prestation_date
	 * 
	 * @param int         $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_prestation_date( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="date" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" value="' . $valeur . '" />';
		
		return $retour;
	}
	
	/**
	 * render_rb_prestation_heure
	 * 
	 * @param int         $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_prestation_heure( $post_id, $metadata )
	{
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="time" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" value="' . $valeur . '" />';
		
		return $retour;
	}
	
	/**
	 * render_rb_prestation_nb_billets
	 * 
	 * @param int         $post_id
	 * @param RB_Metadata $metadata
	 *
	 * @return string
	 */
	public function render_rb_prestation_nb_billets( $post_id, $metadata ) {
		$valeur = get_post_meta( $post_id, $metadata->get_key(), true );
		$retour = '<input type="number" id="' . $metadata->get_key() . '" name="' . $metadata->get_key() . '" value="' . $valeur . '" />';
		
		// TODO changer ça.
		
		return $retour;
	}
}
