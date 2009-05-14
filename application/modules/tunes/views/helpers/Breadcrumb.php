<?php

class Tunes_View_Helper_Breadcrumb extends Zend_View_Helper_Placeholder_Container_Standalone
{

    /**
     * Registry key for placeholder
     * @var string
     */
    protected $_regKey = 'Mmx_View_Helper_Breadcrum';

    protected $_isEmpty = true;

    public function __construct()
    {
        parent::__construct();
        $this->setSeparator(' > ');
    }

    /**
     * Retrieve placeholder for breacrum element and optionally set state
     *
     * @param  string $item
     * @param  string $setType
     * @return Mmx_View_Helper_Breadcrum
     */
    public function breadcrumb($item = null, $setType = Zend_View_Helper_Placeholder_Container_Abstract::APPEND)
    {
        if ($item) {
            if (is_string($item)) {
                $item = array('name' => $item , 'key' => $item);
            }
            if (! isset($item['key'])) {
                $item['key'] = $item['name'];
            }
            if ($setType == Zend_View_Helper_Placeholder_Container_Abstract::SET) {
                $this->set($item);
            } elseif ($setType == Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) {
                $this->prepend($item);
            } else {
                $this->append($item);
            }
            $this->_isEmpty = false;
        }
        
        return $this;
    }

    public function setupFromModuleLayout()
    {
        $front = Zend_Controller_Front::getInstance();
        $request = $front->getRequest();
        $moduleName = $request->getModuleName();
        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();
        
        $this->exchangeArray(array());
        
        // level 2 : action name (level 1 with default module)
        if ($actionName != $front->getDefaultAction()) {
            // last item: no url
            $item = array('name' => $actionName); // 'url'=>
            $this->view->url(array('module'=>$moduleName,
            'controller'=>$controllerName, 'action'=>$actionName), null, true);
            
            $this->breadcrumb($item, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
        }
        
        // level 1 : controller name (level 0 with default module)
        if ($controllerName != $front->getDefaultControllerName()) {
            $item = array();
            $item['name'] = $controllerName;
            // if last item: no url
            if (! $this->_isEmpty) {
                $item['url'] = $this->view->url(array('module' => $moduleName , 'controller' => $controllerName), null, true);
            }
            $this->breadcrumb($item, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
        }
        
        // level 0 : module name
        if ($moduleName != $front->getDefaultModule()) {
            $item = array();
            $item['name'] = $moduleName;
            // if last item: no url
            if (! $this->_isEmpty) {
                $item['url'] = $this->view->url(array('module' => $moduleName), null, true);
            }
            $this->breadcrumb($item, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
        }
    }

    public function getItemKey($level = 0)
    {
        //lazy setup
        if ($this->_isEmpty) {
            $this->setupFromModuleLayout();
        }
        if (! $this->offsetExists($level)) {
            return null;
        }
        $item = $this->offsetGet($level);
        return $item['key'];
    }

    public function isKeyEqual($key, $level = 0)
    {
        //lazy setup
        if ($this->_isEmpty) {
            $this->setupFromModuleLayout();
        }
        if (is_array($key)) {
            return in_array($this->getItemKey($level), $key);
        } else {
            return $key == $this->getItemKey($level) ? true : false;
        }
    }

    public function activateOnKeyEqual($key, $activationId, $level = 0)
    {
        //lazy setup
        if ($this->_isEmpty) {
            $this->setupFromModuleLayout();
        }
        if ($this->isKeyEqual($key, $level)) {
            return 'id="' . $activationId . '"';
        }
        return '';
    }

    public function toString($indent = null)
    {
        //lazy setup
        if ($this->_isEmpty) {
            $this->setupFromModuleLayout();
        }
        
        $indent = (null !== $indent) ? $this->_getWhitespace($indent) : $this->getIndent();
        
        $crumbs = array();
        foreach ($this as $item) {
            if (isset($item['url'])) {
                $crumbs[] = '<a href="' . $this->_escape($item['url']) . '">' . $this->_escape($item['name']) . '</a>';
            } else {
                $crumbs[] = $this->_escape($item['name']);
            }
        
        }

        $separator = $this->_escape($this->getSeparator());
        
        return $indent . implode($separator, $crumbs);
    }
} 