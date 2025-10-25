<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

defined('_JEXEC') or die();

use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

/** @var PhocaCartViewAccount $this */
?>
<div id="ph-pc-account-box" class="pc-view pc-account-view<?= $this->param('pageclass_sfx') ?>">
    <?= PhocacartRenderFront::renderHeader(array(Text::_('COM_PHOCACART_MY_ACCOUNT'))) ?>

    <?php if ($this->isLogged()) { ?>
        <?= $this->loadTemplate('rewards') ?>
        <?= $this->loadTemplate('address') ?>

        <?php if ($this->param('display_edit_profile', 1) == 1) { ?>
            <?= $this->loadTemplate('profile') ?>
        <?php } ?>
    <?php } else { ?>
	    <div class="<?= $this->classMap('row') ?> ph-account-box-row" >
	        <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-account-box-header" id="phaccountloginedit">
                <h3><?= Text::_('COM_PHOCACART_LOGIN_REGISTER') ?></h3>
            </div>
	    </div>

        <div class="<?= $this->classMap('row') ?> ph-account-box-action">
            <div class="<?= $this->classMap('col.xs12.sm8.md8') ?> ph-right-border">
                <?= LayoutHelper::render('user_login', [
                    's' => $this->getStyles(),
                    't' => $this->data(),
                ], null, ['component' => 'com_phocacart']) ?>
            </div>
            <div class="<?= $this->classMap('col.xs12.sm4.md4') ?> ph-left-border">
                <?= LayoutHelper::render('user_register', [
                    's' => $this->getStyles(),
                    't' => $this->data(),
                ], null, ['component' => 'com_phocacart']) ?>
            </div>
            <div class="ph-cb"></div>
        </div>
<?php } ?>
</div>

<?= PhocacartUtilsInfo::getInfo();
