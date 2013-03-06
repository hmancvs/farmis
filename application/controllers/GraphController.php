<?php
class GraphController extends IndexController {
	
	function commoditypriceAction() {
		
    }
	function commoditypriceexportAction(){
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, PRICES_SERVER.'graph/commoditypriceexport');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($ch);
		curl_close($ch);
		// echo $xml;
		
		$data = xmlstr_to_array($xml);
		// debugMessage($data);
		$this->view->prices = $data['item'];
		
    }
	function fuelpriceAction() {
		
    }
    function fuelpriceexportAction(){
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, PRICES_SERVER.'graph/fuelpriceexport');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($ch);
		curl_close($ch);
		// echo $xml;
		
		$data = xmlstr_to_array($xml);
		// debugMessage($data); exit(); 
		$this->view->prices = $data['item'];
		
    }
    function inputpriceAction() {
    	
    }
	function marketanalysisreportAction() {
    }
	function commodityAction() {
    }
    
    function currentmarketpricesAction(){}
	function currentfuelpricesAction(){}
	function openselloffersAction(){}
	function currentorganicpricesAction(){}
	function currentinputpricesAction(){}
	
	function allpricesexportAction(){
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, PRICES_SERVER.'graph/allpricesexport');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml = curl_exec($ch);
		curl_close($ch);
		// echo $xml;
		
		$data = xmlstr_to_array($xml);
		// debugMessage($data);
		$this->view->prices = $data['item'];
		// exit();
    }
}

