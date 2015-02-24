<?php

/**
 * Class RB_Metadata
 * 
 * Un objet Metadata, permettant d'alléger le code dans RB_Admin.
 */
abstract class RB_Metadata
{
	// Définir les constantes.
	const DEF_TYPE = 'type';
	const DEF_NAME = 'Metadata sans-non';
	const DEF_DEFAULT = '';
	const DEF_VALIDATE_CB = '';
	
	/** @var String Le type d'input. */
	public $type;
	
	/** @var String Le nom référé dans l'interface. */
	public $name;
	
	/** @var String La valeur par défaut. */
	protected $default;
	
	/** @var String La fonction de callback de la validation de la metadata. Vide si y'en a pas. */
	private $validate_cb;
	
	/** @var Bool Vrai si la valeur doit être sauvegardée. */
	private $is_saved;
	
	/** @var Bool Vrai si la metadata doit se retrouver dans les colonnes dans le panneau d'admin. */
	public $in_columns;
	
	/** @var Bool Vrai si c'est une référence à une valeur ailleurs, pognée par un WP_Query. */
	private $is_query;
	
	/** @var Array Les arguments du WP_Query. */
	private $args_query;
	
	/**
	 * Constructeur de Metadata.
	 *
	 * @param String $post_type Le type de post relié.
	 * @param Array  $args      Les arguments.
	 */
	function __construct( $post_type, $args )
	{
		
	}
	
	
}
