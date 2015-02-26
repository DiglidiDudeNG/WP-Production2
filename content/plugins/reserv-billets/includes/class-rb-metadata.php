<?php

/**
 * Class RB_Metadata
 * 
 * La classe représentant une metadonnée.
 * 
 * @see add_post_meta()
 * @see update_post_meta()
 */
class RB_Metadata
{
	//<editor-fold desc="// CONSTANTES">
	
	// Valeur par défaut de toutes les valeurs dans le pre-pass.
	const DEFAULT_PREPASS = '';
	
	// Valeurs par défaut des arguments du constructeur.
	const DEFAULT_KEY = "";
	const DEFAULT_TYPE = "static:text";
	const DEFAULT_DATA_TYPE = "show";
	const DEFAULT_HTML_TYPE = "text";
	const DEFAULT_LABEL = 'Metadata sans-label';
	const DEFAULT_DEF_VALUE = '';
	const DEFAULT_VALIDATE_CB = null;
	const DEFAULT_IS_SAVED = true;
	const DEFAULT_IN_COLUMNS = false;
	const DEFAULT_IS_QUERY = false;
	const DEFAULT_METABOX_ARGS = null;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// PROPRIÉTÉ DE CONSTRUCTION DE LA METADATA">
	
	/** @var String La clé unique de la metabox. */
	private $key;
	
	/** @var String Le type de donnée enregistrée dans la metadonnée. Sera traduite plus tard. */
	private $data_type;
	
	/** @var String Le type d'affichage en HTML. Sera traduit plus tard. */
	private $html_type;
	
	/** @var String Le label de la metadata, tel qu'affiché dans le label. */
	private $label;
	
	/** @var int|string La valeur par défaut de la metadata, qu'on assigne lors de la création d'un nouveau post. */
	private $default;
	
	/** @var String|Array Le callback de validation de la donnée lorsqu'elle doit être enregistrée dans le post. */
	private $validate_cb;
	
	/** @var Bool Vrai si la valeur sera sauvegardée. Évite les requêtes $_GET qui ont l'air louches... */
	private $is_saved;
	
	/** @var Bool Vrai si la valeur est affichée dans une colonne. */
	private $in_columns;
	
	/** @var Bool Vrai si la metadata effectue une query pour afficher une ou des données. */
	private $is_query;
		
	/** @var Array 
	 * La liste des arguments mis dans WP_Query, incluant les autres arguments de liaisons, 
	 * afin d'afficher la donnée dans une metabox.
	 */
	private $metabox_query;
	
	/** @var Array
	 * La liste des arguments mis dans WP_Query, incluant les autres arguments de liaisons,
	 * afin d'afficher la donnée dans la colonne.
	 */
	private $column_query;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// PROPRIÉTÉS AUTRES DE LA CLASSE">
	
	/** @var Bool Vrai si la metadata n'est pas affichée dans une metabox sous des conditions normales. */
	private $is_hidden;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// CONSTRUCTEUR">
	
	/**
	 * Constructeur d'un objet Metadata.
	 *
	 * @param array $args Les arguments de l'objet.
	 */
	function __construct( array $args )
	{
		// Déclarer les valeurs par défaut de prepass.
		$defaults_prepass = array(
			'type'              => self::DEFAULT_PREPASS,
			'html_type'         => self::DEFAULT_PREPASS,
			'data_type'         => self::DEFAULT_PREPASS,
		);
		
		// Déclarer les valeurs par défaut.
		$defaults = array(
			'type'              => self::DEFAULT_TYPE,
			'html_type'         => self::DEFAULT_HTML_TYPE,
			'data_type'         => self::DEFAULT_DATA_TYPE,
			'label'             => self::DEFAULT_LABEL,
			'default'           => self::DEFAULT_DEF_VALUE,
			'validate_cb'       => self::DEFAULT_VALIDATE_CB,
			'is_saved'          => self::DEFAULT_IS_SAVED,
			'in_columns'        => self::DEFAULT_IN_COLUMNS,
			'is_query'          => self::DEFAULT_IS_QUERY,
			'metabox_args'      => self::DEFAULT_METABOX_ARGS,
			'column_args'       => array(),
		);
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// MÉTHODES AFFECTANT WORDPRESS DIRECTEMENT">
	
	/**
	 * Effectue la mise à jour de la valeur 
	 * 
	 * @param int        $post_id L'ID du post qui va être affecté.
	 * @param string|int $val     La nouvelle valeur appliquée.
	 */
	public function update( $post_id, $val )
	{
		
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// GETTERS">
	
	/**
	 * Getter pour la clé.
	 * 
	 * @return String La clé.
	 */
	public function get_key() { return $this->key; }
	
	/**
	 * Getter pour le type de donnée.
	 * 
	 * @return String Le type de donnée.
	 */
	public function get_data_type() { return $this->data_type; }
	
	/**
	 * Getter pour le type de modèle HTML utilisé pour afficher la valeur.
	 * 
	 * @return String Le type de modèle HTML utilisé pour afficher la valeur.
	 */
	public function get_html_type() { return $this->html_type; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return String 
	 */
	public function get_name() { return $this->name; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return int|string
	 */
	public function get_default_value() { return $this->default; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Array|String
	 */
	public function get_validate_cb() { return $this->validate_cb; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_in_columns() { return $this->in_columns; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_query() { return $this->is_query; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Array
	 */
	public function get_metabox_query() { return $this->metabox_query; }
	
	public function get_column_query() { return $this->column_query; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_hidden() { return $this->is_hidden; }
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// SETTERS">
	
	/**
	 * TODO DESCR
	 * 
	 * @param String $key
	 */
	public function set_key( $key ) 
	{
		// TODO set.
		$this->key = $key;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param String $data_type
	 */
	public function set_data_type( $data_type ) 
	{
		// TODO set.
		$this->data_type = $data_type;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param String $html_type
	 */
	public function set_html_type( $html_type ) 
	{
		// TODO set.
		$this->html_type = $html_type;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param String $label
	 */
	public function set_label( $label ) 
	{
		// TODO set.
		$this->label = $label;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param int|string $default
	 */
	public function set_default( $default ) 
	{
		// TODO set.
		$this->default = $default;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param Array|String $validate_cb
	 */
	public function set_validate_cb( $validate_cb ) 
	{
		// TODO set.
		$this->validate_cb = $validate_cb;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param Bool $in_columns
	 */
	public function set_in_columns( $in_columns ) 
	{
		// TODO set.
		$this->in_columns = $in_columns;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param Bool $is_query
	 */
	public function set_is_query( $is_query ) 
	{
		// TODO set.
		$this->is_query = $is_query;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param Array $metabox_query
	 */
	public function set_metabox_query( $metabox_query ) 
	{
		// TODO set.
		$this->metabox_query = $metabox_query;
	}
	
	/**
	 * TODO DESCR
	 * 
	 * @param Array $column_query
	 */
	public function set_column_query( $column_query ) 
	{
		// TODO set.
		$this->column_query = $column_query;
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// VALIDATEURS">
	
	
	
	// TODO coder cette classe.
}
