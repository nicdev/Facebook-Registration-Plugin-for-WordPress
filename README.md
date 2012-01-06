# Facebook Registration for WordPress v.0.2 #

This is not for Facebook Connect, it's for the [Facebook Registration Plugin](http://developers.facebook.com/docs/plugins/registration/), which is the red-headed step-child of Facebook's social plugin family. Once installed, the plugin will add Facebook registration in place of the usual WordPress form, however, all registrations will create a normal WordPress user.

### 1-3-2012 ###
Initial release. 

No documentation yet, here's the short story:

* Get a Facebook application registered. Not sure how? Check out the [FB documentation](http://developers.facebook.com/docs/)
* Get the application ID, application secret and redirect URI.
	* The redirect URI is set by you. You can simply point it to the home page of your WordPress site.
* Install the plugin, browse to Users > FB Registration Settings.
* Fill out the fields.
* Ta da!

[Need a demo?](http://fbreg.epiclabs.com/)

### Future plans ###

This is a very early release, that's why it's only available in Github and hasn't been submitted to the official WordPress directory. 

Future releases will include the following, although I'd love to get some feedback and figure out what else should be included.


* ~~Error messages.~~
* Easier field selection (without editing the JSON object directly.)
* Customization of aesthetic options.
* Email newly registered users.
* Clean up options on uninstall.
* Proper documentation.
* A landing page for the plugin and docs.