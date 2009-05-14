<?php

require_once 'Zend/Controller/Action.php';

class Tunes_AlbumController extends Zend_Controller_Action
{
    public function init()
    {
        $calledAction     = $this->getRequest()->getActionName();
        $calledController = $this->getRequest()->getControllerName();

        if ($calledAction != 'navigation' && $calledController == 'album') {
            $request = clone $this->getRequest();
            $request->setParam('currentAction', $request->getActionName())->setActionName('navigation');
            $this->_helper->ActionStack($request);
        }
        $this->view->pageTitle = 'Albums';
    }

    public function indexAction()
    {
        $this->_helper->Redirector->goto('list');        
    }

    public function listAction()
    {
        $album_table = new Albums();
        $artistId = intval($this->getRequest()->getParam('artistId', false));
        if ($artistId) {
            $oneArtistOnly = true;
            $where = $album_table->getAdapter()->quoteInto('artist_id = ?', $artistId);
            $order = 'year ASC';
        } else {
            $oneArtistOnly = false;
            $where = null; 
            $order = 'name ASC';
        }
        $albums = $album_table->fetchAll($where, $order);
        if($albums) {
            $this->view->assign('albums', $albums);
            $this->view->assign('oneArtistOnly', $oneArtistOnly);
        }
    }
    
    public function showAction()
    {

    }
    
    public function newAction()
    {
        $albumForm = new AlbumForm();
        $this->view->assign('albumForm', $albumForm);
        $this->view->assign('heading', 'Add new album');
        $this->render('form');
    }
    
    public function editAction()
    {
        $album_id = $this->getRequest()->getParam('id', false);
        if (!$album_id) {
            $this->getHelper('Redirector')->goto('list');
        }

        $albumTable = new Albums();
        $album = $albumTable->fetchRow(array('id = ?' => $album_id));
        
        $albumForm = new AlbumForm(); 
        $albumForm->populate($album->toArray());
        
        if ($this->getRequest()->isPost() && $albumForm->isValid($_POST)) {
            echo 'Yuhu';
        }
        $this->view->assign('albumForm', $albumForm);
        $this->view->assign('heading', 'Edit Album');
        $this->render('form');
    }
    
    public function deleteAction()
    {
        
    }
    
    public function navigationAction()
    {
        $localnav = array('List', 'New');
        $this->view->assign('localnav', $localnav);
        $this->view->assign('action', $this->getRequest()->getParam('currentAction'));
        $this->render('localnavigation', 'localnavi', true);
    }
}