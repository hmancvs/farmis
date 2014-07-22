<?php

class RssController extends IndexController  {
	
	function indexAction (){
		// disable rendering of the view and layout 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    $rssfeed = '<?xml version="1.0" encoding="UTF-8"?>';
	    $rssfeed .= '<rss version="2.0">';
	    $rssfeed .= '<channel>';
	    $rssfeed .= '<title>FARMIS | Latest News</title>';
	    $rssfeed .= '<link>'.$this->view->baseUrl('rss').'</link>';
	    $brand = 'Infotrade';
	    if(isKenya()){
	    	$brand = 'Sokopepe';
	    }
	    $rssfeed .= '<description>Subscribe to the latest news and developments for '.$brand.' FARMIS</description>';
	    $rssfeed .= '<language>en-us</language>';
	    $rssfeed .= '<copyright>Copyright (C) 2010 '.getDomain().'</copyright>';
	    
	    $rssfeed .= '</channel>';
	    $rssfeed .= '</rss>';
	    echo $rssfeed;
	}
}

