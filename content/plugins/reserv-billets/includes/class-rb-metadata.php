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
	const DEFAULT_PREPASS = null;
	
	// Valeurs par défaut des arguments du constructeur.
	const DEFAULT_KEY            = null;
	const DEFAULT_HTML_TYPE      = 'static';
	const DEFAULT_DATA_TYPE      = 'text';
	const DEFAULT_LABEL          = 'Metadata sans-label';
	const DEFAULT_DEF_VALUE      = '';
	const DEFAULT_VALIDATE_CB    = null;
	const DEFAULT_IS_SAVED       = true;
	const DEFAULT_IN_COLUMNS     = false;
	const DEFAULT_IS_QUERY       = false;
	const DEFAULT_LIST_QUERY     = null;
	const DEFAULT_DROPDOWN_QUERY = null;
	const DEFAULT_COLUMN_QUERY   = null;
	
	// Types d'éléments HTML disponibles.
	const HTML_TYPE_STATIC          = 'p';
	const HTML_TYPE_STATIC_OLD      = 'static';
	const HTML_TYPE_INPUT           = 'input';
	const HTML_TYPE_ORDERED_LIST    = 'ol';
	const HTML_TYPE_UNORDERED_LIST  = 'ul';
	const HTML_TYPE_LINK            = 'a';
	const HTML_TYPE_SELECT          = 'select';
	const HTML_TYPE_RADIO           = 'radio';
	const HTML_TYPE_CHECKBOX        = 'checkbox';
	const HTML_TYPE_DATE            = 'date';
	const HTML_TYPE_TIME            = 'time';
	// TODO trouver d'autres types d'éléments HTML à implémenter.
	
	// Types de données disponibles.
	const DATA_TYPE_TEXT     = 'text';
	const DATA_TYPE_NUMBER   = 'number';
	const DATA_TYPE_URL      = 'url';
	const DATA_TYPE_FILE     = 'file';
	const DATA_TYPE_CURRENCY = 'currency';
	const DATA_TYPE_BOOL     = 'bool';
	const DATA_TYPE_JSON     = 'json';
	const DATA_TYPE_DATE     = 'date';
	const DATA_TYPE_TIME     = 'time';
	// TODO trouver d'autres types de données à implémenter.
	
	// Valeurs des constantes d'itération dans Render_HTML.
	const FERMER_BALISE_CELLULE_TABLE = false;
	const FERMER_BALISE_HTML_TYPE = true;

	
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
	 * Les arguments pour la fonction wp_list_{WP_Object} où {WP_Object} est le nom d'un objet de Wordpress 
	 * au pluriel, tel que « pages », « authors », « categories », etc.
	 */
	private $list_query;
	
	/** @var Array
	 * Les arguments pour la fonction wp_dropdown_{WP_Object}, où {WP_Object} est le nom d'un objet de Wordpress 
	 * au pluriel, tel que « pages », « authors », « categories », etc.
	 */
	private $dropdown_query;
	
	/** @var Array
	 * La liste des arguments mis dans WP_Query, incluant les autres arguments de liaisons,
	 * afin d'afficher la donnée dans la colonne.
	 */
	private $column_query;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// PROPRIÉTÉS AUTRES DE LA CLASSE">
	//region Propriétés
	
	/** @var Bool Vrai si la metadata n'est pas affichée dans une metabox sous des conditions normales. */
	private $is_hidden;
	
	/** @var Array(String) La liste des data types qui peuvent être assignés directement dans le type de l'input. */
	public static $compatible_data_types_with_input = array(
		'text', 'number', 'url', 'file',
	);
	
	//endregion
	//</editor-fold>
	// ---
	//<editor-fold desc="// CONSTRUCTEUR">
	
	/**
	 * Constructeur d'un objet Metadata.
	 *
	 * @param array  $args      Les arguments de l'objet.
	 * @param string $post_type Le post-type.
	 * @param string $key       La clé.
	 *
	 * @throws \ErrorException
	 */
	function __construct( array $args, $post_type = 'post', $key = null )
	{
		// Déclarer les valeurs par défaut.
		$defaults = array(
			'key'            => self::DEFAULT_KEY,
			'html_type'      => self::DEFAULT_HTML_TYPE,
			'data_type'      => self::DEFAULT_DATA_TYPE,
			'label'          => self::DEFAULT_LABEL,
			'default'        => self::DEFAULT_DEF_VALUE,
			'validate_cb'    => self::DEFAULT_VALIDATE_CB,
			'is_saved'       => self::DEFAULT_IS_SAVED,
			'in_columns'     => self::DEFAULT_IN_COLUMNS,
			'is_query'       => self::DEFAULT_IS_QUERY,
			'list_query'     => self::DEFAULT_LIST_QUERY,
			'dropdown_query' => self::DEFAULT_DROPDOWN_QUERY,
			'column_query'   => self::DEFAULT_COLUMN_QUERY,
		);
		
		// Ajouter les données
		$args = wp_parse_args( $args, $defaults );
		
		// Si la clé n'a pas été mise dans les args et que la clé existe 
		if ( empty( $args['key'] ) )
		{
			!empty( $key ) ? $args['key'] = $key : wp_die( "La clé de la metadata n'a pas été définie!" );
		}
		
		foreach ( $args as $cle => $param )
		{
			// Si la méthode existe, checker si la méthode du setter par rapport à la clé existe.
			if ( method_exists( $this, 'set_'.$cle ) )
			{
				// Si le paramètre a été assigné à notre objet avec succès, passer à la prochaine valeur.
				if ( ! call_user_func( array( $this, 'set_' . $cle ), $param ) ) {
					// Si ça itère pas à la prochaine valeur, on affiche un erreur.
					wp_die( __( "Le constructeur de <b>" . __CLASS__ . "</b> a retourné une erreur pour l'assignement du param <b>" . $cle . ".</b>" ) );
				}
			}
		}
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// MÉTHODES AFFECTANT WORDPRESS DIRECTEMENT">
	
	/**
	 * Effectue la mise à jour de la valeur 
	 * 
	 * @param Int        $post_id L'ID du post qui va être affecté.
	 * @param String|Int $val     La nouvelle valeur appliquée.
	 */
	public function update( $post_id, $val )
	{
		
	}
	
	public $count = 0;
	
	/**
	 * Effectue le rendu en HTML de l'objet RB_Metadata.
	 *
	 * @param WP_Post  $post     Le post.
	 * @param String   $retour   (o) Le contenu HTML de base, s'il y en a.
	 * @param int|Null $iterator (o) La position dans l'itération.
	 *                           __Null__                si y'a en ce moment aucune itération,
	 *                           __ArrayIterator__       si on a un itérateur,
	 *                           __Booléen__ à __True__  si l'itération doit fermer le balise HTML du type.
	 *                           __Booléen__ à __False__ si l'itération doit fermer la balise HTML de la cellule
	 *                                                   de la table.
	 *
	 * @return String Le/les éléments HTML à afficher avec les bonnes données.
	 */
	public function render_html( $post, $retour = '', $iterator = null )
	{
		// Déclarer la valeur dans le $_GET par rapport au nom de la clé.
		$value = '';
		
		// S'il y a la clé de la metadata dans la requête, la mettre dans la variable à cet insu.
		if ( $meta_value = get_post_meta( $post->ID, $this->get_key(), true ) )
			$value = $meta_value;
		
		// S'il n'y a pas d'itération, afficher la fin.
		if ( is_null( $iterator ) ) {
			$retour = '<td><label for="' . $this->get_key() . '">'.$this->get_label().' :</label></td><td>';
		}
		elseif // Sinon, si l'itération est en fait un booléen à faux, retourner avec la fin de l'itération.
			( $iterator === self::FERMER_BALISE_CELLULE_TABLE )
		{
			return $retour.'</td>';
		}
		
		/*
		 * Effectuer le rendu de la metadata par rapport au type d'HTML utilisé.
		 */ 
		switch ( $this->get_html_type() ) :
			/**           ---------------------
			 * @html-type Statique, sans input
			 *            ---------------------
			 */
			case RB_Metadata::HTML_TYPE_STATIC:
			case RB_Metadata::HTML_TYPE_STATIC_OLD:
				if ( is_null( $iterator ) )
					return '<p>' . $this->get_label() . ' : ' . $this->render_data( $value ) . '</p>';
				else
					return '<p>' . $this->get_label() . ' : ' . $this->render_data( $value ) . '</p>';
				break;
			
			/**           -----------
			 * @html-type Input text
			 *            -----------
			 * 
			 * Va utiliser $data_type afin d'attribuer un type.
			 */
			case RB_Metadata::HTML_TYPE_INPUT:
				$retour .= '<input '
			           . $this->render_attribute( 'type', $this->get_type_attribute() )
			           . $this->render_attribute( 'id' ) // id="'.$this->get_key.'"
			           . $this->render_attribute( 'name' )
			           . $this->render_attribute( 'value', $this->render_data($value) )
			           . '/>';
				$retour = $this->render_html( $post, $retour, false );
				break;
			
			/**           -----
			 * @html-type Lien
			 *            -----
			 */
			case RB_Metadata::HTML_TYPE_LINK:
				$retour .= '<'.$this->get_html_type() // a
			           . $this->render_attribute( 'href', $value ) // href="'.SOME_POST_STUFF.'"
			           . $this->render_attribute( 'id' ) // id="'.$this->get_key.'"
			           . $this->render_attribute( 'name' ) // name="'.$this->get_key.'"
			           . $this->render_attribute( 'value', $this->render_data($value) ) // la valeur.
			           . '>';
				$retour = $this->render_html( $post, $retour, false );
				break;
			
			/**           ------------------------------
			 * @html-type Liste ordonnée ou non-ordonée
			 *            ------------------------------
			 */
			case RB_Metadata::HTML_TYPE_ORDERED_LIST:
			case RB_Metadata::HTML_TYPE_UNORDERED_LIST:
				$retour .= call_user_func(
					sprintf( 'wp_list_%s', $this->get_list_query()['type'] ),
					$this->get_list_query()
				);
				break;
			
			/**           -------
			 * @html-type Select
			 *            -------
			 */
			case RB_Metadata::HTML_TYPE_SELECT:
				$retour .= call_user_func(
					sprintf('wp_dropdown_%s', $this->get_dropdown_query()['type']), 
					$this->get_dropdown_query()
				);
				break;
			
			/**           ------
			 * @html-type Radio
			 *            ------
			 */
			case RB_Metadata::HTML_TYPE_RADIO:
				// Ne sera probablement pas implémenté.
				break;
			
			/**           ---------
			 * @html-type Checkbox
			 *            ---------
			 */
			case RB_Metadata::HTML_TYPE_CHECKBOX:
				// Ne sera probablement pas implémenté.
				break;
			
			/**           -----
			 * @html-type Date
			 *            -----
			 */
			case RB_Metadata::HTML_TYPE_DATE:
				// TODO le rendu.
				$retour .= '<input '
			           . $this->render_attribute( 'type', 'date' )
			           . $this->render_attribute( 'id' ) // id="'.$this->get_key.'"
			           . $this->render_attribute( 'name' ) 
			           . $this->render_attribute( 'value', $this->render_data($value) )
			           . '/>';
				
				$retour = $this->render_html( $post, $retour, $iterator );
				break;
			
			/**           -----
			 * @html-type Time
			 *            -----
			 */
			case RB_Metadata::HTML_TYPE_TIME:
				// TODO le rendu.
				$retour .= '<input '
			           . $this->render_attribute( 'type', 'time' )
			           . $this->render_attribute( 'id' ) // id="'.$this->get_key.'"
			           . $this->render_attribute( 'name' )
			           . $this->render_attribute( 'value', $this->render_data($value) )
			           . '/>';
				
				$retour = $this->render_html( $post, $retour, false );
				break;
			
			/**           -----------
			 * @html-type Par défaut
			 *            -----------
			 */
			default:
				// TODO rendu par défaut avec input.
				var_dump($this->get_html_type());
				wp_die( "RENDER_HTML NOT WORKING" );
				break;
		endswitch;
		
		return $retour . "</tr><tr>";
	}
	
	/**
	 * Effectue le rendu des données.
	 * 
	 * @param Mixed              $value    La valeur de la donnée.
	 * @param ArrayIterator|Null $iterator Si Integer, la position courante dans l'itération.<br />
	 *                                Si String, la balise à entourer chaque donnée.
	 * 
	 * @return String Le/les éléments formatés en HTML.
	 */
	private function render_data( $value, $iterator = null )
	{
		// Déclarer la variable de retour.
		$retour = $value;
		
		switch ( $this->get_data_type() ) :

			case RB_Metadata::DATA_TYPE_TEXT:
			case RB_Metadata::DATA_TYPE_NUMBER:
			case RB_Metadata::DATA_TYPE_URL:
				// TODO le rendu.
				break;

			/**           --------
			 * @data-type Fichier
			 *            --------
			 */
			case RB_Metadata::DATA_TYPE_FILE:
				// TODO le rendu.
				break;
			
			/**           --------------------
			 * @data-type Monnaie $$$ (float)
			 *            --------------------
			 */
			case RB_Metadata::DATA_TYPE_CURRENCY:
				// TODO le rendu.
				break;
			
			/**           -----------------
			 * @data-type Booléen (0 ou 1)
			 *            -----------------
			 */
			case RB_Metadata::DATA_TYPE_BOOL:
				// TODO le rendu.
				break;
			
			/**           -----------------------
			 * @data-type JSON (array en string)
			 *            -----------------------
			 */
			case RB_Metadata::DATA_TYPE_JSON:
				// TODO le rendu.
				/** @var array $json_array */
				$json_array = json_decode( $value );
				
				$retour = $json_array[''];
				
				//$this->render_data();
				break;
			
			/**           -----------
			 * @data-type Par défaut
			 *            -----------
			 */
			default:
				wp_die( "RENDER_DATA NOT WORKING" );
				break;
		endswitch;

		return $retour;
	}
	
	/**
	 * Effectue un rendu d'un attribut.
	 * 
	 * @param String $attribute L'attribut à retourner pour la balise.
	 * @param Mixed  $value     La valeur de la metadata, si on en a besoin.
	 * 
	 * @return String La partie des attributs pour un élément HTML.
	 */
	private function render_attribute( $attribute, $value = '' )
	{
		$shown_attr = '';
		
		switch ( $attribute ) {
			case 'id':
			case 'name':
				$shown_attr = $this->get_key() . $value;
				break;
			case 'name[]':
				$shown_attr = $this->get_key() . '[]';
				break;
			case 'type':
			case 'value':
				$shown_attr = ( empty( $value ) ? /*TRUE :*/ $this->get_key() : /*FALSE :*/ $value );
				break;
		}
		
		return ' ' . $attribute . '="' . $shown_attr . '" ';
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
	 * Retourne la valeur pour l'attribut « type ».
	 */
	public function get_type_attribute() 
	{
		$retour = $this->get_data_type();
		
		switch ( $retour )
		{
			/**           --------
			 * @data-type Fichier
			 *            --------
			 */
			case RB_Metadata::DATA_TYPE_FILE:
				// TODO le rendu.
				break;
			
			/**           --------------------
			 * @data-type Monnaie $$$ (float)
			 *            --------------------
			 */
			case RB_Metadata::DATA_TYPE_CURRENCY:
				// TODO le rendu.
				$retour = 'number';
				break;
			
			/**           -----------------
			 * @data-type Booléen (0 ou 1)
			 *            -----------------
			 */
			case RB_Metadata::DATA_TYPE_BOOL:
				// TODO le rendu.
				break;
			
			/** Par défaut. */
			default:
				$retour = $this->get_data_type();
				break;
		}
		
		return $retour;
	}
	
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
	public function get_label() { return $this->label; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Int|String
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
	 * @return Bool
	 */
	public function is_saved() { return $this->is_saved; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Array|Null
	 */
	public function get_list_query() { return $this->list_query; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Array|Null
	 */
	public function get_dropdown_query() { return $this->dropdown_query; }
	
	/** 
	 * TODO DESCR
	 * 
	 * @return Array|Null
	 */
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
	 * Setter de la clé.
	 *
	 * @param String $key La valeur de la clé à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la clé a été assignée à l'objet RB_Metadata
	 */
	public function set_key( $key ) 
	{
		$ok = $this->valider_key( $key );
		
		if ($ok)
			$this->key = $key;
		
		return $ok;
	}
	
	/**
	 * Setter du type de donnée de la Metadata.
	 *
	 * @param String $data_type La valeur du type de donnée à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si le type de donnée a été assigné à l'objet RB_Metadata
	 */
	public function set_data_type( $data_type ) 
	{
		$ok = $this->valider_data_type( $data_type );
		
		if ($ok)
			$this->data_type = $data_type;
		
		return $ok;
	}
	
	/**
	 * Setter de html_type.
	 *
	 * @param String $html_type La valeur de la propriété html_type à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre html_type a été assignée à l'objet RB_Metadata
	 */
	public function set_html_type( $html_type )
	{
		$ok = $this->valider_html_type( $html_type );
		
		if ($ok)
			$this->html_type = $html_type;
		
		return $ok;
	}
	
	/**
	 * Setter de label.
	 *
	 * @param String $label La valeur de la propriété label à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre label a été assignée à l'objet RB_Metadata
	 */
	public function set_label( $label ) 
	{
		$ok = $this->valider_label( $label );
		
		if ($ok)
			$this->label = $label;
		
		return $ok;
	}
	
	/**
	 * Setter de default.
	 *
	 * @param Mixed $default La valeur de la propriété default à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre default a été assignée à l'objet RB_Metadata
	 */
	public function set_default( $default ) 
	{
		$ok = $this->valider_default( $default );
		
		if ($ok)
			$this->default = $default;
		
		return $ok;
	}
	
	/**
	 * Setter de validate_cb.
	 *
	 * @param String|Array $validate_cb La valeur de la propriété validate_cb à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre validate_cb a été assignée à l'objet RB_Metadata
	 */
	public function set_validate_cb( $validate_cb ) 
	{
		$ok = $this->valider_validate_cb( $validate_cb );
		
		if ($ok)
			$this->validate_cb = $validate_cb;
		
		return $ok;
	}
	
	/**
	 * Setter de in_columns.
	 *
	 * @param String $in_columns La valeur de la propriété in_columns à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre in_columns a été assignée à l'objet RB_Metadata
	 */
	public function set_in_columns( $in_columns ) 
	{
		$ok = is_bool( $in_columns );
		
		if ($ok)
			$this->in_columns = $in_columns;
		
		return $ok;
	}
	
	/**
	 * Setter de is_query.
	 *
	 * @param Bool $is_query La valeur de la propriété is_query à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre is_query a été assignée à l'objet RB_Metadata
	 */
	public function set_is_query( $is_query ) 
	{
		$ok = is_bool( $is_query );
		
		if ($ok)
			$this->is_query = $is_query;
		
		return $ok;
	}
	
	/**
	 * Setter de is_saved.
	 * 
	 * @param Bool $is_saved 
	 *
	 * @return Bool
	 */
	public function set_is_saved( $is_saved )
	{
		$this->is_saved = $is_saved;
		return true;
	}
	
	/**
	 * Setter de list_query.
	 *
	 * @param String $list_query La valeur de la propriété list_query à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre list_query a été assignée à l'objet RB_Metadata
	 */
	public function set_list_query( $list_query ) 
	{
		$defaults = array(
			'type' => 'pages',
			// TODO les arguments par défaut.
		);
		
		$list_query = wp_parse_args( $list_query, $defaults );
		
		$ok = $this->valider_list_query( $list_query );
		
		if ($ok)
			$this->list_query = $list_query;
		
		return $ok;
	}
	
	/**
	 * Setter de dropdown_query.
	 *
	 * @param String $dropdown_query La valeur de la propriété dropdown_query à assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre dropdown_query a été assignée à l'objet RB_Metadata
	 */
	public function set_dropdown_query( $dropdown_query )
	{
		$defaults = array(
			'type' => 'pages',
			// TODO les arguments par défaut.
		);
		
		$list_query = wp_parse_args( $dropdown_query, $defaults );
		
		$ok = $this->valider_dropdown_query( $dropdown_query );
		
		if ($ok)
			$this->dropdown_query = $dropdown_query;
		
		return $ok;
	}
	
	/**
	 * Setter de column_query.
	 *
	 * @param String $column_query La valeur de la propriété column_query assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre column_query a été assignée à l'objet RB_Metadata
	 */
	public function set_column_query( $column_query ) 
	{
		// TODO vérification si c'est vide.
		
		$defaults = array(
			'post_type' => 'post',
			// TODO les arguments par défaut.
		);
		
		wp_parse_args( $column_query, $defaults );
		
		$ok = $this->valider_column_query( $column_query );
		
		if ($ok)
			$this->column_query = $column_query;
		
		return $ok;
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// VALIDATEURS">
	
	/**
	 * Validateur de la clé.
	 * 
	 * @param String $key La valeur de la clé.
	 * 
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_key( $key )
	{
		// TODO validateur.
		
		return true;
	}
	
	/**
	 * Validateur du type de donnée.
	 *
	 * @param String $data_type La valeur du type de donnée.
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_data_type( $data_type )
	{
		$var = array_search( $data_type, self::get_valid_data_types() );
		return ( $var );
	}
	
	/**
	 * Validateur du type d'élément HTML.
	 * 
	 * @param String $html_type La valeur du type d'élément HTML.
	 * 
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_html_type( $html_type ) 
	{
		return ( array_search( $html_type, self::get_valid_html_types() ) );
	}
	
	/**
	 * Pogne les constantes des types de données valides de la classe RB_Metadata.
	 *
	 * TODO vérifier si ça vaut la peine d'avoir ça.
	 *
	 * @return array La liste des types de données valides.
	 */
	public static function get_valid_data_types()
	{
		return self::get_constants_by_prefix( 'RB_Metadata', 'DATA_TYPE_' );
	}
	
	/**
	 * Pogne les constantes des types d'éléments HTML valides de la classe RB_Metadata.
	 *
	 * TODO vérifier si ça vaut la peine d'avoir ça.
	 *
	 * @return array La liste des types d'éléments HTML valides.
	 */
	public static function get_valid_html_types()
	{
		return self::get_constants_by_prefix( 'RB_Metadata', 'HTML_TYPE_' );
	}
	
	/**
	 * Filtre parmis les constantes dans la classe RB_Metadata.
	 *
	 * TODO vérifier si ça vaut la peine d'avoir ça.
	 *
	 * @link http://php.net/manual/en/function.get-defined-constants.php#60399
	 *
	 * @param String $class  Le nom de la classe où pogner les constantes.
	 * @param String $prefix Le préfixe pour les constantes de la même catégorie.
	 *
	 * @return array La liste des constantes correspondantes au préfixe et qui sont dans la classe spécifiée.
	 * @throws \ErrorException
	 */
	public static function get_constants_by_prefix( $class, $prefix )
	{
		// Déclarer les variables locales.
		$reflect = new ReflectionClass( $class );
		$constants = $reflect->getConstants();
		$dump = array();
		
		// Parcourir l'array de constantes.
		foreach ( $constants as $key => $value)
		{
			// Checker si la constante courante contient le prefixe.
			if ( substr( $key, 0, strlen( $prefix ) ) == $prefix )
			{
				// Pogner le reste de la valeur.
				$key = substr( $key, strlen($prefix) - 1 );
				// Mettre la constante dans la clé.
				$dump[ $key ] = $value;
			}
		}
		
		// Si y'a rien trouvé, lancer une erreur!
		if ( empty( $dump ) )
			throw new ErrorException("Erreur, aucune constante valide trouvée dans RB_Metadata.");
		
		return $dump;
	}
	
	/**
	 * Validateur du libellé.
	 *
	 * @param String $label La valeur du libellé.
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_label( $label )
	{
		// TODO validateur
		return true;
	}
	
	/**
	 * Validateur de la valeur par défaut.
	 *
	 * @param Mixed $default La valeur de la valeur par défaut.
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_default( $default )
	{
		// TODO validateur
		return true;
	}
	
	/**
	 * Validateur de la propriété $validate_cb.
	 *
	 * @param Array $validate_cb La valeur de la propriété validate_cb
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_validate_cb( $validate_cb )
	{
		// Déclarer la variable de retour.
		$retour = false;
		
		// Vérifier si ce n'est pas vide.
		if ( empty( $validate_cb ) || empty($validate_cb[0]) )
		{
			$retour = true;
		}
		else
		{
			// Si c'est un array, faire les vérifications pour l'array.
			if ( is_array( $validate_cb ) )
			{
				$valcount = count( $validate_cb );
				var_dump($validate_cb);
				var_dump($valcount);
				
				if ( $valcount == 2 && method_exists( $validate_cb[0], $validate_cb[1] ) )
				{
					$retour = call_user_func( $validate_cb );
				}
				elseif // s'il y a plus de 2 valeurs dans la boucle.
				( $valcount > 2 && method_exists( $validate_cb[0], $validate_cb[1] ) )
				{
					// Déclarer la liste des arguments.
					$args = array();
					
					// Pour chaque valeur après celles de l'objet et de 
					for ( $i = 2; $i < $valcount; $i++ )
					{
						$args[] = $validate_cb[$i];
					}
					
					$retour = call_user_func_array( array( $validate_cb[0], $validate_cb[1] ), $args );
				}
				else
				{
					wp_die( __( "Le validateur custom est mal-formé pour le callback de validation du metadata "
					            . $this->get_key()
					            . " est invalide !" ) );
				}
			}
			elseif // Si c'est une string.
				( is_string( $validate_cb ) )
			{
				
			}
			else
			{
				wp_die( __( "Le callback n'est pas du type string ni array. Type trouvé: "
				            . gettype( $validate_cb )
				            . "." ) );
			}
		}
		
		// Retourne la valeur de retour du callback, ou faux si ça a pas fonctionné.
		return $retour;
	}
	
	/**
	 * Validateur de la propriété $list_query.
	 *
	 * @param Array $list_query La valeur de la propriété list_query
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_list_query( $list_query )
	{
		// Retourne vrai si ça passe.
		return ( is_null($list_query) || !empty( $list_query ) && is_array( $list_query ) );
	}
	
	/**
	 * Validateur de la propriété $dropdown_query.
	 *
	 * @param Array $dropdown_query La valeur de la propriété dropdown_query
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_dropdown_query( $dropdown_query )
	{
		// Retourne vrai si ça passe.
		return ( is_null($dropdown_query) || !empty( $dropdown_query ) && is_array( $dropdown_query ) );
	}
	
	/**
	 * Validateur de la propriété $column_query.
	 *
	 * @param Array $column_query La valeur de la propriété column_query
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_column_query( $column_query )
	{
		// Retourne vrai si ça passe.
		return ( is_null($column_query) || !empty( $column_query ) && is_array( $column_query ) );
	}
	//</editor-fold>
}
