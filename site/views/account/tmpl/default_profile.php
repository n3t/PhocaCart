<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/** @var PhocaCartViewAccount $this */

$lang = Factory::getApplication()->getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);
?>
<div class="<?= $this->classMap('row') ?> ph-account-box-row">
    <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-account-box-header" id="phaccountuseredit">
        <h3><?= Text::_('COM_PHOCACART_EDIT_MY_PROFILE') ?></h3>
    </div>
</div>

<div class="<?= $this->classMap('row') ?> ph-account-box-action">
    <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-account-billing-row" id="phUserProfile">
        <?= $this->loadTemplate('edit') ?>
    </div>
</div>
