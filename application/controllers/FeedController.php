<?php

class FeedController extends IndexController  {
	
	function marketpricetrendsAction (){
		// disable rendering of the view and layout 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
		// retrieve current commodity price graph
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, PRICES_SERVER.'graph/commodityprice/pgc/true');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$commoditypricedata = curl_exec($ch);
		echo $commoditypricedata;
	}
	
}

