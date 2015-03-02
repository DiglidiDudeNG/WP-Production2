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
	const DEFAULT_KEY          = null;
	const DEFAULT_HTML_TYPE    = 'static';
	const DEFAULT_DATA_TYPE    = 'text';
	const DEFAULT_LABEL        = 'Metadata sans-label';
	const DEFAULT_DEF_VALUE    = '';
	const DEFAULT_VALIDATE_CB  = null;
	const DEFAULT_IS_SAVED     = true;
	const DEFAULT_IN_COLUMNS   = false;
	const DEFAULT_IS_QUERY     = false;
	const DEFAULT_METABOX_ARGS = null;
	const DEFAULT_COLUMN_ARGS  = null;
	const DEFAULT_ARGS_CB      = null;
	
	// Types d'éléments HTML disponibles.
	const HTML_TYPE_STATIC          = 'p';
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
	const DATA_TYPE_STRING   = 'text';
	const DATA_TYPE_INT      = 'number';
	const DATA_TYPE_URL      = 'url';
	const DATA_TYPE_FILE     = 'file';
	const DATA_TYPE_CURRENCY = 'currency';
	const DATA_TYPE_BOOL     = 'bool';
	const DATA_TYPE_JSON     = 'json';
	// TODO trouver d'autres types de données à implémenter.
	
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
	
	// ---
	//<editor-fold desc="// PROPRIÉTÉS AUTRES DE LA CLASSE">
	
	//region Region
	/** @var Bool Vrai si la metadata n'est pas affichée dans une metabox sous des conditions normales. */
	private $is_hidden;
	
	/** @var Array la liste des arguments envoyés dans validate_cb */
	private $args_cb;
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
			'key'          => self::DEFAULT_KEY,
			'html_type'    => self::DEFAULT_HTML_TYPE,
			'data_type'    => self::DEFAULT_DATA_TYPE,
			'label'        => self::DEFAULT_LABEL,
			'default'      => self::DEFAULT_DEF_VALUE,
			'validate_cb'  => array( self::DEFAULT_VALIDATE_CB, self::DEFAULT_ARGS_CB ),
			'is_saved'     => self::DEFAULT_IS_SAVED,
			'in_columns'   => self::DEFAULT_IN_COLUMNS,
			'is_query'     => self::DEFAULT_IS_QUERY,
			'metabox_args' => self::DEFAULT_METABOX_ARGS,
			'column_args'  => self::DEFAULT_COLUMN_ARGS,
		);
		
		// Ajouter les données
		$args = wp_parse_args( $args, $defaults );
		
		// Si la clé n'a pas été mise dans les args et que la clé existe 
		if ( empty( $args['key'] ) )
		{
			if ( !empty( $key ) ) 
			{
				$args['key'] = $key;
			}
			else
			{
				wp_die( "La clé de la metadata n'a pas été définie!" );
			}
		}
		
		foreach ( $args as $cle => $param )
		{
			// Si la méthode existe, checker si la méthode du setter par rapport à la clé existe.
			if ( method_exists( $this, 'set_'.$cle ) )
			{
				// Si le paramètre a été assigné à notre objet avec succès, passer à la prochaine valeur.
				if ( ! call_user_func( array( $this, 'set_' . $cle ), $param ) ) {
					var_dump( $args );
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
	
	/**
	 *
	 *
	 * @param int|Null $iter   Itération.
	 * @param String   $retour La valeur de retour à date.
	 *
	 * @return String Le/les éléments HTML à afficher avec les bonnes données.
	 */
	public function render_html( $iter = null, $retour = null )
	{
		$value = '';
		
		if ( array_key_exists( $this->get_key(), $_GET ) )
			$value = $_GET[$this->get_key()];
		else
			wp_die( "\$_GET n'avait aucunement de clé au nom de ".$this->get_key()."." );
		
		if ( null === $iter ) {
			$retour = '<td><label for="'.$this->get_key().'"></label></td>';
		}
		
		switch ( $this->get_html_type() )
		{
			case RB_Metadata::HTML_TYPE_STATIC:
			return '<td><p>'. $this->get_label() . ' = ' . $this->render_data() . '</p></td>';
			break;
			
			case RB_Metadata::HTML_TYPE_INPUT:
				return '<td><input type="text" '
				       . $this->render_attributes( array('id', 'name') )
				       . '>'
				       . $this->render_data($value)
				       . '</input></td>';
				break;
			
			case RB_Metadata::HTML_TYPE_LINK:
				
				break;
			
			case RB_Metadata::HTML_TYPE_ORDERED_LIST:
				// TODO le rendu.
				break;
			
			case RB_Metadata::HTML_TYPE_UNORDERED_LIST:
				// TODO le rendu.
				break;
			
			case RB_Metadata::HTML_TYPE_SELECT: // TODO renommer.
				// TODO le rendu.
				break;
		}
	}
	
	/**
	 * @param int|Null $iter La position courante dans l'itération.
	 * 
	 * @return String Le/les éléments formatés en HTML.
	 */
	private function render_data( $iter = null ) 
	{
		switch ( $this->get_data_type() )
		{
			case RB_Metadata::DATA_TYPE_STRING:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_INT:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_URL:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_FILE:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_CURRENCY:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_BOOL:
				// TODO le rendu.
				
				break;
			
			case RB_Metadata::DATA_TYPE_JSON:
				// TODO le rendu.
				
				break;
			
			default:
				break;
		}
	}
	
	/**
	 * 
	 * 
	 * @return String La partie des attributs pour un élément HTML.
	 */
	private function render_attributes( array $args )
	{
		switch ( $args )
		{
			case 'id':
			case 'name':
				
				break;
			
			case '':
				
				break;
		}
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
	 * @return Array|Null
	 */
	public function get_metabox_query() { return $this->metabox_query; }
	
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
	 * @param String $key La valeur de la clé à assigner à la Metadata
	 *
	 * @return Bool Vrai si la clé a été assignée à la Metadata
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
	 * @param String $data_type La valeur du type de donnée à assigner à la Metadata.
	 *
	 * @return Bool Vrai si le type de donnée a été assigné à la Metadata.
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
	 * @param String $html_type La valeur de la propriété html_type assigner à l'objet RB_Metadata
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
	 * @param String $label La valeur de la propriété label assigner à l'objet RB_Metadata
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
	 * @param String $default La valeur de la propriété default assigner à l'objet RB_Metadata
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
	 * @param String $validate_cb La valeur de la propriété validate_cb assigner à l'objet RB_Metadata
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
	 * @param String $in_columns La valeur de la propriété in_columns assigner à l'objet RB_Metadata
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
	 * @param String $is_query La valeur de la propriété is_query assigner à l'objet RB_Metadata
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
	 * Setter de metabox_query.
	 *
	 * @param String $metabox_query La valeur de la propriété metabox_query assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre metabox_query a été assignée à l'objet RB_Metadata
	 */
	public function set_metabox_query( $metabox_query ) 
	{
		$ok = $this->valider_metabox_query( $metabox_query );
		
		if ($ok)
			$this->metabox_query = $metabox_query;
		
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
		// TODO validateur
		return true;
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
		$types = self::get_valid_data_types();
		
		foreach ( $types as $type )
		{
			
		}
		
		return true;
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
	 * Validateur de la propriété $metabox_query.
	 *
	 * @param Array $metabox_query La valeur de la propriété metabox_query
	 *
	 * @return Bool Vrai si c'est valide.
	 */
	private function valider_metabox_query( $metabox_query )
	{
		// Retourne vrai si ça passe.
		return ( !empty( $metabox_query ) && is_array( $metabox_query ) );
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
		return ( !empty( $column_query ) && is_array( $column_query ) );
	}

}
