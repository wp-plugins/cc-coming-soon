<?php

 // if ( ! class_exists( 'CcPopUpTemplate' ) )
    // require_once( CC_PU_PLUGIN_DIR . 'public/includes/chch-pop-up-template.php' );
    
class CcComingSoonPreview { 
    
    private $template_id, $template_name, $template_options , $options_prefix;
    
    public $fields  = array();
    
    function __construct($template, $template_name) {
        $this->plugin = CcComingSoon::get_instance(); 
        $this->plugin_slug = $this->plugin->get_plugin_slug(); 
        
        $this->template_id = $template; 
        
        $this->template_name = $template_name;
        
        $this->options_prefix = 'CcComingSoonAdminOptions';
        
        $this->template_options = $this->plugin->get_options();
        
    }
    
    /**
     * Build preview view
     *
     * @since    0.1.0
     */
    public function build_preview() {
          
        echo '<div class="cc-pu-customize-form" id="cc-pu-customize-form-'.$this->template_id.'">';
         
        echo '<div class="cc-pu-customize-controls">';
        
        //preview options header
        echo '
            <div class="cc-pu-customize-header-actions">
                <input name="publish" id="publish-customize" class="button button-primary button-large" value="Save &amp; Close" accesskey="p" type="submit" />  
                <a class="cc-pu-customize-close" href="#" data-template="'.$this->template_id.'">
                    <span class="screen-reader-text">Close</span>
                </a> 
        </div>';
        
        //preview options overlay - start
        echo '<div class="cc-pu-options-overlay">';
        
        //preview customize info
        echo '<div class="cc-pu-customize-info">
                <span class="preview-notice">
                    You are customizing <strong class="template-title">'.$this->template_name.' Template</strong>
                </span>
            </div><!--#customize-info-->';
    
        //preview options accordion wrapper - start
        echo '<div class="customize-theme-controls"  class="accordion-section">';
        
        // build options sections
        
        echo $this->build_options();
        
        echo '
                </div><!--.accordion-section-->
            </div><!--.cc-pu-options-overlay-->
        </div><!--#cc-pu-customize-controls-->';
    
        echo '<iframe id="cc-pu-customize-preview-'.$this->template_id.'" class="cc-pu-customize-preview" style="position:relative;">';
             
        echo '</iframe>';
        echo '</div>'; 
         
    }
    
    
    private function build_options() {

        $fields = array();

        $fields['content'] = array( 
            'name'  => 'Content',
            'field_groups' => array(
                array(
                    'option_group' => 'content',
                    'title'        => 'Logo & Favicon',
                    'fields' => array(
                        array(
                            'type'   => 'revealer_group', 
                            'name'   => 'logo_type',  
                            'desc'   => 'Logo Type:', 
                            'target' => '.modal-inner',
                            'attr'   => 'background-image',  
                            
                            'options' => array(
                                'image' => 'Image',
                                'text' => 'Text',
                            ),

                            'revaeals' => array(  
                                array(
                                    'section_title' => 'Logo Image',
                                    'section_id' => 'image',
                                    'fields' => array(
                                        array(
                                            'type'   => 'upload',
                                            'name'   => 'logo_image', 
                                            'target' => '.logo-image img',
                                            'attr'   => 'src', 
                                            'desc'   => 'Enter a URL or upload an image:',
                                        ), 
                                    ),
                                ),
                                array(
                                    'section_title' => 'Logo Text',
                                    'section_id' => 'text',
                                    'fields' => array(
                                        array(
                                            'type'   => 'text', 
                                            'action' => 'text',
                                            'name'   => 'logo_text',  
                                            'target' => '.logo-text', 
                                            'desc'   => 'Logo Text:',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'type'   => 'upload',
                            'name'   => 'favicon', 
                            'target' => '#favicon',
                            'attr'   => 'href', 
                            'desc'   => 'Favicon:',
                        ),
                    )
                ),
                array(
                    'option_group' => 'content',
                    'title'        => 'Content',
                    'fields' => array(
                        array(
                            'type'   => 'editor', 
                            'name'   => 'header_text',  
                            'target' => '.main main h1', 
                            'desc'   => 'Header:',
                        ), 
                        array(
                            'type'   => 'editor', 
                            'name'   => 'message_text',  
                            'target' => '.message-text',
                            'media'  => true,
                            'desc'   => 'Message:',
                        ),
                        array(
                            'type'   => 'editor', 
                            'name'   => 'footer_note',  
                            'target' => '.cc-pu-content-section', 
                            'desc'   => 'Footer Note:',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'subscribe_strings',
                    'title'        => 'Translations',
                    'fields' => array(
                        array(
                            'type'   => 'text',
                            'action' => 'text',
                            'name'   => 'subscribe_field',  
                            'target' => '.cc-pu-header-section h2', 
                            'desc'   => 'Subscribe Field:'
                        ), 
                        array(
                            'type'   => 'text', 
                            'action' => 'text',
                            'name'   => 'subscribe_button',  
                            'target' => '#newsletter button', 
                            'desc'   => 'Subscribe Button:',
                        ),
                        array(
                            'type'   => 'text',
                            'action' => 'text',
                            'name'   => 'thank_u_message',
                            'target' => '.cc-pu-content-section',
                            'desc'   => 'Success Message:',
                        ),
                    ),
                ), 
            ),  
        );

        $fields['design'] = array( 
            'name'  => 'Fonts and Colors',
            'field_groups' => array(
                array(
                    'option_group' => 'text_logo',
                    'title'        => 'Text Logo',
                    'fields' => array(
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'color',
                            'target' => '.header-container header h1',
                            'attr'   => 'color',
                            'desc'   => 'Color:',
                        ),
                        array(
                            'type'   => 'font',
                            'name'   => 'font',
                            'target' => '.header-container header h1',
                            'attr'   => 'font-family',
                            'desc'   => 'Font:',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'content_fonts',
                    'title'        => 'Header',
                    'fields'       => array(
                        array(
                            'type'   => 'font', 
                            'name'   => 'header_font',  
                            'target' => 'h1:not(.title), h2, h3, h4, h5, h6',
                            'attr'   => 'font-family', 
                            'desc'   => 'Header Font:',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'header_color', 
                            'target' => 'main h1',
                            'attr'   => 'color', 
                            'desc'   => 'Header Color:',
                            'option_group' => 'font',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'content_fonts',
                    'title'        => 'Content',
                    'fields'       => array(
                        array(
                            'type'   => 'font', 
                            'name'   => 'content_font',  
                            'target' => 'body, .main',
                            'attr'   => 'font-family', 
                            'desc'   => 'Content Font:',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'text_color', 
                            'target' => 'body',
                            'attr'   => 'color', 
                            'desc'   => 'Text Color:',
                            'option_group' => 'font',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'font',
                    'title'        => 'Link',
                    'fields'       => array(
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'link_color', 
                            'target' => 'a',
                            'attr'   => 'color', 
                            'desc'   => 'Link Color:',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'content_fonts',
                    'title'        => 'Input',
                    'fields'       => array(
                        array(
                            'type'   => 'font', 
                            'name'   => 'input_font',  
                            'target' => '#newsletter input',
                            'attr'   => 'font-family', 
                            'desc'   => 'Input Font:',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'content_fonts',
                    'title'        => 'Button',
                    'fields'       => array(
                        array(
                            'type'   => 'font', 
                            'name'   => 'button_font',  
                            'target' => '#newsletter button',
                            'attr'   => 'font-family', 
                            'desc'   => 'Button Font:',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'button_color', 
                            'target' => '#newsletter button',
                            'attr'   => 'background-color', 
                            'desc'   => 'Button Color:',
                            'option_group' => 'font',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'button_text_color', 
                            'target' => '#newsletter button',
                            'attr'   => 'color', 
                            'desc'   => 'Button Text Color:',
                            'option_group' => 'font',
                        ),
                    ),
                ),
                array(
                    'option_group' => 'font',
                    'title'        => 'Social Icons',
                    'fields' => array(
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'icons_color', 
                            'target' => '.social-links li a i',
                            'attr'   => 'color', 
                            'desc'   => 'Icons Color:',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'icons_background_color', 
                            'target' => '.social-links li a',
                            'attr'   => 'background-color', 
                            'desc'   => 'Icons Background Color:',
                        ),
                    )
                ),
                array(
                    'option_group' => 'content_fonts',
                    'title'        => 'Thank You Message',
                    'fields' => array(
                        array(
                            'type'   => 'font', 
                            'name'   => 'message_font',  
                            'target' => '#thank-you',
                            'attr'   => 'font-family', 
                            'desc'   => 'Message Font:',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'message_text_color', 
                            'target' => '#thank-you',
                            'attr'   => 'color', 
                            'desc'   => 'Text Color:',
                            'option_group' => 'font',
                        ),
                        array(
                            'type'   => 'color_picker',
                            'name'   => 'message_background_color', 
                            'target' => '#thank-you',
                            'attr'   => 'background-color', 
                            'desc'   => 'Background Color:',
                            'option_group' => 'font',
                        ),
                    ),
                ),
            ),
        );
          
        
        return $this->build_tabs($fields);
    }  
    
    private function build_tabs($fields) {
        if(!is_array($this->fields)) return; 
         
        $controls ='';
        $i=0;
        foreach($fields as $field):
        
            $section_name = !empty($field['name']) ? $field['name'] : 'Section';
            $controls .='
                <h3 class="accordion-section-title" tabindex="'.$i.'">
                    '.$section_name.'
                    <span class="screen-reader-text">Press return or enter to expand</span> 
                </h3>'; 
            $controls .= '<div class="accordion-section-content">';  
            
            foreach($field['field_groups'] as $option):   
                $controls .= $this->build_sections($option); 
            endforeach;
            $i++;
            $controls .= '</div>'; 
        endforeach;
        
        return $controls; 
    }
    
    /**
     * Build fields groups
     *
     * @since     1.0.0
     *
     * @return    $section - html
     */
    private function build_sections($fields) {
        if(!is_array($fields)) return; 
        
        $section = '<div class="cc-pu-fields-wrapper">';
        
        $section .= '<h4>'.$fields['title'].'</h4>'; 
        
        foreach($fields['fields'] as $field): 
            
            if(isset($field['repeater']) && $field['repeater'] == true){
                $section .= '<div class="chch-repeater-wrapper"><div class="chch-repeater-field">'; 
            }
            
            $type_func = 'build_field_'.$field['type'];  
            $section .= $this->$type_func($field, $fields['option_group']);
            
            if(isset($field['repeater']) && $field['repeater'] == true){
                $section .= '</div><button type="button" class="button button-primary button-large chch-repeater-add">Add item</button></div>'; 
            }
            
        endforeach; 
         
        $section .= ' </div>';   
        
        return $section;  
         
    }   
    
    private function build_field_slider($field, $options_group) {
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
        
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]";
        
        $options = $this->template_options[$options_group];
        
        $option_html = '<label><span class="customize-control-title">'.$field['desc'].'</span>';
        $option_html .= '<input  
                        type="hidden" 
                        name="'.$name.'"
                        id="'.$name.'" 
                        value = "'.$options[$field['name']].'"
                        class="cc-pu-customize-style"
                        data-customize-target="'.$field['target'].'"   
                        data-template="'.$template.'"  
                        ';
                        
        if(isset($field['unit'])){
            $option_html .= 'data-unit="'.$field['unit'].'"';   
        }
        
        if(isset($field['attr'])){
            $option_html .= 'data-attr="'.$field['attr'].'"';   
        }
        $option_html .= '>';                
        $option_html .= '<script type="text/javascript">
                        jQuery(document).ready( function ($) { 
                             $( "#'.$name.'-slider" ).slider({
                                max: '.$field['max'].',
                                min: '.$field['min'].',
                                step: '.$field['step'].',
                                value: '.$options[$field['name']].',
                                slide: function(e,ui) {
                                    var target = $(this).attr("data-target");
                                    $("#"+target).val(ui.value);
                                    $("#"+target).trigger("change");
                                }
                            });
                                     
                        }); 
                        </script>
                        <div id="'.$name.'-slider" data-target="'.$name.'"></div>';
            $option_html .= '</label>';         
        return $option_html;
                     
    }
    
    /**
     * Build color picker field
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    private  function build_field_color_picker($field, $options_group) { 
         
        $option_html = '<label class="cc-pu-option-active">';
        $option_html .= '<span class="customize-control-title">'.$field['desc'].'</span>';
        $option_html .= '<input type="text" ';
        $option_html .= $this->build_field_attributes($field, $options_group);   
        $option_html .= '>';
        $option_html .= '</label>';                 
        
        return $option_html;         
    }
    
    private function build_field_revealer($field, $options_group) {
        
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
         
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]";
        $id = str_replace('_','-',$name);
        $target = $id.'-revealer';
        
        $options = $this->template_options[$options_group];
        
        $checked = $options[$field['name']] ? 'checked' : '';
        
        $option_html = '<label><span class="customize-control-title">'.$field['desc'].'</span>';
        $option_html .= '
        <input 
            type="checkbox" 
            name="'.$name.'"
            id="'.$id .'" 
            class="revealer"
            data-customize-target="'.$target.'"    
            data-template="'.$template.'" 
            '.$checked.'
        >'; 
        
        $option_html .= '</label>'; 
        
        $hide = $options[$field['name']] ? '' : 'hide-section';
            
        $option_html .= '<div class="'.$hide.'" id="'.$target.'">';
                    
        foreach($field['revaeals']['fields'] as $reveals): 
            $type_func = 'build_field_'.$reveals['type'];  
            $option_html .= $this->$type_func($reveals, $options_group);
        endforeach;
                    
        $option_html .= '</div>';   
        
        return $option_html;
                     
    }
    
    /**
     * Build revealer group field
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    private function build_field_revealer_group($field, $options_group) {
        
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
        
        $option_name =  $field['name'];
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]"; 
        $group = $options_group.'-'.$field['name'].'-group';
        
        $options = $this->template_options[$options_group]; 
        
        $option_html = '<label>';
        $option_html .= '<span class="customize-control-title">'.$field['desc'].'</span>';
        
        $option_html .= '<select 
                        name="'.$name.'" 
                        class="revealer-group" 
                        data-group="'.$group.'"  
                        data-customize-target="'.$field['target'].'"  
                        data-attr="'.$field['attr'].'" 
                        data-template="'.$template.'"  
                        > ';
                        
        if(!empty($field['options'])):
            foreach($field['options'] as $val => $desc):
                $selected = '';
                if($options[$field['name']] == $val){
                        $selected = 'selected';
                }
                $option_html .= '<option value="'.$val.'" '.$selected.'>'.$desc.'</option> ';
            endforeach;
        endif; 
        
        $option_html .= '</select>';    
        $option_html .= '</label>'; 
        
        foreach($field['revaeals'] as $reveals): 
            $hide = 'hide-section';
            if($this->template_options[$options_group][$option_name] == $reveals['section_id']){
                $hide = 'cc-pu-option-active';  
            }
                
            $option_html .= '<div class="'.$hide.' '.$group.' revealer-wrapper" id="'.$reveals['section_id'].'">';
                        
            foreach($reveals['fields'] as $field): 
                $type_func = 'build_field_'.$field['type'];  
                $option_html .= $this->$type_func($field, $options_group);
            endforeach;
            
            $option_html .= '</div>';   
        endforeach;  
        
        return $option_html;
                     
    }
    
    /**
     * Build text field
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    private  function build_field_text($field, $options_group) {  
        
        $option_html = '<label class="cc-pu-option-active">';
        $option_html .= '<span class="customize-control-title">'.$field['desc'].'</span>';
        
        $option_html .= '<input type="text" '; 
        $option_html .= $this->build_field_attributes($field, $options_group);  
        $option_html .= '>';
        
        $option_html .= '</label>';     
                    
        return $option_html;
                     
    }
    
    
    /**
     * Build checkbox field
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    private  function build_field_checkbox($field, $options_group) {  
        
        $option_html = '<label class="cc-pu-option-active">';
        $option_html .= '<span class="customize-control-title">'.$field['desc'].'</span>';
        
        $option_html .= '<input type="checkbox" '; 
        $option_html .= $this->build_field_attributes($field, $options_group);  
        $option_html .= $this->build_field_values($field, $options_group);
        $option_html .= '>';
        
        $option_html .= '</label>';     
                    
        return $option_html;
                     
    }
    
    private  function build_field_upload($field, $options_group) {
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
        
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]"; 
        $id = "{$this->options_prefix}_field_{$options_group}_{$field['name']}"; 
        
        $options = $this->template_options[$options_group];
       
        $option_html = '<label><span class="customize-control-title">'.$field['desc'].'</span>';
        $option_html .= '<input  
                        type="text" 
                        name="'.$name .'"
                        id="'.$id .'" 
                        value = "'.$options[$field['name']].'"
                        class="cc-pu-customize-style"
                        data-customize-target="'.$field['target'].'"  
                        data-attr="'.$field['attr'].'"  
                        data-template="'.$template.'"  
                        >';
        $option_html .= '<input class="cc-pu-image-upload button" type="button" value="Upload Image" data-target="'.$id .'"/>';
        $option_html .= '</label>';                 
        return $option_html;
                     
    }
    
    /**
     * Build select field
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    private  function build_field_select($field, $options_group) { 
        
        $option_html = '<label><span class="customize-control-title">'.$field['desc'].'</span>';
        
        $option_html .= '<select ';
        $option_html .= $this->build_field_attributes($field, $options_group);   
        $option_html .= '>';
        
        $option_html .= $this->build_field_values($field, $options_group);
        
        $option_html .= '</select></label>';                    
        return $option_html;
                     
    }
    
    private function build_field_font($field, $options_group) {
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
        
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]";
        $options = $this->template_options[$options_group];
        
        $option_html = '<label><span class="customize-control-title">'.$field['desc'].'</span>';
        $option_html .= '<select 
                        name="'.$name.'" 
                        data-id ="'.$options_group.'-font" 
                        class="cc-pu-fonts cc-pu-customize-style"
                        data-customize-target="'.$field['target'].'"  
                        data-attr="'.$field['attr'].'"  
                        data-template="'.$template.'"  
                        > ';
                        
        $fonts = $this->getFonts();
        
        if(!empty($fonts)):
            foreach($fonts as $val => $desc):
                $selected = '';
                if($options[$field['name']] == $val){
                        $selected = 'selected';
                }
                $option_html .= '<option value="'.$val.'" '.$selected.'>'.$desc.'</option> ';   
            endforeach;
        endif;
        $option_html .= '</select></label>';                    
        return $option_html;
                     
    }
    
    private function build_field_editor($field, $options_group) {
        $options_prefix = $this->options_prefix;
        $template = $this->template_id;
        
        $options = $this->template_options[$options_group];
        
        $name = "{$this->options_prefix}[{$options_group}][{$field['name']}]";
        
        ob_start();  
 
        $settings = array( 
            'editor_class' => 'cc-pu-customize-content',
            'media_buttons' => (isset($field['media']) && $field['media'] === true) ? true : false,
            'quicktags' => true,
            'textarea_name' => $name,
            'tinymce' => array(
                'toolbar1'=> ', bold,italic,underline,link,unlink,forecolor,undo,redo',
                'toolbar2'=> '',
                'toolbar3'=> ''
            )
        );
                         
        echo '<label><span class="customize-control-title">'.$field['desc'].'</span>';
         wp_editor( wpautop($options[$field['name']]), $field['name'].'-'.$template, $settings );  
      
        echo '</select></label>';
        $option_html = ob_get_clean();                  
        return $option_html;
                     
    }
    
    private function getFonts($sort = 'alpha') {
        if($fonts = get_transient(get_class($this).'_'.$sort)) {

        } else {
            $fonts = $this->fetchFonts($sort);
            set_transient(get_class($this).'_'.$sort, $fonts, 604800); // week
        }
        return $fonts;
    }
    
    private function fetchFonts($sort = 'alpha') {

        $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?&sort=' . $sort;
        $response = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));

        $fallback = false;
        if($response && !is_wp_error($response)) {
            $data = json_decode($response, true);
            if(isset($data['error'])) {
                $fallback = true;
            }
        } else {
            $fallback = true;
        }

        if($fallback) {
            $data = json_decode(file_get_contents(CC_CS_PLUGIN_DIR. '/admin/assets/js/api-fallback.json'), true);
        }

        $items = $data['items'];
        $fonts = array();
        foreach ($items as $item) {
            $fonts[str_replace(" ", "+", $item['family'])] = $item['family'];
        }

        return $fonts;
    }
    
        /**
     * Return field attributes
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    function build_field_attributes($atts, $options_group){ 
        
        $type = $atts['type'];   
          
        $attributes = ' ';  
        
        if(isset($atts['name']) && !empty($atts['name']))
        {
            $group = isset($atts['option_group']) ? $atts['option_group'] : $options_group;
            $name = "{$this->options_prefix}[{$group}][{$atts['name']}]";
        }
        else
        {
            $name = $this->options_prefix.$options_group.'_field';      
        }
        
        if(isset($atts['id']) && !empty($atts['id']))
        {
            $id = $atts['id'];  
        }
        else
        {
            $id = $name;        
        }
        
        $target = '';   
        if(isset($atts['target']) && !empty($atts['target']))
        {
            $target = $atts['target'];  
        } 
        
        $unit = '';
        if(isset($atts['unit']) && !empty($atts['unit']))
        {
            $unit = $atts['unit'];  
        }
        
        $attr = '';
        if(isset($atts['attr']) && !empty($atts['attr']))
        {
            $attr = $atts['attr'];  
        } 
        
         
        $action = '';
        
        if(isset($atts['action']) && !empty($atts['action']))
        {
            if($atts['target'] !=='none')
            {
                switch($atts['action']){
                    case 'css': 
                        $action = 'cc-pu-customize-style';
                        break;
                    case 'text': 
                        $action = 'cc-pu-customize-content';
                        break;              
                }
            }
        }
        else
        {
            switch($type){
                case 'color_picker': 
                    $action = 'cc-pu-colorpicker';
                    break;
                    
                case 'revealer': 
                    $action = 'revealer';
                    break;
                     
                case 'revealer_group': 
                    $action = 'revealer-group';
                    break;
                        
                case 'font': 
                    $action = 'cc-pu-fonts';
                    break;  
                        
            }
            
            if(($type != 'revealer' || $type != 'revealer_group' || $type != 'text') && $atts['target'] !=='none') 
            {
                $action .= ' cc-pu-customize-style';
            }
        }
        
        if(isset($atts['class']) && !empty($atts['class'])){
            $action .= ' '.$atts['class'];
        }

        if(isset($atts['repeater']) && $atts['repeater'] == true){
            $action .= ' chch-repeater-field';
        }
        
        $attributes .= 'name="'.$name.'" '; 
        $attributes .= 'id="'.$id.'" '; 
        $attributes .= 'class="'.$action.'" ';   
        $attributes .= 'data-template="'.$this->template_id.'" ';
        $attributes .= 'data-customize-target="'.$target.'" '; 
        
        if($unit) {
            $attributes .= 'data-unit="'.$unit.'" ';    
        }
        
        if($attr) {
            $attributes .= 'data-attr="'.$attr.'" ';    
        }
        
        $exclude_types = array('revealer','revealer_group','select', 'checkbox');
        if(!in_array($type, $exclude_types)) 
        {
            $value =  $this->build_field_values($atts, $options_group);
            $attributes .= 'value="'.$value.'" '; 
        }
        
        return $attributes; 
    }
    
    /**
     * get field values
     *
     * @since     1.0.0
     *
     * @return    $option_html - html
     */
    function build_field_values($atts, $options_group){
        $group = isset($atts['option_group']) ? $atts['option_group'] : $options_group;
        $option = $this->plugin->get_option($group, $atts['name']);  
        
        switch($atts['type']):
            case 'select':
                $select_option ='';
                foreach($atts['options'] as $val => $desc):
                    $selected = '';
                    if($option == $val){
                            $selected = 'selected';
                    }
                    $select_option .= '<option value="'.$val.'" '.$selected.'>'.$desc.'</option> '; 
                endforeach;     
                return $select_option;
            break; 
            
            case 'checkbox':
                if($option):
                    return 'checked'; 
                endif;  
            break;
            
            default :
            
                if(!empty($option)):
                    return $option;
                else:
                    return '';
                endif;
                
            break;
        endswitch; 
    }
}