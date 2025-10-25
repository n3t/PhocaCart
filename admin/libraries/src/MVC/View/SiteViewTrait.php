<?php
/* @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @extension Phoca Extension
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

namespace Phoca\PhocaCart\MVC\View;

use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\Registry\Registry;

defined('_JEXEC') or die;

trait SiteViewTrait
{
    protected ?Registry $componentParams = null;
    protected ?array $styles = null;
    protected ?Registry $classMap = null;
    protected ?Registry $icons = null;
    protected ?Registry $displayData = null;
    protected User|null|false $user = null;

    public function getParams(): Registry
    {
        if ($this->componentParams === null) {
            $this->componentParams = Factory::getApplication()->getParams();
        }

        return $this->componentParams;
    }

    public function param(string $name, mixed $default = null): mixed
    {
        return $this->getParams()->get($name, $default);
    }

    protected function getStyles(?string $section = null): array
    {
        if ($this->styles === null) {
            $this->styles = \PhocacartRenderStyle::getStyles();
        }

        if ($section !== null) {
            return $this->styles[$section] ?? [];
        }

        return $this->styles;
    }

    public function classMap(string $class): string
    {
        if ($this->classMap === null) {
            $this->classMap = new Registry($this->getStyles('c'), '/');
        }

        $classList = explode(' ', $class);

        foreach ($classList as &$class) {
            $class = $this->classMap->get($class, $class);
        }

        return implode(' ', $classList);
    }

    public function icon(string $icon): string
    {
        if ($this->icons === null) {
            $this->icons = new Registry($this->getStyles('i'));
        }

        return $this->icons->get($icon);
    }

    public function data(string $name = null, mixed $value = null): mixed
    {
        if ($this->displayData === null) {
            $this->displayData = new Registry();
        }

        if ($name === null) {
            return $this->displayData->toArray();
        }

        if ($value !== null) {
            $this->displayData->set($name, $value);
        }

        return $this->displayData->get($name);
    }

    public function getUser(): User|false
    {
        if ($this->user === null) {
            $this->user = \PhocacartUser::getUser();
        }

        return $this->user;
    }

    public function isLogged(): bool
    {
        $user = $this->getUser();
        return $user && $user->id > 0;
    }

}
