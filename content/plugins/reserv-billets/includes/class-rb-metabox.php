<?php

/**
 * Class RB_Metabox
 * 
 * L'objet Metabox qui crée et manage les metabox.
 * 
 * @property-read String 
 */
class RB_Metabox
{
	const DASHICON_VALIDE_MAIS_SANS_PREFIXE = 2;
	
	const DEFAULT_ID = "rb_metabox_bleh";
	const DEFAULT_TITLE = 'Metabox Sans-Nom';
	const DEFAULT_SHOW_DASHICON = false;
	const DEFAULT_DASHICON = '';
	const DEFAULT_SCREEN = 'main';
	const DEFAULT_CONTEXT = 'default';
	const DEFAULT_PRIORITY = null;
	const DEFAULT_METADATAS = null;
	
	// ---
	//<editor-fold desc="// PROPRIÉTÉS POUR LE CONSTRUCTEUR">
	
	/** @var String
	 * L'attribut ID affiché dans le rendu HTML.
	 */
	private $id;
	
	/** @var String
	 * Le texte affiché dans le header de la metabox.
	 */
	private $title;
	
	/** @var Bool
	 * Vrai si le Dashicon doit être affiché après le titre de la metabox.
	 */
	private $show_dashicon;
	
	/** @var String
	 * La classe du dashicon à afficher.
	 * Si vide, ce sera celle définie à la racine des args.
	 */
	private $dashicon;
	
	/** @var String
	 * L'écran où sera affiché le metabox.
	 * Peut avoir la valeur d'un post_type.
	 */
	private $screen;
	
	/** @var String
	 * Le contexte. ex: 'side', 'normal' ou 'advanced'
	 */
	private $context;
	
	/** @var String
	 * La priorité. ex: 'core'
	 */
	private $priority;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// PROPRIÉTÉS UNIQUES DE LA CLASSE">
	
	/** @var Bool Le booléen qui détermine si le screen est un post-type. */
	private $in_post_type = false;
	
	/** @var Array La liste de metadatas qui feront parti de la metabox. */
	private $metadatas;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// CONSTRUCTEUR ">
	
	/**
	 * Constructeur de l'élément RB_Metabox.
	 *
	 * @param Array  $args      Les paramètres de l'objet RB_Metabox.
	 * @param String $post_type Le nom unique du post_type.
	 */
	function __construct( array $args, $post_type )
	{
		// Déclarer l'objet WP_Error afin de retourner des erreurs.
		$errors = new WP_Error();
		
		// Déclarer l'array des valeurs par défaut.
		$defaults = array(
			// Pour « add_metabox »
			'id' => self::DEFAULT_ID,
			'title' => self::DEFAULT_TITLE,
			'show_dashicon' => self::DEFAULT_SHOW_DASHICON,
			'dashicon' => self::DEFAULT_DASHICON,
			'screen' => self::DEFAULT_SCREEN,
			'context' => self::DEFAULT_CONTEXT,
			'priority' => self::DEFAULT_PRIORITY,
			'metadatas' => self::DEFAULT_METADATAS,
		);
		
		// Parser les arguments par défaut dans l'array d'arguments de construction de l'objet.
		$args = wp_parse_args( $args, $defaults );
			
			// Effectuer l'ajout de chacune des propriétés de la classe.
		foreach ( $args as $cle => $param )
		{
			try 
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
			catch (BadMethodCallException $e) 
			{
				// TODO catching.
			}
		}
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// MÉTHODES QUI AFFECTENT WORDPRESS DIRECTEMENT">
	
	/**
	 * Ajoute la Metabox dans l'environement Wordpress.
	 * 
	 * @return bool Vrai si l'ajout a été un succès, faux sinon.
	 */
	public function add()
	{
		// Ajouter la meta-box.
		add_meta_box(
			$this->get_id(),          // Attribut « id » dans la balise.
			$this->get_header_html(), // Titre dans le header du metabox.
			array( $this, 'render' ), // Callback qui va echo l'affichage de la metabox.
			$this->get_screen(),      // L'écran où est affiché le meta-box.
			$this->get_context(),     // Le contexte. ex. "side", "normal" ou "advanced".
			$this->get_priority()     // La priorité d'ajout de la metabox.
		);
		
		// TODO: faire un remove_meta_box() durant la désactivation.
	}
	
	/**
	 * Effectue le rendu du contenu de la metabox.
	 * 
	 * @param WP_Post $post Instance du post.
	 */
	public function render( $post )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) )
			wp_die( __( "Vous n'êtes pas autorisé à éditer les posts du type <b>".$post->post_type."</b>." ) );
		
		if ( $this->get_context() == 'side' )
		{
			/** @var RB_Metadata $meta */
			foreach ( $this->metadatas as $meta ) :
				echo '<p><label for="'.$meta->get_key().'">'.$meta->get_label().' :</label></p><p class="">';
				echo call_user_func( $meta->get_render_cb(), $post->ID, $meta );
				echo "</p>";
			endforeach;
		}
		else
		{
			echo '<table width="100%">';
			/** @var RB_Metadata $meta */
			foreach ( $this->metadatas as $meta ) :
				echo '<tr><td><label for="'.$meta->get_key().'">'.$meta->get_label().' :</label></td><td>';
				echo call_user_func( $meta->get_render_cb(), $post->ID, $meta );
				echo "</td></tr>";
			endforeach;
			echo '</table>';
		}
		
		
	}
	
	/**
	 * Génère le HTML affiché pour le header.
	 *
	 * @return String Le HTML formé du header de la metabox.
	 */
	public function get_header_html()
	{
		$header_html = '<span class="dashicons ' . $this->get_dashicon() . '"></span> ' . $this->get_title();
		
		// Retourner le HTML formé du header de la metabox.
		return $header_html;
	}
	
	/**
	 * Le post-type auquel la metabox est assignée.
	 *
	 * Essentiellement, ça pogne la propriété « Screen » pis ça la retourne.
	 *
	 * @return String|false Le nom du post-type impliqué, faux si la metabox n'est pas reliée à un post-type.
	 */
	public function get_post_type()
	{
		return ( post_type_exists( $this->get_screen() ) ? $this->get_screen() : false );
	}
	
	// </editor-fold>
	// ---
	//<editor-fold desc="// GETTERS">
	
	/**
	 * Getter de la propriété « id » du metabox.
	 *
	 * @return String
	 */
	public function get_id() { return $this->id; }
	
	/**
	 * Getter de la propriété « title » du metabox.
	 *
	 * @return String
	 */
	public function get_title() { return $this->title; }
	
	/**
	 * Getter de la propriété « show_dashicon » du metabox.
	 *
	 * @return Bool Vrai si le dashicon doit être affiché dans le title de la metabox..
	 */
	public function is_show_dashicon() { return $this->show_dashicon; }
	
	/**
	 * Getter de la classe du dashicon.
	 *
	 * @return String La classe du dashicon.
	 */
	public function get_dashicon() { return $this->dashicon; }
	
	/**
	 * Getter de l'écran où est affiché le metabox.
	 *
	 * @return String L'écran où est affiché le metabox.
	 */
	public function get_screen() { return $this->screen; }
	
	/**
	 * Getter du contexte.
	 *
	 * @return String Le contexte.
	 */
	public function get_context() { return $this->context; }
	
	/**
	 * Getter de la priorité.
	 *
	 * @return String La priorité.
	 */
	public function get_priority() { return $this->priority; }
	
	/**
	 * @param string $meta_key Une clé d'un meta.
	 *
	 * @return Array La liste des metadatas.
	 * @throws \ErrorException
	 */
	public function get_metadata_by_key( $meta_key )
	{
		var_dump($this->metadatas);
		if ( !empty( $meta_key ) && array_key_exists( $meta_key, $this->metadatas ) )
			return $this->metadatas[$meta_key];
		else
			throw new ErrorException( "« " . $meta_key . " » n'est pas une clé de metadata existant!" );
	}
	
	/**
	 * Retourne toutes les metadatas.
	 * 
	 * @return Array
	 */
	public function get_all_metadatas() 
	{
		return $this->metadatas;
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// SETTERS">
	
	/**
	 * Setter de l'ID.
	 *
	 * @param String $id La valeur de l'ID.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_id( $id )
	{
		$ok = $this->valider_id( $id );
		
		if ( $ok )
			$this->id = $id;
		
		return $ok;
	}
	
	/**
	 * Setter du title.
	 *
	 * @param String $title La valeur du titre.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_title( $title )
	{
		$ok = $this->valider_title( $title );
		
		if ( $ok )
			$this->title = $title;
		
		return $ok;
	}
	
	/**
	 * Setter de l'affichage du dashicon.
	 *
	 * @param String $show_dashicon La valeur déterminant s'il faut afficher le dashicon.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_show_dashicon( $show_dashicon )
	{
		$ok = is_bool( $show_dashicon );
		
		if ( $ok )
			$this->show_dashicon = $show_dashicon;
		
		return $ok;
	}
	
	/**
	 * Setter de la classe du dashicon.
	 *
	 * @param String $dashicon La valeur de la classe du dashicon.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_dashicon( $dashicon )
	{
		// Effectuer la vérification de base.
		$ok = $this->valider_dashicon( $dashicon );
		
		// Valeur de show_dashicon.
		$must_show_dashicon = $this->is_show_dashicon();
		
		// Si on ne doit pas afficher de dashicon, éviter de le faire!
		if ( !$must_show_dashicon )
		{
			// Mettre le dashicon à null.
			$this->dashicon = ''; // TODO mettre une constante par défaut.
			
			// Prétendre que la vérification fut un succès, ni vu ni connu!
			return true;
		}
		elseif ( $ok ) // Si on doit afficher le dashicon, vérifier si le dashicon est valide.
		{
			$dash_exploded = explode( '-', $dashicon );
			
			if ( !strstr( $dashicon, 'dashicons-' ) )
				$dashicon = "dashicons-" . $dashicon;
			elseif ( $dash_exploded[0] != "dashicons" )
				$dashicon = "dashicons-" . $dash_exploded[count( $dash_exploded )];
			
			$this->dashicon = $dashicon;
		}
		else
		{
			$ok = true;
			$pt_obj = get_post_type_object( $this->get_screen() );
			$this->dashicon = $pt_obj ? $pt_obj->menu_icon : 'dashicons-info';
		}
		
		return $ok;
	}
	
	/**
	 * Setter de l'écran.
	 *
	 * @param String $screen La valeur de l'écran.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_screen( $screen )
	{
		$ok = $this->valider_screen( $screen );
		
		if ( $ok )
			$this->screen = $screen;

		return $ok;
	}
	
	/**
	 * Setter du contexte.
	 *
	 * @param String $context La valeur du contexte.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_context( $context )
	{
		$ok = $this->valider_context( $context );
		
		if ( $ok )
			$this->context = $context;
		
		return $ok;
	}
	
	/**
	 * Setter de la priorité.
	 *
	 * @param String $priority La valeur de la priorité.
	 *
	 * @return bool Vrai si la valeur a été assignée à l'objet courant avec succès.
	 */
	public function set_priority( $priority )
	{
		$ok = $this->valider_priority( $priority );
		
		if ( $ok )
			$this->priority = $priority;
		
		return $ok;
	}
	
	/**
	 * @param RB_Metadata $metadata_inst Une instance de la metadata.
	 * 
	 * @return Bool Vrai si ça a passé.
	 */
	public function add_metadata( $metadata_inst )
	{
		if ( is_serialized( $metadata_inst ) )
			$metadata_inst = unserialize( $metadata_inst );
		
		$this->metadatas[] = $metadata_inst;
		
		// TODO la validation.
		return true;
	}
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// VALIDATEURS">
	
	/**
	 * Validateur de l'ID.
	 *
	 * @param String $id La valeur de l'ID à valider.
	 *
	 * @return bool Vrai si l'ID est valide.
	 */
	private function valider_id( $id )
	{
		return is_string($id) && !empty($id);
	}
	
	/**
	 * Validateur du title.
	 *
	 * @param String $title La valeur du title à valider.
	 *
	 * @return bool Vrai si le title est valide.
	 */
	private function valider_title( $title )
	{
		return is_string($title) && !empty($title);
	}
	
	/**
	 * Validateur du dashicon.
	 *
	 * @param String $dashicon La valeur du dashicon à valider.
	 *
	 * @return bool Vrai si le dashicon est valide, Faux sinon.
	 */
	private function valider_dashicon( $dashicon )
	{
		return is_string( $dashicon ) && !empty( $dashicon );
	}
	
	/**
	 * Validateur de l'écran.
	 *
	 * @param String $screen La valeur de l'écran
	 *
	 * @return Bool Vrai si l'écran est valide.
	 */
	private function valider_screen( $screen )
	{
		// Vérifier si la metabox doit afficher un dashicon.
		return  !empty($screen) && is_string($screen) && post_type_exists( $screen )
		        || !empty($screen) && is_string($screen);
	}
	
	/**
	 * Validateur du contexte.
	 *
	 * @param String $context La valeur du contexte à valider.
	 *
	 * @return bool Vrai si le contexte est valide.
	 */
	private function valider_context( $context )
	{
		// TODO la validation.
		return true;
	}
	
	/**
	 * Validateur de la priorité.
	 *
	 * @param String $priority La valeur de la priorité à valider.
	 *
	 * @return Bool Vrai si la priorité est valide.
	 */
	private function valider_priority( $priority )
	{
		// TODO la validation.
		return true;
	}
	
	/**
	 * Validateur des metadatas.
	 *
	 * @param array $metadatas L'array des metadatas.
	 *
	 * @return string|Bool Vrai si elles ont toutes
	 */
	private function valider_metadatas( $metadatas )
	{
		foreach ( $metadatas as $key => $metadata )
		{
			$valide = true;
			
			// TODO compléter la validation des metadatas.
			
			if ( ! $valide )
			{
				if ( is_int( $key ) )
				{
					$key = strval( $key );
					
					if ( is_array( $metadata ) )
					{
						$key = $metadata;
					}
				}
				
				// Retourner la clé.
				return $key;
			}
		}
		
		// Retourner vrai si tout s'est bien passé.
		return true;
	}
	
	//</editor-fold>	
	// ---
}
