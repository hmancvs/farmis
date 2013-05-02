<?php 
# whether or not the session has errors
$session = SessionWrapper::getInstance(); 
$sessionhaserror = !isEmptyString($session->getVar(ERROR_MESSAGE));

$userid = $session->getVar("userid");  
$farmerid = $session->getVar("farmerid"); 
$farmid = $session->getVar("farmid"); 
$farmergroupid = $session->getVar("farmergroupid");  
$type = $session->getVar("type");

# the request object instance
$request = Zend_Controller_Front::getInstance()->getRequest();

# application config
$config = Zend_Registry::get('config');

# pagination defaults
Zend_Paginator::setDefaultScrollingStyle('Sliding');
Zend_View_Helper_PaginationControl::setDefaultViewPartial("index/pagination_control.phtml");

$hide_on_print_class = $request->getParam(PAGE_CONTENTS_ONLY) == "true" ? "hideonprint" : ""; 

// initialize the ACL for all views
$acl = getACLInstance(); 

$os = browser_detection('os');
$islinux = false;
if($os != 'nt'){
  $islinux = true;
}
  
$showleftcolumn = false;
$showrightcolumn = false;
$leftcolumnspan = '';
$rightcolumnspan = '';
$usemainlayout = true;

$summary = '<div id="summary"><form class="form-horizontal summary"></form></div>';
$land = '<div id="land"><form class="form-horizontal land"></form></div>';
$commodities = '<div id="commodities"><form class="form-horizontal commodities"></form></div>';
$preseason = '<div id="preseason"><form class="form-horizontal preseason"></form></div>';
$seasons = '<div id="seasons"><form class="form-horizontal seasons"></form></div>';
$calendar = '<div id="calendar"><form class="form-horizontal calendar"></form></div>';
$finance = '<div id="finance"><form class="form-horizontal finance"></form></div>';

$inventory = '<div id="inventory"><form class="form-horizontal inventory"></form></div>';
$setup = '<div id="setup"><form class="form-horizontal setup"></form></div>';
$account = '<div id="account"><form class="form-horizontal account"></form></div>';

$basics = '<div id="basics"><form id="profileform-basics" class="form-horizontal basics"></form></div>';
$personal = '<div id="personal"><form id="profileform-personal" class="form-horizontal personal"></form></div>';
$contacts = '<div id="contacts"><form id="profileform-contacts" class="form-horizontal contacts"></form></div>';
$farm = '<div id="farm"><form id="profileform-farm" class="form-horizontal farm"></form></div>';
$subscription = '<div id="subscription"><form id="profileform-subscription" class="form-horizontal subscription"></form></div>';
$accsettings = '<div id="account"><form id="profileform-account" class="form-horizontal account"></form></div>';
$privacy = '<div id="privacy"><form id="profileform-privacy" class="form-horizontal privacy"></form></div>';

$c = new Doctrine_RawSql();
$c->select('{m.*}, {mr.*}');
$c->from('message m INNER JOIN messagerecipient mr ON (m.id = mr.messageid)');
$c->where("(mr.recipientid = '".$userid."' AND mr.isread = 0) ORDER BY m.datecreated");
$c->addComponent('m', 'Message m');
$c->addComponent('mr', 'm.recipients mr');
$unread_messages = $c->execute()->count();
