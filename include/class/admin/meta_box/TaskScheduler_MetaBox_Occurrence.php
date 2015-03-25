<?php
/**
 * Creates a meta box for occurrence options.
 * 
 * @since            1.0.0
 */
class TaskScheduler_MetaBox_Occurrence extends TaskScheduler_MetaBox_Base {
                
    /**
     * Adds form fields for the basic options.
     * 
     */ 
    public function setUp() {
        
        $this->_oTask = isset( $_GET['post'] )
            ? TaskScheduler_Routine::getInstance( $_GET['post'] )
            : null;
        
        $this->addSettingFields(
            array(
                'field_id'        => 'occurrence',
                'title'           => __( 'Occurrence', 'task-scheduler' ),
                'type'            => 'text',
                'attributes'      => array(
                    'ReadOnly'    => 'ReadOnly',
                    'name'        => '',
                ),
            ),        
            array()
        );    
    
    }

    /**
     * Redefines the 'occurrence' field.
     */
    public function field_definition_TaskScheduler_MetaBox_Occurrence_occurrence( $aField ) {
        
        if ( ! $this->_oTask ) { 
            return $aField; 
        }
        $aField['value'] = apply_filters( 
            "task_scheduler_filter_label_occurrence_{$this->_oTask->occurrence}", 
            $this->_oTask->occurrence 
        );
        return $aField;        
        
    }
    
    /**
     * Redefines the form fields.
     */
    public function field_definition_TaskScheduler_MetaBox_Occurrence( $aAllFields ) {    // field_definition_{class name}

        if ( ! $this->_oTask ) { 
            return $aAllFields; 
        }    
        if ( ! isset( $aAllFields['_default'] ) || ! is_array( $aAllFields['_default'] ) ) { 
            return $aAllFields; 
        }
        
        $aAllFields['_default'] = $aAllFields['_default'] 
            + $this->_getModuleFields( 
                $this->_oTask->occurrence, 
                ( array ) $this->_oTask->{$this->_oTask->occurrence}
            )
        ;
        
        return $aAllFields;        
        
    }    
        
    /**
     * A validation callback method.
     * 
     * @callback        filter      validation_ + extended class name
     */
    public function validation_TaskScheduler_MetaBox_Occurrence( /* $aInput, $aOldInput, $oAdminPage, $aSubmitInfo */ ) {
                  
        $_aParams    = func_get_args() + array(
            null, null, null, null
        );
        $aInput      = $_aParams[ 0 ];
        $aOldInput   = $_aParams[ 1 ];
        $oAdminPage  = $_aParams[ 2 ];
        $aSubmitInfo = $_aParams[ 3 ]; 
        
        return $aInput;
        
    }
    
    public function content( $sOutput ) {
        $sOutput = isset( $this->_oTask->occurrence )
            ? apply_filters(
                'task_scheduler_admin_filter_meta_box_content_' . $this->_oTask->occurrence,
                $sOutput,
                $this->_oTask
            )
            : $sOutput;
        return $sOutput 
             . $this->_getChangeButton( 'edit_occurrence' )
            ;
    }    
    
}