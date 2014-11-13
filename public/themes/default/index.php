<?php
/**
 *
 * id: default
 * title: Default
 * 
 */
$base_url = plugin_dir_url( __FILE__ );
$includes_url = CC_CS_PLUGIN_URL.'public/includes/'; 
$background_type = $this->get_background_type();

$options = $this->get_options();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title><?php bloginfo('name'); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="<?php echo plugins_url('css/normalize.min.css', __FILE__); ?>">
        <link rel="stylesheet" href="<?php echo plugins_url('css/main.css', __FILE__); ?>">

		 

        <?php if($favicon = $this->get_option('content', 'favicon')): ?>
        <link rel="shortcut icon" href="<?php echo $favicon; ?>" />
        <?php endif; ?>

        <?php $fonts = array(
            'Open+Sans',
            'Oswald:b'
        ); ?>

        <?php if($this->get_logo_type() === 'text'): ?>
            <?php if($font = $this->get_option('text_logo', 'font')): ?>
                <?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
            <?php endif; ?>
        <?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'header_font')): ?>
       		<?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
   		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'content_font')): ?>
       		<?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
   		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'input_font')): ?>
       		<?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
   		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'button_font')): ?>
       		<?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
   		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'message_font')): ?>
       		<?php if(!in_array($font, $fonts)) $fonts[] = $font; ?>
   		<?php endif; ?>
		
        <?php $fonts_code = implode('%7c', $fonts); ?>

        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=<?php echo $fonts_code; ?>">
        
        <style>
        body {
            background-color: <?php echo $this->get_option('background', 'color'); ?>;

            <?php $background_type = $this->get_background_type(); ?>
            <?php if($background_type === 'image'): ?>
                background-image: url('<?php echo $this->get_option('background', 'image'); ?>');
                background-size: cover;
                background-position: top center;
            <?php elseif($background_type === 'pattern'): ?>
                background-image: url('<?php echo $this->get_option('background', 'pattern'); ?>');
                background-repeat: <?php echo $this->get_option('background', 'repeat'); ?>;
            <?php endif; ?>
            background-attachment: <?php echo $this->get_option('background', 'attachment'); ?>;

        }

        <?php if($options['font']['text_color'] != 'transparent'): ?>
        body { color: <?php echo $options['font']['text_color']; ?>; }
        <?php endif; ?>

        <?php if($options['font']['header_color'] != 'transparent'): ?>
        h1 { color: <?php echo $options['font']['header_color']; ?>; }
        <?php endif; ?>

        <?php if($options['font']['link_color'] != 'transparent'): ?>
        a { color: <?php echo $options['font']['link_color']; ?>; }
        <?php endif; ?>

        <?php if($options['text_logo']['color'] != 'transparent'): ?>
        .header-container header h1 { color: <?php echo $options['text_logo']['color']; ?>; }
        <?php endif; ?>

        <?php if($this->get_logo_type() === 'text'): ?>
            <?php if($font = $this->get_option('text_logo', 'font')): ?>
                .header-container h1.title { font-family: <?php echo str_replace("+", " ", $font); ?>;}
            <?php endif; ?>
        <?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'content_font')): ?>
       		.main { font-family: <?php echo str_replace("+", " ", $font); ?>;}
 		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'input_font')): ?>
       		#newsletter input { font-family: <?php echo str_replace("+", " ", $font); ?>;}
 		<?php endif; ?> 
		
		<?php if($font = $this->get_option('content_fonts', 'button_font')): ?>
       		#newsletter button { font-family: <?php echo str_replace("+", " ", $font); ?>;}
 		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'message_font')): ?>
       		#thank-you { font-family: <?php echo str_replace("+", " ", $font); ?>;}
 		<?php endif; ?>
		
		<?php if($font = $this->get_option('content_fonts', 'header_font')): ?>
       		h1, h2, h3, h4, h5, h6  { font-family: <?php echo str_replace("+", " ", $font); ?>;}
 		<?php endif; ?>
        </style>

        <!--[if lt IE 9]>
        <script src="<?php echo plugins_url('js/html5shiv.min.js', __FILE__); ?>""></script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->  
		 
        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">
                    <?php if($this->get_logo_type() === 'text'): ?>
                        <?php echo $this->get_option('content', 'logo_text'); ?>
                    <?php else: ?>
                        <img src="<?php echo $this->get_option('content', 'logo_image'); ?>" alt="">
                    <?php endif; ?>
                </h1>
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">

                <main class="clearfix">
                    <h1><?php echo $options['content']['header_text']; ?></h1>
                    <?php echo apply_filters('cc_the_content', $options['content']['message_text']); ?> 
                </main>
                
                <?php if($this->get_option('newsletter', 'enabled') === 'yes'): ?>

                    <div class="form-container">
                        <div id="thank-you"><p><?php if($thank_u_message = $this->get_option('subscribe_strings', 'thank_u_message')): echo $thank_u_message; else: _e('<strong>Thank you!</strong> We will notify you as soon as we launch.', $this->plugin_slug); endif; ?></p></div>
                        <form action="" id="newsletter" class="clearfix" method="POST">
                            <p class="icon-email-envelope">
                                <input type="email" name="email" id="email" placeholder="<?php if($subscribe_field = $this->get_option('subscribe_strings', 'subscribe_field')): echo $subscribe_field; else: _e('Be the first to know', $this->plugin_slug); endif; ?>" required>
                            </p>
                            <input type="hidden" name="_ajax_nonce" id="_ajax_nonce" value="<?php echo wp_create_nonce("cc-cs-newsletter-subscribe"); ?>">
                            <p>
                                <button type="submit" id="submit"><?php if($subscribe_button = $this->get_option('subscribe_strings', 'subscribe_button')): echo $subscribe_button; else: _e('Submit', $this->plugin_slug); endif; ?></button>
                            </p>

                        </form>
                    </div>
                    
                <?php endif; ?>

            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <ul class="social-links clearfix">
                    <?php
                        $services = array(
                            'facebook',
                            'twitter',
                            'youtube',
                            'vimeo',
                            'instagram'
                        );
                    ?>

                    <?php foreach($services as $key => $service): ?>
                        <?php if($url = $options['social_services']['urls'][$key]): ?>
                            <li><a href="<?php echo $url; ?>" class="icon-<?php echo $service; ?>"></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
                <p class="clearfix"><?php echo $options['content']['footer_note']; ?></p>
            </footer>
        </div>
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
		 
        <script>
            $(document).ready(function(){ 
                <?php if($this->get_option('google_adwords', 'conversion_code')): ?>
                var conversion_code = <?php echo json_encode($this->get_option('google_adwords', 'conversion_code')); ?>;
                <?php endif; ?>

                function fadeIn(el) {
                  el.style.opacity = 0;
                  el.style.display = 'initial';

                  var last = +new Date();
                  var tick = function() {
                    el.style.opacity = +el.style.opacity + (new Date() - last) / 400;
                    last = +new Date();

                    if (+el.style.opacity < 1) {
                      (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16)
                    }
                  };

                  tick();
                }

                var form = document.querySelector("#newsletter");
                var message = document.querySelector(".form")

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var request = new XMLHttpRequest();
                    request.open('POST', '<?php echo admin_url( 'admin-ajax.php' ); ?>', true);
                    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                    
                    request.onload = function() {
                      if (request.status >= 200 && request.status < 400){
                        // Success!
                        var response = JSON.parse(request.responseText);

                        if(response.status === 'ok') {
                            fadeIn(document.querySelector("#thank-you"));
							 <?php if($this->get_option('google_adwords', 'conversion_code')): ?>
                            $(conversion_code).appendTo('body');
							<?php endif; ?>
                        }

                      }
                    };

                    request.send("action=cc_cs_newsletter_subscribe&email=" + form.querySelector("#email").value + "&_ajax_nonce=" + form.querySelector("#_ajax_nonce").value);
                });
            });
        </script>
        <?php echo $this->get_option('google_analytics', 'tracking_code'); ?>
    </body>
</html>
