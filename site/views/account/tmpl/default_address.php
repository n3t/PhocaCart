<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Phoca\PhocaCart\Dispatcher\Dispatcher;
use Phoca\PhocaCart\Event;

defined('_JEXEC') or die;

/** @var PhocaCartViewAccount $this */

// TODO do not call events in template
$eventInsideAddressAfterHeader = Dispatcher::dispatch(new Event\View\Account\InsideAddressAfterHeader('com_phocacart.account', $this->data));

$pluginLayout = PluginHelper::importPlugin('pct');
$eventUserAddressAfterAccountView = Dispatcher::dispatch(new Event\View\Account\InsideAddressAfterHeader('com_phocacart.account', $this->data));
$eventUserAddressAfterAccountView = array_filter($eventUserAddressAfterAccountView, function ($value) {
  return $value && ($value['content'] ?? '');
});
?>
<div class="<?= $this->classMap('row') ?> ph-account-box-row">
  <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-account-box-header" id="phaccountaddressedit">
    <h3><?= Text::_('COM_PHOCACART_BILLING_AND_SHIPPING_ADDRESS') ?></h3>
  </div>
</div>

<form action="<?= $this->data('linkcheckout') ?>" method="post" class="<?= $this->classMap('form-horizontal.form-validate') ?>" role="form" id="phcheckoutAddress">
  <div id="ph-request-message" style="display:none"></div>

  <div class="<?= $this->classMap('row') ?> ph-account-box-action">
    <?php if ($eventInsideAddressAfterHeader) { ?>
      <div class="<?= $this->classMap('col.xs12.sm12.md12') ?>">
        <?= implode("\n", $eventInsideAddressAfterHeader) ?>
      </div>
    <?php } ?>

    <div class="<?= $this->classMap('col.xs12.sm6.md6') ?> ph-account-billing-row" id="phBillingAddress">
      <div class="ph-box-header"><?= Text::_('COM_PHOCACART_BILLING_ADDRESS') ?></div>
      <?= $this->t['dataaddressform']['b'] ?>
    </div>

    <div class="<?= $this->classMap('col.xs12.sm6.md6') ?> ph-account-shipping-row" id="phShippingAddress">
      <div class="ph-box-header"><?= Text::_('COM_PHOCACART_SHIPPING_ADDRESS') ?></div>
      <?= $this->t['dataaddressform']['s'] ?>
    </div>

    <div class="<?= $this->classMap('col.xs12.sm12.md12 pull-right') ?> ph-right ph-account-check-box">
      <?php if ($this->data('dataaddressform')['s'] != '' && $this->data('delivery_billing_same_enabled') != -1) { ?>
        <div class="<?= $this->classMap('controls') ?>">
          <label>
            <input class="<?= $this->classMap('inputbox.checkbox') ?>" type="checkbox" id="phCheckoutBillingSameAsShipping" name="phcheckoutbsas" <?= $this->data('dataaddressform')['bsch'] ?> />
            <?= Text::_('COM_PHOCACART_DELIVERY_AND_BILLING_ADDRESSES_ARE_THE_SAME') ?>
          </label>
        </div>
      <?php } ?>
    </div>

    <?php foreach ($eventUserAddressAfterAccountView as $value) { ?>
        <div class="ph-info-view-content"><?= $value['content'] ?></div>
    <?php } ?>

    <div class="<?= $this->classMap('col.xs12.sm12.md12') ?> ph-center ph-account-billing-row">
      <button class="<?= $this->classMap('btn.btn-primary') ?> ph-btn">
        <?= PhocacartRenderIcon::icon($this->icon('save'), '', ' ') ?>
        <?= Text::_('COM_PHOCACART_SAVE') ?>
      </button>
    </div>
  </div>

  <input type="hidden" name="tmpl" value="component" />
  <input type="hidden" name="option" value="com_phocacart" />
  <input type="hidden" name="task" value="checkout.saveaddress" />
  <input type="hidden" name="typeview" value="account" />
  <input type="hidden" name="return" value="<?= $this->data('actionbase64') ?>" />
  <?= HTMLHelper::_('form.token') ?>
</form>
