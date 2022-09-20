<?php

declare(strict_types=1);

namespace App\Services\Demo;

use App\Data\Demo\DemoFormEnum;
use App\Data\Demo\DemoFormId;
use App\Exceptions\AppExceptions;
use App\Exceptions\Basic\AppNotFoundResourceException;
use App\Exceptions\Demo\AppDemoNeedsInputProfileException;
use App\Repositories\Demo\DemoFormRepository;
use App\Services\Base\BaseService;

class DemoFormDefaultService extends BaseService implements DemoFormService
{
    private DemoFormRepository $demoFormRepository;

    /**
     * @param DemoFormRepository $demoFormRepository
     */
    public function __construct(DemoFormRepository $demoFormRepository)
    {
        $this->demoFormRepository = $demoFormRepository;
    }

    /**
     * @param DemoFormUpdateInput $input
     * @return DemoFormShowOutput
     * @throws AppDemoNeedsInputProfileException
     */
    public function updateForm(DemoFormUpdateInput $input): DemoFormShowOutput
    {
        if ($input->bravo->demoFormEnum === DemoFormEnum::Blue) {
            // これは、プロフィール入力未完了状態で更新を行ったという条件の代わりです。
            throw new AppDemoNeedsInputProfileException();
        }
        $this->demoFormRepository->updateAlpha($input->alpha);
        $this->demoFormRepository->updateBravo($input->bravo);
        return $this->showForm($input->id);
    }

    /**
     * @throws AppNotFoundResourceException
     */
    public function showForm(DemoFormId $id): DemoFormShowOutput
    {
        $output = new DemoFormShowOutput();

        if ($id->getInt() % 10 === 4) {
            throw AppExceptions::notFoundResource(
                DemoFormId::TYPE_NAME
            );
        }
        if ($id->getInt() % 10 === 5) {
            throw new \LogicException('Sample Internal Error!!');
        }
        $output->alpha = $this->demoFormRepository->getAlpha($id);
        $output->bravo = $this->demoFormRepository->getBravo($id);

        return $output;
    }

    public function clearForm(DemoFormId $id): DemoFormShowOutput
    {
        $this->demoFormRepository->deleteAlpha($id);
        $this->demoFormRepository->deleteBravo($id);
        return $this->showForm($id);
    }
}
