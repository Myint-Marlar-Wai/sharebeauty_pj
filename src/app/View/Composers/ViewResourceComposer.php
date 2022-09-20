<?php

namespace App\View\Composers;

use App\Http\ViewResources\Common\DefaultViewResource;
use App\Http\ViewResources\ViewResource;
use Illuminate\View\View;

class ViewResourceComposer
{

    /**
     * データをビューと結合
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (! $view->offsetExists('vr')) {
            $view->with('vr', $this->makeDefaultViewResource());
        }
    }

    protected function makeDefaultViewResource(): ViewResource
    {
        return app(DefaultViewResource::class);
    }
}
