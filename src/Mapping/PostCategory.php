<?php


namespace Mapping;

class PostCategory
{
    private $id;

    private $name;

    private $category;

    private $post_id;

    private $category_id;

    private $createAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCategoryId(): ?string
    {
        return $this->category_id;
    }

    public function setCategoryId(string $category): void
    {
        $this->category_id = $category;
    }


    public function getPostId(): ?string
    {
        return $this->post_id;
    }

    public function setPostId(string $post): void
    {
        $this->post_id = $post;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}