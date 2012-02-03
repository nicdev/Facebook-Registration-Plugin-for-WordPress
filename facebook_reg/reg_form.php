<div id="fb-reg-facebook-registration" style="display:none">
<iframe src="<?php echo esc_url( 'https://www.facebook.com/plugins/registration.php?
client_id=' . get_option( 'fb_reg_app_id' ) . '&
redirect_uri=' . urlencode( get_option( 'fb_reg_redir_uri' ) ). '&
fields=' . stripslashes( get_option( 'fb_reg_json_fields' ) ) ); ?>"
scrolling="auto"
frameborder="no"
style="border:none"
allowTransparency="true"
width="100%"
height="650">
</iframe>
</div>
<div id="fb-root"></div>
