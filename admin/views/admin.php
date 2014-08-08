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
                'title'         =>  __('Templates', $this->plugin_slug),
                'order'         =>  5
            ),
            array(
                'tab_slug'      =>  'settings',
                'title'         =>  __('Settings', $this->plugin_slug),
                'order'         =>  10
            ),
            array(
                'tab_slug'      =>  'content',
                'title'         =>  __('Content', $this->plugin_slug),
                'order'         =>  20
            ),
            array(
                'tab_slug'      =>  'design',
                'title'         =>  __('Design', $this->plugin_slug),
                'order'         =>  30
            ),
            array(
                'tab_slug'      =>  'live_preview',
                'title'         =>  __('Live Preview', $this->plugin_slug),
                'order'         =>  40
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
                'title'         =>  __('Status', $this->plugin_slug),
            ),
            array(
                'section_id'    =>  'social_services',
                'tab_slug'      =>  'settings',
                'title'         =>  __('Social services', $this->plugin_slug)
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
                'title'         =>  __('Mailchimp', $this->plugin_slug),
                'description'   =>  __('This option is available in Pro version.', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'content',
                'tab_slug'      =>  'content',
                'title'         =>  __('Coming Soon Page Content', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'background',
                'tab_slug'      =>  'design',
                'title'         =>  __('Background', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'text_logo',
                'tab_slug'      =>  'design',
                'title'         =>  __('Text Logo', $this->plugin_slug)
            ),
            array(
                'section_id'    =>  'font',
                'tab_slug'      =>  'design',
                'title'         =>  __('Content', $this->plugin_slug)
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
                'title'         => __('Enabled', $this->plugin_slug),
                'default'       =>  'yes',
                'label'         =>  array(
                    'yes'   => 'Yes',
                    'no'    => 'No'       
                ),
                'description'   => __('Enable or disable the plugin.', $this->plugin_slug)
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
                'description'   => __('Enable or disable newsletter subscribe form on front-end.', $this->plugin_slug)
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
                'type'          => 'hidden'
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
                'default'       =>  '#fieldrow-content_logo_image',
                'label'         =>  array(
                    '#fieldrow-content_logo_image' => __( 'Image', $this->plugin_slug ),       
                    '#fieldrow-content_logo_text' => __( 'Text', $this->plugin_slug )
                ),
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
                'rich'  =>  array( 
                    'media_buttons' =>  false,
                    'teeny' => true
                )
            ),
            array(
                'field_id'  =>  'message_text',
                'title'     =>  __('Message Text', $this->plugin_slug),
                'type'  =>  'textarea',
                'rich'  =>  true,
                'attributes'    =>  array(
                    'rows'      =>  10,
                    'field' =>  array(
                        'style' =>  'width: 100%;'  // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    )
                )
            ),
            array(
                'field_id'  =>  'footer_note',
                'type'      =>  'textarea',
                'title'     =>  __('Footer note', $this->plugin_slug),
                'rich'  =>  array( 
                    'media_buttons' =>  false,
                    'teeny' => true
                )
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
                'title'         =>  __('Background Image Type', $this->plugin_slug),
                'description'   =>  __('Your background can be either a full image or a pattern.', $this->plugin_slug),
                'default'       =>  'undefined',
                'label'         =>  array(
                    'undefined' => __( 'No Image', $this->plugin_slug ),       
                    '#fieldrow-background_attachment, #fieldrow-background_image' => __( 'Full Image', $this->plugin_slug ),       
                    '#fieldrow-background_attachment, #fieldrow-background_repeat, #fieldrow-background_pattern' => __( 'Pattern', $this->plugin_slug )
                ),
            ),
            array(
                'field_id'      =>  'image',
                'type'          =>  'image',
                'title'         =>  __('Background Image', $this->plugin_slug),
                'description'   =>  __('Your image will be expanded to cover whole page.', $this->plugin_slug),
            ),
            array(
                'field_id'      =>  'pattern',
                'type'          =>  'image',
                'title'         =>  __('Pattern Image', $this->plugin_slug)
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
                )
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
                'description'   => __('Select Yes, if you do not want the background to scroll with the content.', $this->plugin_slug)
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
                'title'         =>  __('Font Family', $this->plugin_slug),
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
            )
        );
    }

    public function do_before_cc_coming_soon() {
        echo '<a class="button button-primary right button-hero" href="http://ch-ch.org/cspro" style="margin: 25px 20px 0 2px;">Get Pro</a>';
    }

    public function content_cc_coming_soon_templates() {
        include(dirname( __FILE__ ) . '/templates.php' );
    }

    public function content_cc_coming_soon_live_preview() {
        echo '<iframe id="themepreview" name="themepreview" src="'.get_option('home').'/?cc-cs-preview=1" width="100%" height="600px"></iframe>';
    }

    public function do_cc_coming_soon_settings() {
        $this->options_saver();
    }

    public function do_cc_coming_soon_content() {
        $this->options_saver();
    }

    public function do_cc_coming_soon_design() {
        $this->options_saver();
    }

    private function options_saver() {
        submit_button();
    }
}