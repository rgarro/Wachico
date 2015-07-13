<?php

namespace Wachico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Wachico\Document\Role;
use Wachico\Document\Resource;
use Zend\Stdlib\InitializableInterface;

class AdminController extends AbstractRestfulController
{
    public $dm;

    public function init(){
        if (!$this->zfcUserAuthentication()->hasIdentity()|| $_SESSION['resource'] != "admin"){
            if($this->getRequest()->isXmlHttpRequest()){
                $return = array('error'=>1,"timed_out"=>1);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($return);
                exit;
            }else{
                header("Location: http://impuestos-ict.costaricapoint.com/");
                exit;
            }
        }else{
            $this->dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        }
    }

    public function indexAction()
    {
        $this->init();
        return new ViewModel();
    }

    public function stageAction()
    {
        $this->init();
        //return new ViewModel();
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }

    public function usuariosAction(){
        $this->init();
        //return new ViewModel();
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
    public function tiposdeclaracionAction(){
        $this->init();
        //return new ViewModel();
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
    public function resourcelistAction(){
        $this->init();
        $resources = $this->dm->createQueryBuilder('Wachico\Document\Resource')
            ->find()
            ->getQuery();
        $resources->execute();
        $view = new ViewModel(array('resources'=>$resources));
        $view->setTerminal(true);
        return $view;
    }

    public function getlistAction(){
        $this->init();
        //return new ViewModel();
        $roles = $this->dm->createQueryBuilder('Wachico\Document\Role')
            ->find()
            ->getQuery();
        $roles->execute();
        $view = new ViewModel(array('roles'=>$roles));
        $view->setTerminal(true);
        return $view;
    }

    public function rolerecursofrmAction(){
        $this->init();
        //return new ViewModel();
        $resources = $this->dm->createQueryBuilder('Wachico\Document\Resource')
            ->find()
            ->getQuery();
        $resources->execute();
        $view = new ViewModel(array('resources'=>$resources,'role_id'=>$_GET['role_id']));
        $view->setTerminal(true);
        return $view;
    }

    public function assignrolerecursosAction(){
        $this->init();
        $resources = array();
        foreach($_GET['resources'] as $r){
            $resources[] = $r;
        }
        $roleRepo = $this->dm->getRepository('Wachico\Document\Role');
        $role = $roleRepo->find($_GET['role_id']);
        if(!$role)  {
            $return = array('invalid_form'=>1,'error_list'=>array("Role ID Invalido:".$_GET['role_id']));
        }else{
            $role->setResources($resources);
            $this->dm->persist($role);
            $this->dm->flush();
            $return = array("id"=>$_GET['role_id'],'is_success'=>1,"flash"=>"Role ha modificado recursos");
        }
        return new JsonModel($return);
    }

    public function createAction(){
        $this->init();
        if(isset($_GET['role']['name'])){
            $role = new Role();
            $role->setName($_GET['role']['name']);
            $this->dm->persist($role);
            $this->dm->flush();
            $return = array("id"=>$role->getId(),'is_success'=>1,"flash"=>"Nuevo Role ha sido creado");
        }else{
            $return = array('invalid_form'=>1,'error_list'=>array("Nombre del Role es requerido"));
        }
        return new JsonModel($return);
    }

    public function deleteAction() {
        $this->init();
        $roleRepo = $this->dm->getRepository('Wachico\Document\Role');
        $role = $roleRepo->find($_GET['role_id']);
        $this->dm->remove($role);
        $this->dm->flush();
        $return = array("id"=>$_GET['role_id'],'is_success'=>1,"flash"=>"Role ha sido borrado");
        return new JsonModel($return);
    }

    public function deleterecursoAction(){
        $this->init();
        $resourceRepo = $this->dm->getRepository('Wachico\Document\Resource');
        $resource = $resourceRepo->find($_GET['resource_id']);
        $this->dm->remove($resource);
        $this->dm->flush();
        $return = array("id"=>$_GET['resource_id'],'is_success'=>1,"flash"=>"Recurso ha sido borrado");
        return new JsonModel($return);
    }

    public function createresourceAction(){
        $this->init();
        if(isset($_GET['resource'])){
            $resource = new Resource();
            $resource->setFormData($_GET['resource']);
            $this->dm->persist($resource);
            $this->dm->flush();
            $return = array("id"=>$resource->getId(),'is_success'=>1,"flash"=>"Nuevo Recurso ha sido creado");
        }else{
            $return = array('invalid_form'=>1,'error_list'=>array("Debe de suplir los datos del recurso"));
        }
        return new JsonModel($return);
    }

    public function get($id){

    }

    public function getList(){

    }

    public function update($id, $data){

    }
}

