<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

require_once JPATH_COMPONENT.'/controllers/phocacartcommon.php';

class PhocaCartCpControllerPhocaCartContentType extends PhocaCartCpControllerPhocaCartCommon
{
	public function __construct($config = array())
    {
		$this->view_list = 'phocacartcontenttypes';
		parent::__construct($config);
	}
}
