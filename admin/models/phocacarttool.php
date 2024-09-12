<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_JEXEC' ) or die();
use Joomla\CMS\MVC\Model\AdminModel;
jimport('joomla.application.component.modeladmin');

class PhocaCartCpModelPhocaCartTool extends AdminModel
{
	protected	$option 		= 'com_phocacart';
	protected 	$text_prefix	= 'com_phocacart';
}
?>