<?php
/**
 * rb-interface-metabox.php
 * 
 * Project: WP-Production2
 * User:    Félix Dion Robidoux
 * Date:    25/02/2015
 * Time:    11:08 AM
 */

/**
 * L'interface des objets RB_Metabox.
 */
interface RB_Interface_Metabox
{
	/**
	 * @return mixed
	 */
	public function add();
	
	public function render( $post );
}
