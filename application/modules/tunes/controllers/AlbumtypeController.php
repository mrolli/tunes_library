<?php

require_once 'Zend/Controller/Action.php';

class Tunes_AlbumtypeController extends Zend_Controller_Action
{
    public function init()
    {
        $calledAction     = $this->getRequest()->getActionName();
        $calledController = $this->getRequest()->getControllerName();

        if ($calledAction != 'navigation' && $calledController == 'albumtype') {
            $request = clone $this->getRequest();
            $request->setParam('currentAction', $request->getActionName())->setActionName('navigation');
            $this->_helper->ActionStack($request);
        }
        $this->view->pageTitle = 'Album Types';
    }
    
    public function indexAction()
    {
        $this->_helper->Redirector->goto('list');
    }
    
    public function listAction()
    {
        $albumTypeTable = new AlbumType();
        $albumTypes = $albumTypeTable->fetchAll();
        $this->view->assign('albumTypes', $albumTypes);
    }
    
    public function newAction()
    {
        $form = new AlbumTypeForm();
        if ($this->getRequest()->isPost() && $form->isValid($_POST)) {
            $albumTypeTable = new AlbumType();
            $data = array('label' => $form->getValue('label'));
            $row = $albumTypeTable->createRow($data);
            $row->save();
            $this->_helper->Redirector->goto('list');
        }
        $this->view->assign('form', $form);
        $this->view->assign('heading', 'New Album Type');
        $this->render('form');
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            $this->getHelper('Redirector')->goto('list');
        }
        $albumTypeTable = new AlbumType();
        $where = $albumTypeTable->getAdapter()->quoteInto('id = ?', $id);
        $albumType = $albumTypeTable->fetchRow($where);
        $form = new AlbumTypeForm();
        $form->populate($albumType->toArray());
        if ($this->getRequest()->isPost() && $form->isValid($_POST)) {
            $albumType->setFromArray(array('label' => $form->getValue('label')));
            $albumType->save();
            $this->_helper->Redirector->goto('list');
        }
        $this->view->assign('form', $form);
        $this->view->assign('heading', 'Edit Album Type');
        $this->render('form');
    }
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            $this->getHelper('Redirector')->goto('list');
        }
        $albumTypeTable = new AlbumType();
        $where = $albumTypeTable->getAdapter()->quoteInto('id = ?', $id);
        $albumTypeTable->delete($where);
        $this->_helper->Redirector->goto('list');
    }
    
    public function navigationAction()
    {
        $localnav = array('List', 'New');
        $this->view->assign('localnav', $localnav);
        $this->view->assign('action', $this->getRequest()->getParam('currentAction'));
        $this->render('localnav', 'localnav', true);
    }
}