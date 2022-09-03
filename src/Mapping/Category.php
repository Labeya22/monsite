<?php

namespace Mapping;

use DateTime;

class Category
{
    private $id;

    private $slug;

    private $category;

    private $createAt;

    private $post_id;


    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    
    public function getCreateAt(): ?DateTime
    {
        if (!is_null($this->createAt)) {
           return new DateTime($this->createAt);
        }

        return $this->createAt;
    }

    /**
     * Get the value of post_id
     */ 
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }
}