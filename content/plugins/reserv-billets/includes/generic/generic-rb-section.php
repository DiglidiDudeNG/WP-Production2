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
	const SLUG_DEFAULT = 'rb-x-slug';
	
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
	 * > NOTE DE FÉLIX: <br />
	 * > C't'une pas pire de bonne idée d'inspecter le code pour cte fonction-là!
	 *
	 * @access public
	 *
	 * @param string         $post_type Le nom du post-type.
	 * @param null|RB_Loader $loader Le loader qui va être appelé pour les hooks.
	 */
	public function __construct( $post_type, RB_Loader $loader )
	{
		// Définir le nom de la slug, pour les URLs.
		$this->slug = self::SLUG_DEFAULT;

		// Définir le numéro de version. (À changer de temps en temps)
		$this->version = '0.6.5';
		
		// Définir le post-type.
		$this->post_type = $post_type;

		// Définir la valeur de is_admin afin de ne pas à la re-vérifier tout le temps.
		// (Réduit le temps de chargement; Chaque seconde compte, ti-gars!)
		$this->is_admin = is_admin();

		// Charger les dépendances dans la mémoire, dont les sous-classes Admin et Loader.
		$this->load_dependencies();

		// Définir tous les hooks.
		$this->define_hooks($loader);
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
	protected function define_hooks( RB_Loader $loader )
	{
		// Création du Custom post-type
		$loader->queue_action( 'init', $this, 'create_post_type' );
		
		// Utiliser les hooks du panneau d'administration.
		if ($this->is_admin) {
			
			if ($this->admin === null)
			{
				$this->admin = $this->creer_objet_admin();
			}
			
			// Ajouter les actions du panneau d'admin à la queue d'action du composant loader.
			$loader->queue_action( 'admin_enqueue_styles', $this->admin, 'enqueue_styles' );

			$loader->queue_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_scripts' );
			
			$loader->queue_action( 'admin_init', $this->admin, 'add_all_meta_boxes' );
			
			$loader->queue_action( 'save_post', $this->admin, 'save_custom_post', 10, 2 );
			
			$loader->queue_filter( 'manage_'.$this->post_type.'_posts_columns', $this->admin, 'set_post_list_columns', 10, 1 );
			
			$loader->queue_action( 'manage_'.$this->post_type.'_posts_custom_column', $this->admin, 'display_custom_columns_data', 10, 2 );
			
			$loader->queue_filter( 'manage_edit-'.$this->post_type.'_sortable_columns', $this->admin, 'sort_custom_columns' );
			
			$loader->queue_filter( 'request', $this->admin, 'orderby_custom_columns' );
		}
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
	 * Crée L'objet admin.
	 * 
	 * Devra comprendre une variable nommée Args
	 *
	 * @return mixed
	 */
	abstract public function creer_objet_admin();
}
