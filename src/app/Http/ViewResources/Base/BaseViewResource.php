<?php

declare(strict_types=1);

namespace App\Http\ViewResources\Base;

use App\Components\View\PageInfo;
use App\Constants\Sessions\CommonSessions;
use App\Http\ViewResources\Support\ViewResourceUtil;
use App\Http\ViewResources\ViewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\ViewErrorBag;

class BaseViewResource implements ViewResource
{
    protected ?PageInfo $pageInfo = null;

    protected ViewErrorBag $errors;

    protected ?string $successMessage;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->errors = ($request->hasSession() ? $request->session()->get('errors') : null)
            ?: new ViewErrorBag();
        $this->successMessage = $request->hasSession() && $request->session()->has(CommonSessions::SUCCESS_MESSAGE) ?
            $request->session()->get(CommonSessions::SUCCESS_MESSAGE) : null;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function isPageInfoInitialized(): bool
    {
        return $this->pageInfo !== null;
    }

    public function getPageInfo(): PageInfo
    {
        if (! $this->isPageInfoInitialized()) {
            $this->handleSetupPageInfo();
        }

        return $this->pageInfo;
    }

    public function errors(): ViewErrorBag
    {
        return $this->errors;
    }

    public function getAlertErrorMessage(): ?string
    {
        return ViewResourceUtil::getAllErrorMessage($this->errors);
    }

    public function getAlertSuccessMessage(): ?string
    {
        return $this->successMessage;
    }

    public function getTitle(): ?string
    {
        return null;
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getKeywords(): ?array
    {
        return null;
    }

    protected function handleSetupPageInfo()
    {
        if ($this->pageInfo === null) {
            $this->pageInfo = new PageInfo();
        }
        $this->pageInfo->setTitle($this->getTitle())
            ->setDescription($this->getDescription())
            ->setKeywords($this->getKeywords());
    }
}
