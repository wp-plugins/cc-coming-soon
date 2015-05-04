<?php
if ( ! class_exists( 'GoogleWebFontCustomFieldType' ) ) :
class GoogleWebFontCustomFieldType extends AdminPageFramework_FieldType {
        
    /**
     * Defines the field type slugs used for this field type.
     */
    public $aFieldTypeSlugs = array( 'gwf', );
    
    /**
     * Defines the default key-values of this field type. 
     * 
     * @remark          $_aDefaultKeys holds shared default key-values defined in the base class.
     */
    protected $aDefaultKeys = array(
        
        'attributes'    => array(
            'select'    => array(
                'size'  => 1,
                'autofocusNew'  => '',
                'required'  => '',      
            ),
            'optgroup'  => array(),
            'option'    => array(),
        ),
        'label'     =>  array(),
        'sort'      =>  'alpha'
        
    );

    /**
     * Loads the field type necessary components.
     */ 
    public function setUp() {

    }   

    /**
     * Returns an array holding the urls of enqueuing scripts.
     */
    protected function getEnqueuingScripts() { 
        return array(
            // array( 'src' => dirname( __FILE__ ) . '/js/jquery.knob.js', 'dependencies'   => array( 'jquery' ) ),
        );
    }
    
    /**
     * Returns an array holding the urls of enqueuing styles.
     */
    protected function getEnqueuingStyles() { 
        return array();
    }           


    /**
     * Returns the field type specific JavaScript script.
     */ 
    protected function getScripts() { 
    }

    /**
     * Returns IE specific CSS rules.
     */
    protected function getIEStyles() { return ''; }

    /**
     * Returns the field type specific CSS rules.
     */ 
    protected function getStyles() {
        return "";
    }

    
    /**
     * Returns the output of the field type.
     */
    protected function getField( $aField ) { 
        $aSelectAttributes = array(
            'id'    =>  $aField['input_id'],
            'name'  =>  $aField['_input_name']
        );

        return
            $aField['before_label']
            . "<div class='admin-page-framework-input-label-container admin-page-framework-select-label' style='min-width: {$aField['label_min_width']}px;'>"
                . "<label for='{$aField['input_id']}'>"
                    . $aField['before_input']
                    . "<span class='admin-page-framework-input-container'>"
                        . "<select " . $this->generateAttributes( $aSelectAttributes ) . " >"
                            . $this->_getOptionTags( $aField['input_id'], $aField['attributes'], $this->_getFonts() )
                        . "</select>"
                    . "</span>"
                    . $aField['after_input']
                    . "<div class='repeatable-field-buttons'></div>"    // the repeatable field buttons will be replaced with this element.
                . "</label>"                    
            . "</div>"
            . $aField['after_label'];

    }

    protected function _getOptionTags( $sInputID, &$aAttributes, $aLabel ) {
            
        $aOutput = array();
        $aValue = ( array ) $aAttributes['value'];

        foreach( $aLabel as $sKey => $asLabel ) {
            
            // For the optgroup tag,
            if ( is_array( $asLabel ) ) {   // optgroup
            
                $aOptGroupAttributes = isset( $aAttributes['optgroup'][ $sKey ] ) && is_array( $aAttributes['optgroup'][ $sKey ] )
                    ? $aAttributes['optgroup'][ $sKey ] + $aAttributes['optgroup']
                    : $aAttributes['optgroup'];
                    
                $aOutput[] = 
                    "<optgroup label='{$sKey}'" . $this->generateAttributes( $aOptGroupAttributes ) . ">"
                    . $this->_getOptionTags( $sInputID, $aAttributes, $asLabel )
                    . "</optgroup>";
                continue;
                
            }
            
            // For the option tag,
            $aValue = isset( $aAttributes['option'][ $sKey ]['value'] )
                ? $aAttributes['option'][ $sKey ]['value']
                : $aValue;
            
            $aOptionAttributes = array(
                'id'    => $sInputID . '_' . $sKey,
                'value' => $sKey,
                'selected'  => in_array( ( string ) $sKey, $aValue ) ? 'Selected' : '',
            ) + ( isset( $aAttributes['option'][ $sKey ] ) && is_array( $aAttributes['option'][ $sKey ] )
                ? $aAttributes['option'][ $sKey ] + $aAttributes['option']
                : $aAttributes['option']
            );

            $aOutput[] =
                "<option " . $this->generateAttributes( $aOptionAttributes ) . " >" 
                    . $asLabel
                . "</option>";
                
        }
        return implode( PHP_EOL, $aOutput );    
        
    }

    private function _getFonts($sort = 'alpha') {
        if($fonts = get_transient(get_class($this).'_'.$sort)) {

        } else {
            $fonts = $this->_fetchFonts($sort);
            set_transient(get_class($this).'_'.$sort, $fonts, 604800); // week
        }
        return $fonts;
    }

    /**
     * [fetchFontsList description]
     * @param  string $sort alpha: Sort the list alphabetically
     *                      date: Sort the list by date added (most recent font added or updated first)
     *                      popularity: Sort the list by popularity (most popular family first)
     *                      style: Sort the list by number of styles available (family with most styles first)
     *                      trending: Sort the list by families seeing growth in usage (family seeing the most growth first)
     * @return array        fonts list array
     */
    private function _fetchFonts($sort = 'alpha') {

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
            $data = json_decode(file_get_contents(dirname( __FILE__ ) . '/js/api-fallback.json'), true);
        }

        $items = $data['items'];
        $fonts = array();
        foreach ($items as $item) {
            $fonts[str_replace(" ", "+", $item['family'])] = $item['family'];
        }

        return $fonts;
    }
        
        private function getRevealerScript( $sFieldContainerID, $sDefaultSelectionID ) {
            return 
                "<script type='text/javascript'>
                    jQuery( document ).ready( function(){
                        jQuery( '#{$sFieldContainerID} input[type=radio]' ).change( function() {
                            jQuery( this ).closest( '.admin-page-framework-field' )
                                .find( 'input[type=radio]' )
                                .attr( 'checked', false );
                            jQuery( this ).attr( 'checked', 'Checked' );
                            revealSelection( jQuery( this ).attr( 'id' ) );
                        });
                        revealSelection( '{$sDefaultSelectionID}' );    // do it for the default one
                    });             
                </script>";     
            
        }
    
}
endif;