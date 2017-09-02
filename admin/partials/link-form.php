<?php 

/** 
 * Form fields
 *
 * @author     Levron Jérémy <levronjeremy@19h47.fr>
 */
?>
<table class="form-table">

	<!-- Description -->
	<tr>
		<th scope="row">
			<label for="link_description" class="link_description_label">
				<?php _e( 'Description', 'link' ) ?>
			</label>
		</th>
		<td>

			<textarea
				class="link_description_field large-text" 
				type="url" 
				cols="80" 
				rows="10"
				id="link_description" 
				name="link_description" 
			><?php echo esc_html( $link_description ) ?></textarea>
		</td>
	</tr>
	
	<!-- URL -->
	<tr>
		<th>
			<label for="link_url" class="link_url_label">
				<?php _e( 'URL', 'link' ) ?>
			</label>
		</th>
		<td>
			<input 
				type="url" 
				id="link_url" 
				name="link_url" 
				class="link_url_field large-text" 
				placeholder="<?php _e( '', 'run' ) ?>" 
				value="<?php echo esc_html( $link_url ) ?>"
			>
		</td>
	</tr>

	
	<!-- Colorpicker -->
	<tr>
		<th>
			<label for="link_color" class="link_color_label">
				<?php _e( 'Couleur', 'link' ) ?>
			</label>
		</th>
		<td>

			<input 
				type="text" 
				id="link_color" 
				class="link_color_field large-text" 
				name="link_color" 
				placeholder="<?php _e( '', 'link' ) ?>" 
				value="<?php echo esc_html( $link_color ) ?>"
			>
		</td>
	</tr>
	
</table>