<?php

namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Page
{
    private Collection $content;
    private int $totalElements;
    private int $offset;
    private int $limit;

    public function __construct()
    {
        $this->content = new ArrayCollection();
    }


    public static function of(Collection $content, int $totalElements, int $offset = 0, int $limit = 20): Page
    {
        $page = new Page();
        $page->setContent($content)
            ->setTotalElements($totalElements)
            ->setOffset($offset)
            ->setLimit($limit);

        return $page;
    }

    public function setContent(Collection $content): Page
    {
        $this->content = $content;
        return $this;
    }

    public function setTotalElements(int $totalElements): Page
    {
        $this->totalElements = $totalElements;
        return $this;
    }

    public function setOffset(int $offset): Page
    {
        $this->offset = $offset;
        return $this;
    }

    public function setLimit(int $limit): Page
    {
        $this->limit = $limit;
        return $this;
    }


    public function getContent(): Collection
    {
        return $this->content;
    }

    public function getTotalElements(): int
    {
        return $this->totalElements;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
