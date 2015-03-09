<?php

/**
 * Class RB_Section
 *
 * Classe Générique pour chacun des modules du plugin.
 * Donne pas mal tout ce qu'un module aura de besoin.
 */
abstract class RB_Section
{
	/** @const String Le nom de la slug par défaut. */
	const DEFAULT_SLUG = 'rb-x-slug';
	
	/** @var String Le nom du post-type. */
	public $post_type;

	/** @var String L'identifiant de la slug */
	protected $slug;

	/** @var String Le numéro de version. Pas sûr de garder ça longtemps. */
	protected $version;
	
	/** @var RB_Admin L'objet d'administration du post_type Prestation. */
	public $admin;

	/** @var bool Détermine si l'utilisateur est admin. */
	protected $is_admin;
	
	/**
	 * Constructeur. Fais pas mal de choses!
	 *
	 * @access public
	 *
	 * @param string         $post_type Le nom du post-type.
	 * @param null|RB_Loader $loader Le loader qui va être appelé pour les hooks.
	 */
	public function __construct( $post_type )
	{
		// Définir le nom de la slug, pour les URLs.
		$this->slug = self::DEFAULT_SLUG;

		// Définir le numéro de version. (À changer de temps en temps)
		$this->version = '0.8.0';
		
		// Définir le post-type.
		$this->post_type = $post_type;

		// Définir la valeur de is_admin afin de ne pas à la re-vérifier tout le temps.
		// (Réduit le temps de chargement; Chaque seconde compte, ti-gars!)
		$this->is_admin = is_admin();
		
		// Charger les dépendances dans la mémoire, dont les sous-classes Admin et Loader.
		$this->load_dependencies();

		// Définir tous les hooks.
		$this->define_hooks();
	}

	/**
	 * Charge les dépendances du programme.
	 *
	 * Lorsqu'on crée une nouvelle
	 *
	 * @access public
	 * @see RB::load_all_dependencies
	 */
	abstract public function load_dependencies();
	
	/**
	 * Définit tous les hooks de la fonction
	 *
	 * @param \RB_Loader $loader
	 */
	protected function define_hooks()
	{
		// Création du Custom post-type
		RB_Loader::queue_action( 'init', $this, 'create_post_type' );
		
		// Utiliser les hooks du panneau d'administration.
		if ($this->is_admin) {
			
			// Si l'objet admin n'a pas été créé
			if ( !is_object( $this->admin ) )
				$this->admin = $this->creer_objet_admin();
			
			// L'ajout des styles.
			RB_Loader::queue_action( 'admin_enqueue_styles', $this->admin, 'enqueue_styles' );

			// L'ajout des scripts.
			RB_Loader::queue_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_scripts' );
			
			// L'ajout des metaboxes.
			RB_Loader::queue_action( 'admin_init', $this->admin, 'add_all_meta_boxes' );
			
			// La sauvegarde du post.
			RB_Loader::queue_action( 'save_post', $this->admin, 'save_custom_post', 10, 3 );
			
			// Gérer les colonnes.
			// TODO DÉCOMMENTER
			//RB_Loader::queue_filter( 'manage_'.$this->post_type.'_posts_columns', $this->admin, 'set_post_list_columns', 10, 1 );
			//
			//RB_Loader::queue_action( 'manage_'.$this->post_type.'_posts_custom_column', $this->admin, 'display_custom_columns_data', 10, 2 );
			//
			//RB_Loader::queue_filter( 'manage_edit-'.$this->post_type.'_sortable_columns', $this->admin, 'sort_custom_columns' );
			//
			//RB_Loader::queue_action( 'pre_get_posts', $this->admin, 'orderby_custom_columns', 10, 1 );
			// TODO FIN DÉCOMMENTER
			
			//RB_Loader::queue_filter( 'posts_clauses', $this->admin, 'advanced_orderby_columns', 10, 2 );
			
			//RB_Loader::queue_filter( 'request', $this->admin, 'orderby_custom_columns' );
			
			RB_Loader::queue_action( 'post_edit_form_tag', $this, 'include_post_form_enctype' );
			
			// Permettre d'ajouter des hooks personnalisés pour la classe enfant.
			if ( function_exists( 'define_{$this->post_type}_admin_hooks' ) )
				call_user_func( array( $this, 'define_{$this->post_type}_admin_hooks' ) );
		}
		
		$this->define_other_hooks();
	}
	
	/**
	 * Retourne la version du plugin.
	 *
	 * @access public
	 * @see RB_Spectacle::__construct()
	 * @see RB_Spectacle::define_admin_hooks()
	 *
	 * @return String La version du plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
	
	/**
	 * Inclus le type d'encodage pour le formulaire d'édition de post.
	 * 
	 * @action post_edit_form_tag
	 */
	public function include_post_form_enctype()
	{
		// TODO être sûr que ça soit pas une mauvaise idée.
		echo ' enctype="multipart/form-data"';
	}
	
	/**
	 * Crée L'objet admin.
	 * 
	 * Devra comprendre une variable nommée $args avec la structure vue dans RB_Admin.
	 *
	 * @return mixed
	 */
	abstract public function creer_objet_admin();
	
	/**
	 * 
	 * Est là au cas où on a besoin d'autres hooks que ceux de la classe parent.
	 * 
	 * @param \RB_Loader $loader
	 */
	abstract protected function define_other_hooks();
}
