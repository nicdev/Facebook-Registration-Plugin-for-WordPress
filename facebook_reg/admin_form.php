<div class="wrap">
	
	<!-- Presentation -->
	
	<div class="icon32" id="icon-users"><br></div>
	
	<h2>Facebook Registration Settings</h2>

	<p>Set up Facebook registration preferences</p>
	
	
	<!-- Options -->
	
	<form method="post" action="">
		<?php wp_nonce_field( 'fb_reg_settings', 'fb_reg_nonceschmonce', FALSE, TRUE ) ?> 	
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="app_secret">Application Secret <span class="description">(required)</span></label></th>
					<td><input type="text" aria-required="true" name="app_secret" value="<?php echo esc_attr( get_option( 'fb_reg_app_secret' ) ); ?>" ></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="app_id">Application ID <span class="description">(required)</span></label></th>
					<td><input type="text"  name="app_id" value="<?php echo esc_attr( get_option( 'fb_reg_app_id' ) ); ?>" ></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="app_id">Redirect URI <span class="description">(required)</span></label></th>
					<td><input type="text"  name="redirect_uri" value="<?php echo esc_attr( get_option( 'fb_reg_redir_uri' ) ); ?>" ></td>
				</tr>
				<tr>
					<?php $checked = ( get_option( 'fb_reg_auto_login' ) == 1 ) ? 'checked="true"' : ''; ?>
					<th scope="row"><label for="auto_login">Auto-login after registration </label></th>
					<td><label for="auto_login"><input type="checkbox" id="auto_login" name="auto_login" value="1" <?php echo $checked; ?> ></label></td>
				</tr>
				<tr>
					<th scope="row"><label for="custom_fields">Custom fields (careful what you change here, it can break stuff.)</label></th>
					<td><textarea cols="130" rows="10" id="description" name="custom_fields"><?php echo esc_textarea( stripslashes( get_option( 'fb_reg_json_fields' ) ) ); ?></textarea><br></td>
				</tr>
		
			</tbody>
		</table>
	
		<p class="submit"><input type="submit" value="Update Settings" class="button-primary" id="" name="submit_fb_reg_settings"></p>
	
	</form>
	
</div>