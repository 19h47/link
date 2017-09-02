<?php 

/** 
 * Form fields
 *
 * @author     Levron Jérémy <levronjeremy@19h47.fr>
 */
?>
<script type='text/javascript'>
console.log('yo');
            jQuery(document).ready(function($) {
                $('.link_color_field').wpColorPicker();
            });
        </script>
<table class="form-table">
	
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
				class="link_url_field" 
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
				class="link_color_field" 
				name="link_color" 
				placeholder="<?php _e( '', 'run' ) ?>" 
				value="<?php echo esc_html( $link_color ) ?>"
			>
		</td>
	</tr>
	
</table>