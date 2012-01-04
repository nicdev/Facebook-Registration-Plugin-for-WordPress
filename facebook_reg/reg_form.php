<div id="fb-reg-facebook-registration" style="display:none">
<iframe src="https://www.facebook.com/plugins/registration.php?
client_id=<?php echo get_option( 'fb_reg_app_id' ); ?>&
redirect_uri=<?php echo urlencode( get_option( 'fb_reg_redir_uri' ) ); ?>&
fields=<?php echo stripslashes( get_option( 'fb_reg_json_fields' ) ); ?>"
scrolling="auto"
frameborder="no"
style="border:none"
allowTransparency="true"
width="100%"
height="650">
</iframe>
</div>
<div id="fb-root"></div>
