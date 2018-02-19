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
}
