<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_teams")
 */
class User_Teams {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $userId;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $teamId;
}