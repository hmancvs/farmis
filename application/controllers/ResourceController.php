<?php

class ResourceController extends SecureController   {

	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		return ACTION_VIEW;
	}
    
    public function getResourceForACL(){
        return "Farmer"; 
    }
    
    function allpricesAction() {
    	
    }
}