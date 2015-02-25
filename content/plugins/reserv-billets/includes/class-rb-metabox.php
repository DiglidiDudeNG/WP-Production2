<?php

class RB_Metabox implements RB_Interface_Metabox
{
	
	const DEFAULT_ID = "rb_metabox_bleh";
	
	// ---
	//<editor-fold desc="// PROPRIÉTÉS POUR « add_metabox »">
	
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
	
	/** @var Bool Le booléen qui détermine s'il screen est un post-type. */
	private $in_post_type = false;
	
	/** @var Array La liste de metadatas qui feront parti de la metabox. */
	private $metadatas;
	
	//</editor-fold>
	// ---
	//<editor-fold desc="// CONSTRUCTEUR ">
	
	/**
	 * Constructeur de l'élément RB_Metabox.
	 *
	 * @param Array $args Les paramètres de l'objet RB_Metabox.
	 */
	function __construct( array $args = null )
	{
		// Déclarer l'objet WP_Error afin de retourner des erreurs.
		$errors = new WP_Error();
		
		// Déclarer l'array des valeurs par défaut.
		$defaults = array(
			// Pour « add_metabox »
			'id' => null,
			'title' => 'Metabox Sans-Nom',
			'show_dashicon' => false,
			'dashicon' => '',
			'screen' => 'main',
			'context' => 'default',
			'priority' => null,
			// Uniques pour la classe.
			'metadatas' => array(),
		);
		
		// Parser les arguments par défaut dans l'array d'arguments de construction de l'objet.
		wp_parse_args( $args, $defaults );
		
		// Effectuer l'ajout de chacune des propriétés de la classe.
		foreach ( $args as $cle => $param )
		{	
			// Si le paramètre a été assigné à notre objet avec succès, passer à la prochaine valeur.
			if ( !call_user_func( array( $this, 'set_' . $cle ), $param ) )
			{
				var_dump( $args );
				// Si ça itère pas à la prochaine valeur, on affiche un erreur.
				wp_die( __( "Le constructeur de <b>" . __CLASS__ . "</b> a retourné une erreur pour l'assignement du param <b>" . $cle . ".</b>" ) );
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
	 *
	 * @return bool|mixed|null
	 */
	public function render( $post )
	{
		// Éviter que quelqu'un puisse éditer s'il a pas les droits.
		if ( ! current_user_can( 'edit_posts' ) )
			return false;
		
		// Pogner toutes les metadonnées.
		$post_metas = get_post_meta( $post->ID );
		
		// Afficher le debugger si on en a besoin.
		if ( WP_DEBUG_DISPLAY )
			var_dump( $post_metas );
		
		// TODO voir « list_meta($metas) » pour l'affichage >>>>>> voir: template.php
		
		return null;
	}
	
	/**
	 * Génère le HTML affiché pour le header.
	 *
	 * @return String Le HTML formé du header de la metabox.
	 */
	public function get_header_html()
	{
		$header_html = "<em>" . $this->get_title() . "</em>";
		
		// Vérifier si la metabox doit afficher un dashicon.
		if ( $this->is_show_dashicon() )
		{
			// Si la classe du dashicon n'est pas vide...
			if ( ! empty( $icon = $this->get_dashicon() ) )
			{
				// Si y'a pas le suffix « dashicon- » dans le nom du dashicon.
				if ( ! strstr( $this->dashicon, 'dashicon-' ) )
				{
					// En mettre un, duh!
					$icon = "dashicon-" . $icon;
				}
			}
			elseif ( $pt_menu_icon = get_post_type_object( $this->get_post_type() )->menu_icon !== null )
			{
				// Sinon, si le menu_icon du post_type a été assigné, l'utiliser tout simplement !
				$icon = $pt_menu_icon;
			}
			else // Sinon, pas le choix, faut afficher le dashicon de base!
			{
				$icon = 'dashicon-';
			}
			
			$header_html .= '<span class="dashicons ' . $icon . '"></span>';
		}
		
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
		return ( $this->screen ? null : $this->get_screen() );
	}
	
	/**
	 * Détermine si la propriété screen de la metabox est le nom d'un post-type existant.
	 *
	 * @return String|false Le nom du post-type impliqué, faux si la metabox n'est pas reliée à un post-type.
	 */
	public function screen_is_post_type()
	{
		// Checker si la propriété « Screen » est aussi le nom d'un post-type enregistré.
		// Retourne le nom du post_type si oui, Faux sinon.
		return get_post_type_object( $this->get_screen() ) !== null;
	}
	
	// </editor-fold>
	// ---
	//<editor-fold desc="// GETTERS">
	
	/**
	 * Getter de la propriété « id » du metabox.
	 *
	 * @return String
	 */
	public function get_id()
	{
		return $this->id;
	}
	
	/**
	 * Getter de la propriété « title » du metabox.
	 *
	 * @return String
	 */
	public function get_title()
	{
		return $this->title;
	}
	
	/**
	 * Getter de la propriété « show_dashicon » du metabox.
	 *
	 * @return Bool Vrai si le dashicon doit être affiché dans le title de la metabox..
	 */
	public function is_show_dashicon()
	{
		return $this->show_dashicon;
	}
	
	/**
	 * Getter de la classe du dashicon.
	 *
	 * @return String La classe du dashicon.
	 */
	public function get_dashicon()
	{
		return $this->dashicon;
	}
	
	/**
	 * Getter de l'écran où est affiché le metabox.
	 *
	 * @return String L'écran où est affiché le metabox.
	 */
	public function get_screen()
	{
		return $this->screen;
	}
	
	/**
	 * Getter du contexte.
	 *
	 * @return String Le contexte.
	 */
	public function get_context()
	{
		return $this->context;
	}
	
	/**
	 * Getter de la priorité.
	 *
	 * @return String La priorité.
	 */
	public function get_priority()
	{
		return $this->priority;
	}
	
	/**
	 * @param string $meta_key Une clé d'un meta.
	 *
	 * @return Array La liste des metadatas.
	 */
	public function get_metadatas( $meta_key = '' )
	{
		// TODO checker dans toutes les meta_keys.
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
		$ok = $this->valider_dashicon( $dashicon );
		
		if ( $ok )
			$this->dashicon = $dashicon;
		
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
		{
			$this->screen = $screen;
			
			if ( $this->screen_is_post_type() )
			{
			}
		}
		
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
	 * @param Array $metadatas
	 * 
	 * @return Bool Vrai si ça a passé.
	 */
	public function set_metadatas( $metadatas )
	{
		if ( is_serialized( $metadatas ) )
			$metadatas = unserialize( $metadatas );
		
		$this->metadatas = $metadatas;
		
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
		// TODO la validation.
		return true;
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
		// TODO la validation.
		return true;
	}
	
	/**
	 * Validateur du dashicon.
	 *
	 * @param String $dashicon La valeur du dashicon à valider.
	 *
	 * @return bool Vrai si le dashicon est valide.
	 */
	private function valider_dashicon( $dashicon )
	{
		// TODO la validation.
		return true;
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
		// TODO la validation.
		return true;
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
