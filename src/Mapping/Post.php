<?php

namespace Mapping;

use DateTime;

class Post
{
    private $name;

    private $slug;

    private $content;

    private $createAt;

    private $id;

    private $category = [];


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;
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
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;
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
    }


    public function getCreateAt(): ?DateTime
    {
        if (!is_null($this->createAt)) {
           return new DateTime($this->createAt);
        }

        return $this->createAt;
    }

    /**
     * Undocumented function
     *
     * @return Category[]
     */
    public function getCategory(): array
    {
        return $this->category;
    }


    /**
     *
     * @param Category $category
     * @return void
     */
    public function setCategory(Category $category)
    {
        $this->category[] = $category;
    }
}