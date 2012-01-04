<?php

class Fb_reg{

	public function __construct(){
	
	}
	
	/*********************************************************************************************************************
		
	Intialization script
		
	*********************************************************************************************************************/
	
	public function install_init(){
	
		$fb_reg_json = '[{\'name\':\'name\'},
						 {\'name\':\'username\',\'description\':\'Username\',\'type\':\'text\'},
						 {\'name\':\'email\'},
						 {\'name\':\'password\'}]"';
						 
		update_option( 'fb_reg_json_fields', $fb_reg_json );
	
	}
	
	/*********************************************************************************************************************
		
	Registration form
		
	*********************************************************************************************************************/
	
	public function registration_form(){
	
		include( __DIR__ . '/reg_form.php' );
	
	}
	
	/*********************************************************************************************************************
		
	Change registration links
		
	*********************************************************************************************************************/
	
	function change_reg_link( $content = null ){
		
		if( ! empty( $content ) )
		{
		
			//We only want to load the FB registration form where there is a registration link, so it's
			//a good idea to piggy back on this filter to include the form.
			self::registration_form();
			
			$content = '<a href="TB_inline?height=400&width=400&inlineId=fb-reg-facebook-registration" id="fb_reg_registration_link" class="thickbox" >Register</a>';
		
		}
		
		return $content;
	
	}
	
	/*********************************************************************************************************************
	
	Process FB registration form
	
	*********************************************************************************************************************/

	public function register_user(){
	
		//Check whether we are doing a registration
		
		if( isset( $_REQUEST['signed_request'] ) && ! empty( $_REQUEST['signed_request'] ) )
		{

			global $wpdb;
			
			$response = self::parse_signed_request($_REQUEST['signed_request'], get_option( 'fb_reg_app_secret' ) );
				
			//Attempt to create user with the information provided
			$user_id = username_exists( $response['registration']['username'] );
			
			if ( ! $user_id ) 
			{
				
				$username = $response['registration']['username'];
				$password = $response['registration']['password'];
				$email = $response['registration']['email'];
				
				$user_id = wp_create_user( $username, $password, $email );
				
				if( ! empty( $user_id ) && ! is_wp_error( $user_id ) )  //Add additional parameters
				{
				
					update_usermeta( $user_id, 'name', $response['registration']['name'] );
					update_usermeta( $user_id, 'dob', $response['registration']['birthday']);
					update_usermeta( $user_id, 'gender', $response['registration']['gender']);
					update_usermeta( $user_id, 'phone', $response['registration']['phone']);
					
					if( isset( $response['user_id']) && ! empty ($response['user_id'] ) )
					{
						
						update_usermeta( $user_id, 'fb_id', $response['user_id']);
					
					}
					
					//Log it in?
					
					if( get_option( 'fb_reg_auto_login' ) == 1 )
					{
					
						$creds = array( 'user_login' => $username, 'user_password' => $password, 'remember' => true );
						$user = wp_signon( $creds, false );
						
						if ( is_wp_error($user) ) //Error login on
						{
							
						   return $user;
						
						}
						else //Logged in successfully
						{
							/*
								Let's discuss this. No, I don't like forcing the refresh, I much rather let the user come
								back and log in on their own. The requirement is to auto-login, and for that, we need to 
								make sure those cookies are active
							*/
						
							wp_redirect( home_url(), 302 ); 
							
							return TRUE;
						
						}	
					
					}
									  					
					return TRUE; //All registered and logged in
					
				}
				
				return new WP_Error('registration_error', __("Unable to register, please try again."));
				
			}
			else
			{
				
				return new WP_Error('registration_error', __("The username is already in use"));
			
			}
			
			return FALSE; //Something went wrong
			
		} 
			
	}
	
	/*********************************************************************************************************************
		
	Admin interface
		
	*********************************************************************************************************************/
	
	function register_menu(){
	
		add_submenu_page( 'users.php', 'FB Registration Settings', 'FB Registration Settings', 
		                  'add_users', 'fb-reg-settings', array( 'Fb_reg', 'admin_menu' ) );
	
	}
	
	function admin_menu(){
		
		if( isset( $_POST['fb_reg_nonceschmonce'] ) ) //Form submitted
		{
			
			//Verify nonce
			$nonce = $_POST['fb_reg_nonceschmonce'];
			
			if( ! wp_verify_nonce( $nonce, 'fb_reg_settings' ) )
			{
				
				die( 'Whoa there!' );
			
			}
			
			update_option( 'fb_reg_app_secret', $_POST['app_secret'] );
			update_option( 'fb_reg_app_id', $_POST['app_id'] );
			update_option( 'fb_reg_redir_uri', $_POST['redirect_uri'] );
			update_option( 'fb_reg_auto_login', $_POST['auto_login'] );
			update_option( 'fb_reg_json_fields', $_POST['custom_fields'] );
		
		}
		
		//Load up the form
		
		include( __DIR__ . '/admin_form.php' );
	
	}
	
	/*********************************************************************************************************************
		
	Queue up necessary JS
		
	*********************************************************************************************************************/
	
	function script_queuer(){
	
		//Included in WP
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		
		//Included in plugin
		wp_register_script( 'fb_reg_js', plugins_url( 'js/fb_reg.js' , __FILE__ ), array( 'jquery', 'thickbox' ), FALSE, TRUE);
		wp_enqueue_script( 'fb_reg_js');
		
	}
			
	/*********************************************************************************************************************
	
	Parse FB signed request
	Thank you FB for thiese code snippets http://developers.facebook.com/docs/authentication/signed_request/
	If you are using this plugin in production, it can probably use some more work. Contributions welcome.
	
	*********************************************************************************************************************/
				
	function parse_signed_request($signed_request, $secret) {
	
			  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
			
			  // decode the data
			  $sig = self::base64_url_decode($encoded_sig);
			  $data = json_decode(self::base64_url_decode($payload), true);
			
			  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			    error_log('Unknown algorithm. Expected HMAC-SHA256');
			    return null;
			  }
			
			  // check sig
			  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
			  if ($sig !== $expected_sig) {
			    error_log('Bad Signed JSON signature!');
			    return null;
			  }
			
			  return $data;
	}
				
	/*********************************************************************************************************************
	
	Base 64 decoding for FB signed request
	
	*********************************************************************************************************************/
	
	function base64_url_decode($input) {
	
	    return base64_decode(strtr($input, '-_', '+/'));
	
	}
				



} //End class	


?>