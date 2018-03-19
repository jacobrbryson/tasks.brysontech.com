<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 */
class Tasks{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $startDateTime;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $endDateTime;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $value;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $complete;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $owner;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $created;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $updated;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryId = 1;
    
    /**
     * @ORM\Column(type="text")
     */
    private $solution;
    
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
     * Set description
     *
     * @param string $description
     *
     * @return Tasks
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Tasks
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set complete
     *
     * @param integer $complete
     *
     * @return Tasks
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return integer
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set inProgress
     *
     * @param integer $inProgress
     *
     * @return Tasks
     */
    public function setInProgress($inProgress)
    {
        $this->inProgress = $inProgress;

        return $this;
    }

    /**
     * Get inProgress
     *
     * @return integer
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return Tasks
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return integer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set created
     *
     * @param integer $created
     *
     * @return Tasks
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return integer
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     *
     * @return Tasks
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set completed
     *
     * @param integer $completed
     *
     * @return Tasks
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return integer
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set peerReviewed
     *
     * @param integer $peerReviewed
     *
     * @return Tasks
     */
    public function setPeerReviewed($peerReviewed)
    {
        $this->peerReviewed = $peerReviewed;

        return $this;
    }

    /**
     * Get peerReviewed
     *
     * @return integer
     */
    public function getPeerReviewed()
    {
        return $this->peerReviewed;
    }

    /**
     * Set team
     *
     * @param integer $team
     *
     * @return Tasks
     */
    public function setTeam($team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return integer
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set achievementId
     *
     * @param integer $achievementId
     *
     * @return Tasks
     */
    public function setAchievementId($achievementId)
    {
        $this->achievementId = $achievementId;

        return $this;
    }

    /**
     * Get achievementId
     *
     * @return integer
     */
    public function getAchievementId()
    {
        return $this->achievementId;
    }

    /**
     * Set startDateTime
     *
     * @param integer $startDateTime
     *
     * @return Tasks
     */
    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    /**
     * Get startDateTime
     *
     * @return integer
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Set endDateTime
     *
     * @param integer $endDateTime
     *
     * @return Tasks
     */
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    /**
     * Get endDateTime
     *
     * @return integer
     */
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    /**
     * Set categoryId.
     *
     * @param int $categoryId
     *
     * @return Tasks
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }
    
    /**
     * Set solution
     *
     * @param string $solution
     *
     * @return Tasks
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Get solution
     *
     * @return string
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Get categoryId.
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
}
