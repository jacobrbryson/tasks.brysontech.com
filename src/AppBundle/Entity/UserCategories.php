<?php

namespace AppBundle\Entity;

/**
 * UserCategories
 */
class UserCategories
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $categoryId;


    /**
     * Set userId.
     *
     * @param int $userId
     *
     * @return UserCategories
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set categoryId.
     *
     * @param int $categoryId
     *
     * @return UserCategories
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
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
