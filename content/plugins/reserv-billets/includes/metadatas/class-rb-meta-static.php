<?php

/**
 * Class RB_Static_Meta
 * 
 * Une metadata statique.
 */
class RB_Static_Metadata extends RB_Metadata
{
	
	/**
	 * @param String $post_type
	 * @param Array  $args
	 */
	public function __construct( $post_type, $args )
	{
		// Appeler le constructeur parent.
		parent::__construct( $post_type, $args );
	}
}
