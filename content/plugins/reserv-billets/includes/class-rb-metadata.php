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
	const DEFAULT_LABEL          = 'Metadata sans-label';
	const DEFAULT_DEFAULT        = '';
	const DEFAULT_IS_SAVED       = true;
	const DEFAULT_IN_COLUMNS     = false;
	const DEFAULT_IS_QUERY       = false;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// PROPRIÉTÉ DE CONSTRUCTION DE LA METADATA">
	
	/** @var String La clé unique de la metabox. */
	private $key;
	
	/** @var String Le label de la metadata, tel qu'affiché dans le label. */
	private $label;
	
	/** @var int|string La valeur par défaut de la metadata, qu'on assigne lors de la création d'un nouveau post. */
	private $default;
	
	/** @var Bool Vrai si la valeur sera sauvegardée. Évite les requêtes $_GET qui ont l'air louches... */
	private $is_saved;
	
	/** @var Bool Vrai si la valeur est affichée dans une colonne. */
	private $in_columns;
	
	/** @var Bool Vrai si la sauvegarde est un upload de fichier. */
	private $is_file_upload;
	
	/** @var Callable Le callable pour le rendu. */
	private $render_cb;
	
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
			'label'          => self::DEFAULT_LABEL,
			'default'        => self::DEFAULT_DEFAULT,
			'is_saved'       => self::DEFAULT_IS_SAVED,
			'in_columns'     => self::DEFAULT_IN_COLUMNS,
			'is_file_upload' => false,
			'render_cb'      => null,
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
			// Si la clé du param est dans les defaults, la méthode existe, et ça itère pas à la prochaine valeur, on affiche un erreur.
			if ( array_key_exists( $cle, $defaults )
			     && method_exists( $this, 'set_'.$cle )
			     && !call_user_func( array( $this, 'set_'.$cle ), $param ) )
			{
				wp_die( __( "Le constructeur de la metadata <b>" . $args['key'] . "</b> a retourné une erreur pour l'assignement du param <b>" . $cle . ".</b>" ) );
			}
		}
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// MÉTHODES AFFECTANT WORDPRESS DIRECTEMENT">
	
	/**
	 * Effectue la mise à jour de la valeur
	 *
	 * @param Int          $post_id   L'ID du post qui va être affecté.
	 * @param String|Int   $val       La nouvelle valeur appliquée.
	 * @return String|Bool            L'ID de la meta si elle n'existait pas, 
	 *                                Vrai si l'update a fonctionné, 
	 *                                Faux sinon.
	 */
	public function update( $post_id, $val = null )
	{
		$retour = false;
		
		// If the user uploaded an image, let's upload it to the server
		if ( $this->is_file_upload() && !empty( $_FILES[$this->get_key()]['name'] ) )
		{
			// Upload the goal image to the uploads directory, resize the image, then upload the resized version
			$goal_image_file = wp_upload_bits( $_FILES[$this->get_key()]['name'], null, file_get_contents($_FILES[$this->get_key()]['tmp_name']) );
			
			// Set post meta about this image. Need the comment ID and need the path.
			if ( false == $goal_image_file['error'] )
			{
				// Since we've already added the key for this, we'll just update it with the file.
				$retour = update_post_meta( $post_id, $this->get_key(), $goal_image_file['url'] );
			}
		}
		elseif (isset($_REQUEST[$this->get_key()]))
		{
			// Si la valeur en params d'entrée est nulle, mettre celle de la requête.
			if (is_null( $val ))
				$val = $_REQUEST[ $this->get_key() ];
			
			// Mettre à jour le post meta.
			$retour = update_post_meta( $post_id, $this->get_key(), $val );
		}
		
		return $retour;
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
	 * @return Bool
	 */
	public function is_in_columns() { return $this->in_columns; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_saved() { return $this->is_saved; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_hidden() { return $this->is_hidden; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Callable
	 */
	public function get_render_cb() { return $this->render_cb; }
	
	/**
	 * TODO DESCR
	 * 
	 * @return Bool
	 */
	public function is_file_upload() { return $this->is_file_upload; }
	
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
	 * Setter de render_cb.
	 *
	 * @param Callable $render_cb La valeur de la propriété render_cb assigner à l'objet RB_Metadata
	 *
	 * @return Bool Vrai si la valeur du paramètre render_cb a été assignée à l'objet RB_Metadata
	 */
	public function set_render_cb( $render_cb ) 
	{
		$ok = $this->valider_render_cb( $render_cb );
		if ($ok) $this->render_cb = $render_cb;
		return $ok;
	}
	
	/**
	 * Setter de is_file_upload.
	 *
	 * @param Bool $is_file_upload La valeur de la propriété is_file_upload assigner à l'objet is_file_upload
	 *
	 * @return Bool Vrai si la valeur du paramètre is_file_upload a été assignée à l'objet is_file_upload
	 */
	public function set_is_file_upload( $is_file_upload ) 
	{
		$ok = is_bool( $is_file_upload );
		if ($ok) $this->is_file_upload = $is_file_upload;
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
	 * @param $render_cb
	 *
	 * @return bool
	 */
	private function valider_render_cb( $render_cb ) 
	{
		return is_null($render_cb) || is_callable($render_cb);
	}
	//</editor-fold>
}
