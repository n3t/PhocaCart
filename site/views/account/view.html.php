<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Helper\AuthenticationHelper;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\Users\Administrator\Helper\Mfa;
use Phoca\PhocaCart\MVC\View\SiteViewTrait;

jimport( 'joomla.application.component.view');

class PhocaCartViewAccount extends HtmlView
{
    use SiteViewTrait;

    // Backward compatibility properties
    protected $s;
    protected $p;
    protected $t;
    protected $u;
    protected $twofactorform = [];
    protected $twofactormethods = [];
    protected $otpConfig;

    // Phoca Cart address form
    protected $fields2;
    protected $data2;
    protected $form2;

    // User profile
    protected $params;
    protected $fields;
    protected $data;
    protected $form;
    protected $state;

    protected $mfaConfigurationUI;

    function display($tpl = null)
    {
        $app = Factory::getApplication();
        $uri = Uri::getInstance();

        // TODO what is really needed?
        $this->data('action', $uri->toString());
        $this->data('actionbase64', base64_encode($this->data('action')));
        $this->data('linkaccount', Route::_(PhocacartRoute::getAccountRoute()));
        $this->data('linkcheckout', Route::_(PhocacartRoute::getCheckoutRoute()));
        $this->data('display_edit_profile', $this->param('display_edit_profile', 1));
        $this->data('display_reward_points_total_info', $this->param('display_reward_points_total_info', 0));
        $this->data('delivery_billing_same_enabled', $this->param('delivery_billing_same_enabled', 0));
        $this->data('datauser', []);

        $lang = $app->getLanguage();
        $lang->load('com_users');

        if ($this->isLogged()) {
            /** @var PhocaCartModelCheckout $modelCheckout */
            BaseDatabaseModel::addIncludePath(JPATH_SITE . '/components/com_phocacart/models');
            $modelCheckout = BaseDatabaseModel::getInstance('Checkout', 'PhocaCartModel');

            // Check if all form items are filled out by user, if yes, don't load the form and save some queries
            $this->fields2 = $modelCheckout->getFields(0, 0, 1); // Fields will be loaded in every case
            $this->data2   = $modelCheckout->getData();
            $this->form2   = $modelCheckout->getForm();

            $this->data('dataaddressform', PhocacartUser::getAddressDataForm($this->form2, $this->fields2['array'], $this->getUser()));
            $this->data('datauser', $this->data2);

            $this->loadJoomlaUser();

            // REWARD POINTS
            $reward = new PhocacartReward();
            $this->data('rewardpointstotal', $reward->getTotalPointsByUserId($this->getUser()?->id));
        }

        $media = PhocacartRenderMedia::getInstance();
        $media->loadBase();
        $media->loadChosen();
        $media->loadSpec();

        $this->_prepareDocument();

        // Backward compatibility
        $this->p = $this->getParams();
        $this->s = $this->getStyles();
        $this->t = $this->data();
        $this->u = $this->getUser();

        parent::display($tpl);
    }

    private function loadJoomlaUser(): void
    {
        // TODO check values in config
        if ($this->param('display_edit_profile', 1) != 1) {
            return;
        }

        Form::addFormPath(JPATH_SITE . '/components/com_users/forms');
        Form::addFieldPath(JPATH_SITE . '/components/com_users/fields');

        $app = Factory::getApplication();

        // Redirect back to Phoca Cart Account
        $app->setUserState('com_users.edit.profile.redirect', Uri::getInstance()->toString());

        /** @var \Joomla\Component\Users\Site\Model\ProfileModel $modelUsers */
        $modelUsers = $app->bootComponent('com_users')->getMvcFactory()->createModel('Profile', 'Site', ['ignore_request' => false]);

        $this->form = $modelUsers->getForm();

        $this->data   = $modelUsers->getData();
        $this->state  = $modelUsers->getState();
        $this->params = $this->state->get('params');

        $this->mfaConfigurationUI = Mfa::getConfigurationInterface($this->getcurrentUser());

        $this->data->tags = new TagsHelper;
        $this->data->tags->getItemTags('com_users.user.', $this->data->id);

        // Backward compatibility
        $this->otpConfig = $modelUsers->getOtpConfig();
    }

    protected function _prepareDocument()
    {
        PhocacartRenderFront::prepareDocument($this->getDocument(), $this->getParams(), false, false, Text::_('COM_PHOCACART_ACCOUNT'));
    }

    public function renderField(FormField $field): string
    {
        $return = str_replace('form-control', $this->classMap('inputbox.form-control'), $field->renderField());
        $return = str_replace('form-select', $this->classMap('inputbox.form-select'), $return);
        $return = str_replace('btn btn-secondary', $this->classMap('btn.btn-secondary'), $return);

        return $return;
    }
}
