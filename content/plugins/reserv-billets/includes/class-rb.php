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
	/** @var Array[RB_Section] La liste des instances des classes de chaque section. */
	protected $sections;

	/** @var String Le numéro de version. Pas sûr de garder ça longtemps. */
	protected $version;

	/** @var bool Détermine si l'utilisateur est admin. */
	public static $is_admin;

	/**
	 * Constructeur. Fais pas mal de choses.
	 */
	public function __construct()
	{
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
			// Inclure les interfaces.
			foreach (glob("interfaces/*.php") as $filename) {
				/** @noinspection PhpIncludeInspection */
				require_once $filename;
			}
			
			// Inclure le loader statique.
			// Puisqu'il est utilisé dans un contexte statique, pas besoin de créer d'instance!
			require_once 'class-rb-loader.php';
			
			// Inclure la classe RB_Metadata.
			require_once 'class-rb-metadata.php';
			
			// Inclure la classe « RB_Metabox ».
			require_once 'class-rb-metabox.php';
			
			// Inclure tout ce qui se trouve dans le dossier « prestation »
			foreach (glob("prestation/*.php") as $filename)
				/** @noinspection PhpIncludeInspection */
				require_once $filename;
			
			// Inclure tout ce qui se trouve dans le dossier « prestation »
			foreach (glob("spectacle/*.php") as $filename)
				/** @noinspection PhpIncludeInspection */
				require_once $filename;
			
			// Inclure la classe « RB_Spectacle ».
			require_once 'class-rb-spectacle.php';
			// Créer l'objet « RB_Spectacle ».
			$this->sections['spectacle'] = new RB_Spectacle();
			
			// Inclure la classe « RB_Prestation ».
			require_once 'class-rb-prestation.php';
			// Créer l'objet « RB_Prestation ».
			$this->sections['prestation'] = new RB_Prestation();
		} 
		catch (Exception $e) // Si y'a une exception, 
		{
			wp_die( "Erreur non-trouvée." );
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
