<?php

declare(strict_types=1);

namespace App\Components\View;

class PageInfo
{
    protected ?string $title = null;

    protected ?string $description = null;

    protected array $keywords = [];

    /**
     * @param string $title
     * @return static
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $description
     * @return static
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param ?array $keywords
     * @return static
     */
    public function setKeywords(?array $keywords): static
    {
        $this->keywords = $keywords ?? [];

        return $this;
    }

    public function getOutputTitle(): string
    {
        if ($this->title !== null && $this->title !== '') {
            return $this->title.' | '.config('app.name');
        } else {
            return config('app.name');
        }
    }

    public function getOutputDescription(): string
    {
        return $this->description ?? '';
    }

    public function getOutputKeywords(): string
    {
        return implode(',', $this->keywords);
    }
}
