<?php

require_once 'Zend/Controller/Action.php';

class Tunes_ArtistController extends Zend_Controller_Action 
{
    public function init()
    {
        $calledAction     = $this->getRequest()->getActionName();
        $calledController = $this->getRequest()->getControllerName();

        if ($calledAction != 'navigation' && $calledController == 'artist') {
            $request = clone $this->getRequest();
            $request->setParam('currentAction', $request->getActionName())->setActionName('navigation');
            $this->_helper->ActionStack($request);
        }
        $this->view->pageTitle = 'Artists';
    }


    public function indexAction()
    {
        $this->_helper->Redirector('list');
    }

    public function listAction()
    {
        
        $artist_table = new Artists();
        $artists = $artist_table->fetchAll(null, 'name ASC');
        $this->view->assign('artists', $artists);
        
    }

    public function showAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            $this->_helper->Redirector->goto('list'); 
        }
        $artists_table = new Artists();
        $where = $artists_table->getAdapter()->quoteInto('id = ?', $id);
        $artist = $artists_table->fetchRow($where);
        
        $this->view->assign('artist', $artist);
    }
    
    public function newAction()
    {
        $artistForm = new ArtistForm();
        
        if ($this->getRequest()->isPost() && $artistForm->isValid($_POST)) {
            $artists_table = new Artists();
            $artist = $artists_table->createRow();
            $artist->setFromArray($artistForm->getValues());
            $artist->save();
            $this->_helper->Redirector->goto('list');
        }
        
        $artistForm->setAction($this->view->url());
        $this->view->assign('form', $artistForm);
        $this->view->assign('heading', 'Add New Artist');
        $this->render('form');
    }
    
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if (!$id) {
            $this->_helper->Redirector->goto('list'); 
        }
        $artists_table = new Artists();
        $where = $artists_table->getAdapter()->quoteInto('id = ?', $id);
        $artist = $artists_table->fetchRow($where);
        
        $artistForm = new ArtistForm();
        
        if ($this->getRequest()->isPost() && $artistForm->isValid($_POST)) {
            $data = $artistForm->getValues();
            unset($data['submit']);
            unset($data['cancel']);

            $artist->setFromArray($data);
            $artist->save();
            $this->_helper->Redirector->goto('list');
        }

        $artistForm->setAction($this->view->url());
        $artistForm->populate($artist->toArray());
        $this->view->assign('form', $artistForm);
        $this->view->assign('heading', 'Edit Artist');
        $this->render('form');
    }

    public function deleteAction()
    {
        
    }

    public function navigationAction()
    {
        $localnav = array('List', 'New', 'Search');
        $this->view->assign('localnav', $localnav);
        $this->view->assign('action', $this->getRequest()->getParam('currentAction'));
        $this->render('localnav', 'localnav', true);
    }
}