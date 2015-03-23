<?php
return array (
  'status' => 
  array (
    'enabled' => 'yes', 
  ),
  'access_control' =>
  array(
  	'role' => 
	array(
		'all' => false,
		'subscriber' => false,
     	'contributor' => false,
      	'author' => false,
      	'editor' => false,
     	'administrator' => true,
	),
	'page_access' => null,
  ), 
  'social_services' => 
  array (
    'urls' => 
    array (
      0 => 'https://www.facebook.com',
      1 => 'https://twitter.com',
      2 => 'https://www.youtube.com',
      3 => 'https://vimeo.com',
      4 => 'https://instagram.com',
      5 => 'https://www.linkedin.com/',
      6 => 'https://www.pinterest.com/'
    ),
  ),
  'google_analytics' => 
  array (
    'tracking_code' => '<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push([\'_setAccount\', \'UA-XXXXXXX-X\']);
_gaq.push([\'_trackPageview\']);
(function() {
var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>',
  ),
  'newsletter' => 
  array (
    'enabled' => 'yes',
	'adapter' => 'Email',
    'email' => '',
  ),
  'mailchimp' => 
  array (
    'enabled' => '',
  ),
  'content' => 
  array (
    'logo_type' => 'text',
    'logo_image' => '',
    'logo_text' => 'Company Name',
    'header_text' => 'Here goes your catchy header',
    'message_text' => 'Tell the users that your website is not active yet. Put the reason to subscribe for the notification in this paragraph. Tell them about their problems which you would like to solve. <a href="#">Don’t forget the final call to action.</a>',
    'footer_note' => '© All Rights Reserved',
  ),
  'background' => 
  array (
    'color' => '#ffffff',
    'type' => 'undefined',
    'image' => '',
    'pattern' => '',
    'repeat' => 'repeat',
    'attachment' => 'scroll',
  ),
  'text_logo' => 
  array (
    'color' => '#000000',
    'font' => 'Pacifico',
  ),
  'font' => 
  array (
    'text_color' => '#989898',
    'header_color' => '#000000',
    'link_color' => '#484848',
	"button_color" => "#000000",
	"icons_color" => "#ffffff",
	"icons_background_color" => "#000000"
  ),
  'subscribe_strings' => 
  array (
    'subscribe_field' => 'Be the first to know',
    'subscribe_button' => 'Submit',
    'thank_u_message' => 'Thank you! We will notify you as soon as we launch.',
  ),
  'content_fonts' => 
  array (
    'header_font' => 'Oswald',
    'content_font' => 'Open+Sans',
    'input_font' => 'Open+Sans',
    'button_font' => 'Oswald',
    'message_font' => 'Oswald'  
  )
);