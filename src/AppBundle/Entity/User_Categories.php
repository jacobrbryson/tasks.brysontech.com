<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_categories")
 */
class User_Categories {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $userId;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $categoryId;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return User_Categories
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return User_Categories
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
}
