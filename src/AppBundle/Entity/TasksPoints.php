<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks_points")
 */
class TasksPoints{    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $userId;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return TasksPoints
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
     * Set score
     *
     * @param integer $score
     *
     * @return TasksPoints
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }
}
