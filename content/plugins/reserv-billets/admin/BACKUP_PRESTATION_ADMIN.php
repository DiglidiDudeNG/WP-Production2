<?php
/**
 * BACKUP_PRESTATION_ADMIN.php
 * 
 * Project: WP-Production2
 * User:    Félix Dion Robidoux
 * Date:    19/02/2015
 * Time:    4:04 PM
 */

/**
 * @param WP_Post $prestation
 */
public function render_info_meta_box($prestation)
{
	// Éviter que quelqu'un puisse éditer s'il a pas les droits.
	if ( ! current_user_can( 'edit_posts' ) )
		return;
	
	// Pogner toutes les metadonnées.
	$prestation_metas = get_post_meta( $prestation->ID );
	
	// Afficher le debugger si on en a besoin.
	if ( WP_DEBUG_DISPLAY )
		var_dump( $prestation_metas );
	
	?>
	<table width="100%">
	<tr>
	<td style="width: 25%"><label for="rb_prestation_spectacle_id"><?=__('Spectacle')?> :</label></td>
	<td>
	<select style="width: 95%" name="rb_prestation_spectacle_id" id="rb_prestation_spectacle_id">
	<?php
	/** @var WP_Query $loop_spectacles */
	$loop_spectacles = new WP_Query( ['post_type' => 'spectacle', 'posts_per_page' => -1]);
	
	while ($loop_spectacles->have_posts()) :
		$loop_spectacles->the_post(); ?>
		<option value="<?php the_ID(); ?>" <?php
		selected( $prestation_metas['rb_prestation_spectacle_id'][0], get_the_ID() );
		?>><?php the_title(); ?></option>
	<?php endwhile; ?>
	</select>
	</td>
	<td rowspan="3" style="width: 50%; background-color: #aaa; border-radius: 8px;" id="rb_preview_spectacle">
	
	</td>
	</tr>
	<tr>
		<td><label for="rb_prestation_date"></label><?=__('Date de la Prestation')?> :</td>
		<td><input type="date" id="rb_prestation_date" name="rb_prestation_date" value="<?=$prestation_metas['rb_prestation_date'][0]?>" /></td>
	</tr>
	<tr>
		<td><label for="rb_prestation_heure"></label><?=__('Heure de la Prestation')?> :</td>
		<td><input type="time" id="rb_prestation_heure" name="rb_prestation_heure" value="<?=$prestation_metas['rb_prestation_heure'][0]?>" /></td>
	</tr>
	</table>
<?php
}
