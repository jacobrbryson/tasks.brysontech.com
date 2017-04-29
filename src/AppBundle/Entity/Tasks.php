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
     * @ORM\Column(type="integer")
     */
    private $siteId;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
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
    private $inProgress;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $owner;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $team;
    
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
    private $completed;

    /**
     * @ORM\Column(type="integer")
     */
    private $peerReviewed;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $achievementId;
    
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
     * Set siteId
     *
     * @param integer $siteId
     *
     * @return Tasks
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;

        return $this;
    }

    /**
     * Get siteId
     *
     * @return integer
     */
    public function getSiteId()
    {
        return $this->siteId;
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
}
