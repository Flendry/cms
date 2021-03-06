<?php
/**
 * Created by PhpStorm.
 * User: Kuba
 * Date: 13.3.2018
 * Time: 13:48
 */

namespace App\Model;

use Nette;
use App\Model\Member as Member;

class Members
{

    public $database;

    private $id;
    private $style;
    private $bg_type;
    private $heading;
    private $active;
    private $position;
    private $image;
    private $members = [];


    /**
     * Members constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * @param int $id
     */
    public function initialize($id = -1){
        $this->id = $id;
        $this->setVariables($id);
    }

    public function setData($style, $bg_type, $heading, $active, $position, $image){
        $this->style = $style;
        $this->bg_type = $bg_type;
        $this->heading = $heading;
        $this->active = $active;
        $this->position = $position;
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function databaseInput(){
        return [
            'style' => $this->style,
            'bg_type' => $this->bg_type,
            'heading_1' => $this->heading,
            'active' => $this->active,
            'position' => $this->position,
            'image' => $this->image
        ];
    }

    public function getFormProperties(){

        return [
            'id' => $this->id,
            'heading_1' => $this->heading,
            'position' => $this->position,
            'active' => $this->active,
            'image' => $this->image
        ];
    }
    public function getColorProperties(){

        $style = json_decode($this->getStyle());


        return [
            'heading_1_color' => $style->heading_1_color,
            'text_color' => $style->text_color,
            'name_color' => $style->name_color,
            'background_color' => $style->background_color
        ];
    }


    public function saveToDb(){

        if(isset($this->id)){
            $this->database->table('block_members')->where('id', $this->id)->update($this->databaseInput());
        }
        else{
            $this->database->table('block_members')->insert($this->databaseInput());
        }

    }

    public function delete(){
        foreach ($this->getMembers() as $member){
            $member->delete();
        }
        $toDelete = $this->database->table('block_members')->where('id', $this->id)->fetch();
        if(file_exists($toDelete->image)){
            unlink($toDelete->image);
        }
        $toDelete->delete();
    }

    /**
     * @param $id
     */
    private function setVariables($id){
        $dbOut = $this->database->table('block_members');

        if(count($dbOut) > 0){
            $dbOut = $dbOut->where('id', $id)->fetch();
            $this->setStyle($dbOut->style);
            $this->setBgType($dbOut->bg_type);
            $this->setHeading($dbOut->heading_1);
            $this->setActive($dbOut->active);
            $this->setPosition($dbOut->position);
            $this->setImage($dbOut->image);

            $dbMembers = $this->database->table('members')->where('owner', $this->id);

            if(count($dbMembers) > 0){
                foreach ($dbMembers as $dbMember){
                    $i = new Member($this->database);
                    $i->initialize($dbMember->id);
                    $this->setMember($i);
                }
            }

        }
    }


    public function setMember(Member $member){
        $this->members[$member->getId()] = $member;
    }

    /**
     * @return mixed
     */
    public function membersCount()
    {
        return count($this->members);
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        if(isset($this->id)){
            return $this->id;
        }
        else{
            $newId =  $this->database->table('block_members')->where('style', $this->getStyle())->where('bg_type', $this->getBgType())->where('heading_1', $this->getHeading())->get('id');
            $this->setId($newId);
            return $newId;
        }
    }

    /**
     * @param mixed $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param mixed $style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * @return mixed
     */
    public function getBgType()
    {
        return $this->bg_type;
    }

    /**
     * @param mixed $bg_type
     */
    public function setBgType($bg_type)
    {
        $this->bg_type = $bg_type;
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param mixed $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Nette\Utils\ArrayList
     */
    public function getMembers()
    {
        return $this->members;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getMemberById($id){
        return $this->members[$id];
    }

    /**
     * @param Nette\Utils\ArrayList $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }




}