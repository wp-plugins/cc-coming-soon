<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   CcComingSoon
 * @author    Chop-Chop.org <talk@chop-chop.org>
 * @license   GPL-2.0+
 * @link      https://shop.chop-chop.org
 * @copyright 2014 
 */
class CcComingSoonAdminOptions extends AdminPageFramework {

    public function start_CcComingSoonAdminOptions() {

        // include custom fields
        $fields_to_load = array(
            'RevealerCustomFieldType' => 'revealer-cutom-field-type/RevealerCustomFieldType.php',
            'GoogleWebFontCustomFieldType' => 'google-web-font-custom-field-type/GoogleWebFontCustomFieldType.php'
        );

        foreach ($fields_to_load as $class => $file) {
            include_once( plugin_dir_path( __FILE__ ) . '/../includes/admin-page-framework/third-party/' . $file );
            new $class(get_class($this));
        }
    }

    public function setUp() {
        global $wp_roles;

        $plugin = CcComingSoon::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();
        $this->plugin = CcComingSoon::get_instance();
        $this->setRootMenuPage( 'Settings' );

        $this->addSubMenuItems(
            array(
                'title'         =>    'Coming Soon CC',    // page and menu title
                'page_slug'     =>    'cc_coming_soon'   // page slug
            )
        );

        /**
         * Tabs
         */
        $this->addInPageTabs(
            'cc_coming_soon',
            array(
                'tab_slug'      =>  'templates',
                'title'         =>  __('<span class="dashicons dashicons-format-gallery"></span> Templates', $this->plugin_slug),
                'order'         =>  5
            ),
            array(
                'tab_slug'      =>  'background',
                'title'         =>  __('<span class="dashicons dashicons-format-image"></span> Background', $this->plugin_slug),
                'order'         =>  10,
            ),
            array(
                'tab_slug'      =>  'settings',
                'title'         =>  __('<span class="dashicons dashicons-admin-generic"></span> Settings', $this->plugin_slug),
                'order'         =>  20,
            )
        );
        $this->setInPageTabTag( 'h2' );

        /**
         * Field sections
         */
        $this->addSettingSections(
            'cc_coming_soon',
            array(
                'section_id'    =>  'status',
                'tab_slug'      =>  'settings',
                'title'         =>  __('Plugin Status', $this->plugin_slug),
            ),
            array(
                'section_id'    =>  'social_services',
                'tab_slug'      =>  'settings',
                'title'         =>  __('Social Services', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'google_analytics',
                'tab_slug'      =>  'settings',
                'title'         =>  __('Google Analytics', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'newsletter',
                'tab_slug'      =>  'settings',
                'title'         =>  __('Newsletter', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'mailchimp',
                'tab_slug'      =>  'settings',
                'title'         =>  __('MailChimp', $this->plugin_slug)
                
            ),
            array(
                'section_id'    =>  'content',
                'tab_slug'      =>  'templates',
                'title'         =>  __('Coming Soon Page Content', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'subscribe_strings',
                'tab_slug'      =>  'templates',
                'title'         =>  __('Translations', $this->plugin_slug),
                'order'         =>  20
            ),
            array(
                'section_id'    =>  'background',
                'tab_slug'      =>  'background',
                'title'         =>  __('Background', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'text_logo',
                'tab_slug'      =>  'templates',
                'title'         =>  __('Text Logo', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'font',
                'tab_slug'      =>  'templates',
                'title'         =>  __('Content', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'content_fonts',
                'tab_slug'      =>  'templates',
                'title'         =>  __('Content Fonts', $this->plugin_slug),
                'order'         =>  40
            )
        );

        /**
         * Plugin status
         */
        $this->addSettingFields(
            'status',
            array(
                'field_id'      => 'enabled',
                'type'          => 'radio',
                'title'         => __('Status', $this->plugin_slug),
                'default'       =>  'yes',
                'label'         =>  array(
                    'yes'   => __('Activated', $this->plugin_slug),
                    'no'    => __('Deactivated', $this->plugin_slug)
                ),
                'description'   => sprintf(__('By default only the Administrator(s) can see the actual website. <a href="%s">Get Coming Soon CC Pro</a> to decide which user roles can see the actual page.', $this->plugin_slug), 'http://ch-ch.org/cspro')
            )
        );

        /**
         * Social services
         */
        $this->addSettingFields(
            'social_services',
            array(
                'field_id'      =>  'urls',
                'title'         =>  'Profile URLs',
                'type'          =>  'text',
                'sortable'      =>  false,
                'description'   =>  __('Enter a URL to display the icon.', $this->plugin_slug),
                'label'         =>  __('Facebook', $this->plugin_slug),
                array(
                    'label'     =>  __('Twitter', $this->plugin_slug),
                ),
                array(
                    'label'     =>  __('Youtube', $this->plugin_slug)
                ),
                array(
                    'label'     =>  __('Vimeo', $this->plugin_slug)
                ),
                array(
                    'label'     =>  __('Instagram', $this->plugin_slug)
                ),
                array(
                    'label'     =>  __('LinkedIn', $this->plugin_slug)
                ),
                array(
                    'label'     => __('Pinterest', $this->plugin_slug)
                )
            )
        );

        /**
         * Google Analytics
         */
        $this->addSettingFields(
            'google_analytics',
            array(
                'field_id'      => 'tracking_code',
                'type'          => 'textarea',
                'title'         => __('Tracking Code', $this->plugin_slug),
                'description'   => __('Paste your tracking code from Google Analytics panel.', $this->plugin_slug),
                'attributes'    =>  array(
                    'rows'  =>  8
                )
            )
        );

        /**
         * Newsletter
         */
        $this->addSettingFields(
            'newsletter',
            array(
                'field_id'      => 'enabled',
                'type'          => 'radio',
                'title'         => __('Enabled', $this->plugin_slug),
                'default'       =>  'yes',
                'label'         =>  array(
                    'yes'   => 'Yes',
                    'no'    => 'No'       
                ),
                'description'   => __('Enable or disable newsletter subscribe form on the front-end.', $this->plugin_slug)
            ),
            array(
                'field_id'      =>  'email',
                'title'         =>  __('E-mail address'),
                'type'          =>  'email',
                'description'   =>  __('We will send subscription notifications to this email. If you leave this field empty, we will use the admin email.', $this->plugin_slug)
            )
        );

        $this->addSettingFields(
            'mailchimp',
            array(
                'field_id'      => 'enabled',
                'type'          => 'hidden',
                'title'         => __('Status', $this->plugin_slug),
                'description'   =>  sprintf(__('<a href="%s">Get Coming Soon CC Pro</a> for MailChimp integration.', $this->plugin_slug), 'http://ch-ch.org/cspro')
            )
        );


        /**
         * Content
         */
        $this->addSettingFields(
            'content',
            array(
                'field_id'      =>  'logo_type',
                'type'          =>  'revealer',
                'title'         =>  __('Logo Type', $this->plugin_slug),
                'description'   =>  __('Your logo can be either an image or a text.', $this->plugin_slug),
                'default'       =>  'image',
                'label'         =>  array(
                    'image' => __( 'Image', $this->plugin_slug ),       
                    'text' => __( 'Text', $this->plugin_slug )
                ),
                'reveals'       =>  array( 
                    'image'     =>  '#fieldrow-content_logo_image',
                    'text'   =>  '#fieldrow-content_logo_text',
                )
            ),
            array(
                'field_id'  =>  'logo_image',
                'type'      =>  'image',
                'title'     =>  __('Logo Image', $this->plugin_slug)
            ),
            array(
                'field_id'  =>  'logo_text',
                'type'      =>  'text',
                'title'     =>  __('Logo Text', $this->plugin_slug)
            ),
            array(
                'field_id'  =>  'header_text',
                'title'     =>  __('Header Text', $this->plugin_slug),
                'type'      =>  'textarea',
            ),
            array(
                'field_id'  =>  'message_text',
                'title'     =>  __('Message Text', $this->plugin_slug),
                'type'  =>  'textarea',
                'attributes'    =>  array(
                    'rows'      =>  10,
                    'field' =>  array(
                        'style' =>  'width: 100%;'  // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    )
                )
            ),
            array(
                'field_id'      =>  'footer_note',
                'type'          =>  'textarea',
                'title'         =>  __('Footer Note', $this->plugin_slug),
            ),
            array(
                'field_id'      =>  'favicon',
                'type'          =>  'image',
                'title'         =>  __('Favicon', $this->plugin_slug),
                'description'   =>  __('The favicon will be displayed in a browser tab.', $this->plugin_slug)
            )
        );

        /**
         * Background
         */
        $this->addSettingFields(
            'background',
            array(
                'field_id'      =>  'color',
                'type'          =>  'color',
                'title'         =>  __('Background Color', $this->plugin_slug)
            ),
             array(
                'field_id'      =>  'type',
                'type'          =>  'revealer',
                'title'         =>  __('Background Type', $this->plugin_slug),
                'description'   =>  sprintf(__('Your background can be either a full image or a pattern.<br/><a href="%s">Get Coming Soon CC Pro</a>', $this->plugin_slug), 'http://ch-ch.org/cspro'),
                'default'       =>  'undefined',
                'label'         =>  array(
                    'no' => __( 'No Image', $this->plugin_slug ),       
                    'image' => __( 'Full Image', $this->plugin_slug ),       
                    'pattern' => __( 'Pattern', $this->plugin_slug ),
                    'slider' => __('Background Slider (Available in Pro)', $this->plugin_slug),
                    'video' => __('Video Slider (Available in Pro)', $this->plugin_slug)
                ),
                'reveals'       =>  array(
                    'no'        =>  'undefined',
                    'image'     =>  '#fieldrow-background_attachment, #fieldrow-background_image',
                    'pattern'   =>  '#fieldrow-background_attachment, #fieldrow-background_repeat, #fieldrow-background_pattern',
                ),
                'attributes'    => array(
                    'option'    => array(
                        'slider'   => array(
                            'disabled'  => 'disabled'
                        ),
                        'video'   => array(
                            'disabled'  => 'disabled'
                        )
                    )
                ),
                'order'         =>  20
            ),
            array(
                'field_id'      =>  'image',
                'type'          =>  'image',
                'title'         =>  __('Background Image', $this->plugin_slug),
                'description'   =>  __('Your image will be expanded to cover the whole page.', $this->plugin_slug),
                'order'         =>  30
            ),
            array(
                'field_id'      =>  'pattern',
                'type'          =>  'image',
                'title'         =>  __('Pattern Image', $this->plugin_slug),
                'order'         =>  40
            ),
            array(
                'field_id'      =>  'repeat',
                'type'          =>  'radio',
                'title'         =>  __('Pattern Repeat', $this->plugin_slug),
                'default'       =>  'repeat',
                'label'         =>  array(
                    'no-repeat' =>  __('No repeat', $this->plugin_slug),
                    'repeat'    =>  __('Repeat', $this->plugin_slug),
                    'repeat-x'  =>  __('Repeat Horizontally', $this->plugin_slug),
                    'repeat-y'  =>  __('Repeat Vertically', $this->plugin_slug)
                ),
                'order'         =>  50
            ),
            array(
                'field_id'      => 'attachment',
                'type'          => 'radio',
                'title'         => __('Fixed background', $this->plugin_slug),
                'default'       =>  'scroll',
                'label'         =>  array(
                    'fixed'   => 'Yes',
                    'scroll'    => 'No'   
                ),
                'description'   => __('Select Yes, if you do not want the background to scroll with the content.', $this->plugin_slug),
                'order'         =>  60
            )
        ); 

        /**
         * Text logo
         */
        $this->addSettingFields(
            'text_logo',
            array(
                'field_id'      =>  'color',
                'title'         =>  __('Color', $this->plugin_slug),
                'type'          =>  'color'
            ),
            array(
                'field_id'      =>  'font',
                'title'         =>  __('Logo Font', $this->plugin_slug),
                'type'          =>  'gwf'
            )
        );

        /**
         * Font
         */
        $this->addSettingFields(
            'font',
            array(
                'field_id'      =>  'text_color',
                'title'         =>  __('Text Color', $this->plugin_slug),
                'type'          =>  'color'
            ),
            array(
                'field_id'      =>  'header_color',
                'title'         =>  __('Header Color', $this->plugin_slug),
                'type'          =>  'color'
            ),
            array(
                'field_id'      =>  'link_color',
                'title'         =>  __('Link Color', $this->plugin_slug),
                'type'          =>  'color'
            ),
            array(
                'field_id'      =>  'button_color',
                'title'         =>  __('Button Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  40
            ),
            array(
                'field_id'      =>  'button_text_color',
                'title'         =>  __('Button Text Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  45
            ),
            array(
                'field_id'      =>  'message_text_color',
                'title'         =>  __('Text Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  47
            ),
            array(
                'field_id'      =>  'message_background_color',
                'title'         =>  __('Background Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  49
            ),
            array(
                'field_id'      =>  'icons_color',
                'title'         =>  __('Icons Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  50
            ),
            array(
                'field_id'      =>  'icons_background_color',
                'title'         =>  __('Icons Background Color', $this->plugin_slug),
                'type'          =>  'color',
                'order'         =>  60
            )
        );
        
        /**
         * Content fonts
         */
        $this->addSettingFields(
            'content_fonts',
            array(
                'field_id'      => 'header_font',
                'type'          => 'gwf',
                'title'         => __('Header Font', $this->plugin_slug), 
                'default'       =>  'undefined',
                'order'         =>  10
            ),
            array(
                'field_id'      => 'content_font',
                'type'          => 'gwf',
                'title'         => __('Content Font', $this->plugin_slug), 
                'default'       =>  'undefined',
                'order'         =>  20
            ),
            array(
                'field_id'      => 'input_font',
                'type'          => 'gwf',
                'title'         => __('Input Font', $this->plugin_slug), 
                'order'         =>  10
            ),
            array(
                'field_id'      => 'button_font',
                'type'          => 'gwf',
                'title'         => __('Button Font', $this->plugin_slug), 
                'order'         =>  10
            ),
            array(
                'field_id'      => 'message_font',
                'type'          => 'gwf',
                'title'         => __('Message Font', $this->plugin_slug), 
                'order'         =>  10
            )
        );  
        
        /**
         * Subscribe form
         */
        $this->addSettingFields(
            'subscribe_strings',
            array(
                'field_id'      => 'subscribe_field',
                'type'          => 'text',
                'title'         => __('Subscribe Field', $this->plugin_slug),
                'default'       =>  'Be the first to know', 
                'order'         =>  10
            ),
            array(
                'field_id'      => 'subscribe_button',
                'type'          => 'text',
                'title'         => __('Subscribe Button', $this->plugin_slug),
                'default'       =>  'Submit', 
                'order'         =>  20
            ), 
            array(
                'field_id'      => 'thank_u_message',
                'type'          => 'text',
                'title'         => __('Success Message', $this->plugin_slug),
                'default'       =>  'Thank you! We will notify you as soon as we launch.', 
                'order'         =>  30
            )
        );
    }

    public function do_before_cc_coming_soon() {
        echo '<a class="button button-secondary right button-hero" style="margin: 25px 20px 0px 2px; padding: 0px 20px;
height: 47px;" href="https://shop.chop-chop.org/contact" target="_blank">'.__('Contact Support',$this->plugin_slug).'</a>';
        echo '<a class="button button-primary right button-hero" href="http://ch-ch.org/cspro" style="margin: 25px 20px 0 2px;">Get Pro</a>';
        
        
    } 

    public function content_bottom_cc_coming_soon_background() {
        $this->options_reseter('background');  
    }
    
    public function content_bottom_cc_coming_soon_settings() {
        $this->options_reseter('settings');  
    }
    
    private function options_reseter($tab) {
        echo '<a href="'.
            esc_url(
                add_query_arg(
                    array(
                        'cc-settings-reset' => "true",
                        'section' => $tab,
                        '_wpnonce' => wp_create_nonce('cc_cs_reset_'.$tab) 
                        
                    ),
                    '//' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]
                )
            ).'" class="button right" style="margin: -72px 20px 0px 2px; position: relative; z-index: 9999;">'.__('Reset to Default',$this->plugin_slug).'</a>';
    }
    
    public function load_cc_coming_soon(){
         
        // handle notices
        if(isset($_GET['settings-updated'])) {
            if($_GET['settings-updated'] === 'r-true') {
                $this->setAdminNotice('Settings reset.', 'updated');
            } elseif($_GET['settings-updated'] === 'r-false') {
                $this->setAdminNotice('Nothing to reset.');
            }
        }
         
            $util = new AdminPageFramework_WPUtility; 
            if(isset($_GET['cc-settings-reset'])) {
                $tab = $_GET['tab'];
                check_admin_referer('cc_cs_reset_'.$tab);
                
                $all_sections = $this->oForm->aSections;
                
                $to_reset = array();
                 
                 
                foreach($all_sections as $section)
                {
                    if(count($section) && $section['tab_slug'] == $tab && $section['section_id'] != 'license')
                    {
                        $to_reset[] =   $section['section_id'];
                    }       
                }
                
                if(!empty($to_reset))
                {
                    if($this->plugin->reset_options_to_default($to_reset,$tab)) 
                    {
                        wp_redirect($util->getQueryAdminURL(array('settings-updated' => 'r-true'), array('_wpnonce', 'cc-settings-reset','section')));
                    } 
                    else 
                    {
                        wp_redirect($util->getQueryAdminURL(array('settings-updated' => 'r-false'), array('_wpnonce', 'cc-settings-reset','section')));
                    }
                }
                else 
                {
                    wp_redirect($util->getQueryAdminURL(array('settings-updated' => 'r-false'), array('_wpnonce', 'cc-settings-reset','section')));
                }
            } 
        
    }

    public function content_cc_coming_soon_templates() {
        include(dirname( __FILE__ ) . '/templates.php' );
    }

    public function do_cc_coming_soon_background() {
        $this->options_saver();
    }

    public function do_cc_coming_soon_settings() {
        $this->options_saver();
    }

    private function options_saver() {
        submit_button();
    }
}