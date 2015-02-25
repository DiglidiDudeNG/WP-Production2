<?php

class RB_Metabox implements RB_Interface_Metabox
{
	const DEFAULT_ID = "rb_metabox_bleh"; 
	
	/** @var String
	 * L'identifiant du post type.
	 */
	public $post_type;
	
	/** @var String L'attribut ID affiché dans le rendu HTML. */
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
	 * Le nom de la fonction appelée qui va afficher le HTML intérieur.
	 */
	private $callback_tag;
	
	/** @var String
	 * Le contexte. ex: 'side', 'normal' ou 'advanced'
	 */
	private $context;
	
	/** @var String 
	 * La priorité. ex: 'core' 
	 */
	private $priority;
	
	/**
	 * Constructeur de l'élément RB_Metabox.
	 *
	 * @param String $post_type L'identifiant du post type. Doit être sans le slug du plugin.
	 * @param Array  $args      {
	 *      Les arguments pour le metabox.
	 *      
	 *      @type 
	 * }
	 */
	function __construct( $post_type, array $args)
	{
		$this->post_type = $post_type;
		
		$defaults = array(
			'id'            => 'rb_metabox_bleh',
			'title'         => 'Metabox Sans-Nom',
			'show_dashicon' => false,
			'dashicon'      => '',
			'callback_tag'  => null,
			'screen'        => $post_type,
			'context'       => 'default',
			'priority'      => null,
			'metadatas'     => array(),
		);
		
		// Vérifier si l'id existe.
		if ( empty( $metabox['id'] ) )
		{
			// Si c'est pas un array, on affiche un msg d'erreur.
			wp_die( __( "Les tables associatives des metaboxes doivent être formées correctement." ) );
		}
		
		// Vérifier si le title est une string et qu'il n'est pas vide.
		// TODO: Probablement assigner un template pour les titles, vu que c'est essentiellement composé de HTML.
		if ( ! array_key_exists( 'title', $metabox ) || ! is_string( $metabox['title'] )  )
		{
			// Si c'est pas un title valide, on affiche un message d'erreur.
			wp_die( __( "Le titre de vos metaboxes doivent être formés correctement." ) );
		}
	}
	
	/**
	 * Ajoute la Metabox dans l'environement Wordpress.
	 * 
	 * @return bool Vrai si l'ajout a été un succès, faux sinon.
	 */
	public function add()
	{
		$metabox_title = $this->get_title();
		
		// S'il faut afficher le dashicon dans la metabox courante, mettre le HTML requis!
		// TODO: adapter ça pour les templates.
		if ( $this->has_dashicon() )
		{
			if ( !empty( $metabox['dashicon'] ) )
			{
				$icon_class = $metabox['dashicon'];
				
				if ( !strstr( $metabox['dashicon'], 'dashicon-' ) )
				{
					$icon_class = "dashicon-" . $icon_class;
				}
			}
			else
			{
				
			}
			
			$metabox_title .= '<span class="dashicons ' . $icon_class . '"></span>';
		}
		
		// Former le titre de la metabox.
		
		
		// Définir la base du format du nom du callback.
		$base_sprint_callback_fn = 'render_%s_metabox';
		
		// Formater le nom du callback d'affichage.
		$formatted_callback_fn = sprintf( $base_sprint_callback_fn, $this->post_type . "_" . $metabox['callback_tag'] );
		
		// Déclarer le callback à inclure dans les arguments.
		$metabox_callback = null;
		
		// Vérifier si le callback n'est pas vide.
		if ( ! empty( $metabox['callback_tag'] ) )
		{
			// Si la méthode n'existe pas, mettre un callback par défaut.
			if ( !method_exists( $this, $formatted_callback_fn ) )
			{
				// Définir le nom de la fonction de callback.
				$formatted_callback_fn = sprintf( $base_sprint_callback_fn, "default" );
			}
			
			// Définir le nom de la fonction de callback.
			$metabox_callback = array( $this, $formatted_callback_fn );
		}
		else
		{
			wp_die( __( "La méthode de callback de l'affichage de la metabox ".$metabox['title']." est invalide !" ) );
		}
		
		// Ajouter la meta-box.
		add_meta_box(
			$metabox['id'],      // Attribut « id » dans la balise.
			$metabox_title,      // Titre dans le header du metabox.
			$metabox_callback,   // Callback qui va echo l'affichage.
			$this->post_type,    // L'écran où est affiché le meta-box.
			$metabox['context'], // Le contexte. ex. "side", "normal" ou "advanced".
			$metabox['priority'] // La priorité.
		// TODO: Savoir si on doit inclure les callback_args.
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
		
		// Voir si la fonction existe.
		if ( function_exists( sprintf( 'render_%s_info_metabox', $this->post_type ) ) )
		{
			return call_user_func( array( $this, sprintf( 'render_%s_info_metabox', $this->post_type ) ), $post );
		}
		else
		{
			// Pogner toutes les metadonnées.
			$post_metas = get_post_meta( $post->ID );
			
			// Afficher le debugger si on en a besoin.
			if ( WP_DEBUG_DISPLAY )
				var_dump( $post_metas );
			
			return null;
		}
	}
	
	/**
	 * 
	 * 
	 * @return String
	 */
	public function get_id()
	{
		return $this->id;
	}
	
	/**
	 * 
	 * 
	 * @return String
	 */
	public function get_title()
	{
		return $this->title;
	}
	
	/**
	 * 
	 * 
	 * @param String $title
	 */
	public function set_title( $title )
	{
		$this->title = $title;
	}
	
	/**
	 * Retourne vrai si le dashicon est affiché dans le title de la metabox.
	 * 
	 * @return Bool Vrai si le dashicon doit être affiché dans le title de la metabox..
	 */
	public function has_dashicon()
	{
		return $this->show_dashicon;
	}
}
