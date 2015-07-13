<?php
namespace Wachico\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="resource") */
class Resource
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $label;
    /** @ODM\Field(type="string") */
    private $path;
    /** @ODM\Field(type="string") */
    private $module;
    /** @ODM\Field(type="string") */
    private $controller;
    /** @ODM\Field(type="string") */
    private $action;

    /**
     * @return the $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return the $name
     */
    public function getLabel() {
        return $this->label;
    }

    public function getPath() {
        return $this->path;
    }

    public function getModule() {
        return $this->module;
    }

    public function getController() {
        return $this->controller;
    }
    public function getAction() {
        return $this->action;
    }
    /**
     * @param field_type $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @param field_type $name
     */
    public function setLabel($name) {
        $this->label = $name;
    }
    public function setPath($name) {
        $this->path = $name;
    }
    public function setModule($name) {
        $this->module = $name;
    }
    public function setController($name) {
        $this->controller = $name;
    }
    public function setAction($name) {
        $this->action = $name;
    }
    public function setFormData($data){
        $this->label = $data['label'];
        $this->path = $data['path'];
        $this->module = $data['module'];
        $this->controller = $data['controller'];
        $this->action = $data['action'];
    }
}
