<?php
namespace Phoca\PhocaCart\Event\View\Item;

use Joomla\CMS\Event\Result\ResultAware;
use Joomla\CMS\Event\Result\ResultTypeStringAware;
use Joomla\Registry\Registry;
use Phoca\PhocaCart\Event\AbstractEvent;

class BeforeEndPricePanel extends AbstractEvent
{
  use ResultAware, ResultTypeStringAware;

  public function __construct(string $context, object $item, Registry $appParams) {
    parent::__construct('pcv', 'onPCVonItemBeforeEndPricePanel', [
      'context' => $context,
      'item' => &$item,
      'appParams' => $appParams,
    ]);
  }
}
