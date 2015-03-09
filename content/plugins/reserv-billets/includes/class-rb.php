<?php

/**
 * RB_Spectacle
 * ===========
 *
 * Le contrôleur principal de tous les éléments.
 *
 * @package RB
 */
class RB
{
	/** @const String Le nom de la slug par défaut. */
	const SLUG_DEFAULT = 'rb-slug';

	/** @var RB_Loader Le loader de l'élément. */
	protected $loader;

	/** @var Array[RB_Section] La liste des instances des classes de chaque section. */
	protected $sections;

	/** @var String L'identifiant de la slug */
	protected $slug;

	/** @var String Le numéro de version. Pas sûr de garder ça longtemps. */
	protected $version;

	/** @var bool Détermine si l'utilisateur est admin. */
	protected $is_admin;

	/**
	 * Constructeur. Fais pas mal de choses.
	 *
	 * @param String|null $custom_slug Le nom du slug, si on en veut un différent
	 *                                 de celui par défaut.
	 */
	public function __construct($custom_slug = NULL)
	{
		// Définir le nom de la slug, pour les URLs.
		$this->slug = (is_null($custom_slug) ? self::SLUG_DEFAULT : $custom_slug);

		// Définir le numéro de version. (À changer de temps en temps)
		$this->version = '0.4.0';

		// Définir la valeur de is_admin afin de ne pas à la re-vérifier tout le temps.
		// (Réduit le temps de chargement; Chaque seconde compte, ti-gars!)
		$this->is_admin = is_admin();

		// Charger les dépendances dans la mémoire, dont les sous-classes Admin et Loader.
		$this->load_all_dependencies();

		$this->define_hooks();
	}

	/**
	 * Charge les dépendances du programme.
	 *
	 * Lorsqu'on crée une nouvelle
	 *
	 * @see RB_Spectacle_Admin
	 */
	private function load_all_dependencies()
	{
		// Pogner les classes abstraites.
		require_once 'generic/generic-rb-section.php'; // RB_Section
		require_once 'generic/generic-rb-admin.php'; // RB_Admin

		// Créer le Loader.
		try {
			require_once 'class-rb-loader.php'; // RB_Loader
			$this->loader = new RB_Loader( $this->get_version() );
			
			// Inclure la classe RB_Metadata.
			require_once 'class-rb-metadata.php';
			
			// Inclure l'interface « Interface_RB_Metabox ».
			require_once 'interfaces/interface-rb-metabox.php';
			// Inclure la classe « RB_Metabox ».
			require_once 'class-rb-metabox.php';
			
			// Inclure la classe « RB_Spectacle ».
			require_once 'class-rb-spectacle.php';
			// Créer l'objet « RB_Spectacle ».
			$this->sections['spectacle'] = new RB_Spectacle( $this->loader );
			
			// Inclure la classe « RB_Prestation ».
			require_once 'class-rb-prestation.php';
			// Créer l'objet « RB_Prestation ».
			$this->sections['prestation'] = new RB_Prestation( $this->loader );
		} 
		catch (Exception $e)
		{
			printf($e);
		}
	}

	/**
	 * Définit tous les hooks globaux.
	 */
	protected function define_hooks()
	{
		RB_Loader::queue_action( 'post_edit_form_tag', $this, 'update_edit_form');
	}
	
	/**
	 * Echo le type d'encodage dans le form.
	 * 
	 * @action post_edit_form_tag
	 */
	function update_edit_form() 
	{
		echo ' enctype="multipart/form-data"';
	}

	/**
	 * Retourne la version du plugin.
	 *
	 * @see RB_Spectacle::__construct()
	 *
	 * @return String La version du plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	/**
	 * Fait battre la classe de ses propres ailes, tel un ange!
	 * ♩ ♩ ♫ Aaaaaleluia~!!! (bis) ♫ ♩ ♫
	 *
	 * ...plus sérieusement, ça exécute cette partie du plugin, en appelant les instructions
	 * d'exécution du loader.
	 */
	public function run()
	{
		RB_Loader::run();
	}
}
