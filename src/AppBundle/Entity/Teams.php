<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Teams")
 */

class Team {    
        
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text")
     */
    private $teamName;
            
    /**
     * Get id
     * 
     * @return integer
     */
    
    public function getId(){
        
        return $this -> id;
    }
    
    /**
     * set teamName
     * 
     * @return string
     */
    
    public function setTeamName($teamName){
        $this->teamName = $teamName;
        
        return $this;
    }
    
    /**
     * get teamName
     * 
     * @return string
     */
    
    public function getTeamName(){
        return $this->teamName;
    }
}
