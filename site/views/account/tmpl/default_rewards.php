<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/** @var PhocaCartViewAccount $this */

if ((int)$this->data('display_reward_points_total_info') > 0) {
?>
<div class="<?= $this->classMap('row') ?> ph-account-box-row">
  <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-account-box-header" id="phaccountrewardpoints">
    <h3><?= Text::_('COM_PHOCACART_REWARD_POINTS') ?></h3>
  </div>
</div>

<div class="<?= $this->classMap('row') ?> ph-account-box-action">
  <div class="<?= $this->classMap('col.xs12.sm8.md8') ?>">
    <?= Text::_('COM_PHOCACART_TOTAL_AMOUNT_OF_YOUR_REWARD_POINTS') . ':' ?>
  </div>
  <div class="<?= $this->classMap('col.xs12.sm4.md4') ?>">
    <?= $this->data('rewardpointstotal') ?>
  </div>
</div>

<?php
}
