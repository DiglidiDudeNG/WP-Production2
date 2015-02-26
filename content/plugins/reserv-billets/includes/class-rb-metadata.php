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
	private $type;
	private $name;
	private $default;
	private $in_columns;
	private $is_query;
	private $query;
	
	/**
	 * Constructeur d'un objet Metadata.
	 *
	 * @param array $args Les arguments de l'objet.
	 */
	function __construct( array $args )
	{
		$defaults = array(
			
		);
	}
	
	/**
	 * @param $update_type
	 */
	public function update( $update_type )
	{
		
	}
	
	// TODO coder cette classe.
}
