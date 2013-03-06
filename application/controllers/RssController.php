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
	    $rssfeed .= '<description>Subscribe to the latest news and developments for Infotrade FARMIS</description>';
	    $rssfeed .= '<language>en-us</language>';
	    $rssfeed .= '<copyright>Copyright (C) 2010 farmis.ug</copyright>';
	    
	    $rssfeed .= '</channel>';
	    $rssfeed .= '</rss>';
	    echo $rssfeed;
	    
	}
	
}

