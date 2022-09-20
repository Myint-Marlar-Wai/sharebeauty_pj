<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Common;

use App\Http\ViewResources\Base\BaseViewResource;
use Illuminate\Http\Request;

class DefaultViewResource extends BaseViewResource
{
    protected ?string $title = null;

    protected ?string $description = null;

    protected ?array $keywords = null;

    public static function make(Request $request): self
    {
        return new self($request);
    }

    /**
     * @param string|null $title
     * @return DefaultViewResource
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string|null $description
     * @return DefaultViewResource
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param array|null $keywords
     * @return DefaultViewResource
     */
    public function setKeywords(?array $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }


}
