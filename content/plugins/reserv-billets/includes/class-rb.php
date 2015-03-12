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
	/** @var Array{RB_Section} La liste des instances des classes de chaque section. */
	protected $sections;

	/** @var String Le numéro de version. Pas sûr de garder ça longtemps. */
	protected $version;

	/** @var bool Détermine si l'utilisateur est admin. */
	public static $is_admin;

	/**
	 * Constructeur.
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
	 * @see RB_Spectacle_Admin
	 */
	private function load_all_dependencies()
	{
		// Créer le Loader.
		try {
			// Inclure la classe RB_Metadata.
			require_once 'class-rb-metadata.php';
			
			// Inclure la classe « RB_Metabox ».
			require_once 'class-rb-metabox.php';
			
			// Inclure les classes génériques (abstraites).
			$this->include_dir("generic");
			
			// Inclure le loader statique.
			// Puisqu'il est utilisé dans un contexte statique, pas besoin de créer d'instance!
			require_once 'class-rb-loader.php';
			
			// Inclure les classes de gestion des settings.
			$this->include_dir('settings');
			
			// Inclure tout ce qui se trouve dans le dossier « spectacle »
			$this->include_dir("spectacle");
			$this->include_dir("spectacle/metadatas");
			$this->include_dir("spectacle/metaboxes");
			
			// Inclure tout ce qui se trouve dans le dossier « prestation »
			$this->include_dir("prestation");
			$this->include_dir("prestation/metadatas");
			$this->include_dir("prestation/metaboxes");
			
			// Inclure la classe « RB_Spectacle ».
			require_once 'class-rb-spectacle.php';
			// Créer l'objet « RB_Spectacle ».
			$this->sections['spectacle'] = new RB_Spectacle("spectacle");
			
			// Inclure la classe « RB_Prestation ».
			require_once 'class-rb-prestation.php';
			// Créer l'objet « RB_Prestation ».
			$this->sections['prestation'] = new RB_Prestation("prestation");
		} 
		catch (Exception $e) // Si y'a une exception, 
		{
			wp_die( var_export($e) );
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
	 * Echo le type d'encodage.
	 * 
	 * Utilisé surtout dans les formulaires.
	 * 
	 * @action post_edit_form_tag
	 */
	public function update_edit_form()
	{
		echo ' enctype="multipart/form-data"';
	}
	
	/**
	 * Inclues tous les fichiers dans un path.
	 *
	 * @param String $path       La destination relative vers le dossier où pognera les fichiers PHP à inclure.
	 * @param string $rootfolder Le dossier parent par rapport à la racine du plugin.
	 *
	 * @throws \Exception Si l'un des fichiers n'existe pas.
	 */
	public static function include_dir($path = ".", $rootfolder = 'includes/')
	{
		$regex_path = __RB_PLUGIN_DIR__.$rootfolder.$path."/*.php";
		
		foreach ( glob( $regex_path ) as $filename )
		{
			if ( $filename ) require_once $filename;
			else throw new Exception( "Erreur dans l'ajout des fichiers dans le path: \"".$regex_path."\"" );
		}
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
	 * Exécute le programme.
	 * 
	 * Appèle la fonction statique d'exécution de la classe statique RB_Loader afin d'ajouter les
	 * actions et les filtres dans l'environnement de Wordpress. 
	 * Ces actions ont été mises dans une "file d'attente" afin d'éviter de modifier les processus de base de Wordpress.
	 */
	public function run()
	{
		// Appeler la fonction d'exécution de la classe statique RB_Loader.
		RB_Loader::run();
	}
}
