<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categories")
 */
class Category{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text")
     */
    private $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $userId;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tasks
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Set userId
     *
     * @param string $userId
     *
     * @return Tasks
     */
    public function setuserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
    
     /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get userId
     *
     * @return string
     */
    public function getuserId()
    {
        return $this->userId;
    }
}
