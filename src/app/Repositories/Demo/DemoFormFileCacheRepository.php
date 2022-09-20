<?php

declare(strict_types=1);

namespace App\Repositories\Demo;

use App\Data\Demo\DemoFormAlphaData;
use App\Data\Demo\DemoFormBravoData;
use App\Data\Demo\DemoFormId;
use App\Repositories\Base\BaseRepository;
use Cache;

class DemoFormFileCacheRepository extends BaseRepository implements DemoFormRepository
{

    const KEY_PREFIX_ALPHA = '_demo.form.alpha.';
    const KEY_PREFIX_BRAVO = '_demo.form.bravo.';

    protected function store(): \Illuminate\Contracts\Cache\Repository
    {
        return Cache::store('file');
    }

    protected function putObject(string $key, object $value): void
    {
        $this->store()->put($key, $value);
    }

    protected function getObjectOrNull(string $key, ?object $defaultValue = null): ?object
    {
        return $this->store()->get($key, $defaultValue);
    }

    protected function delete(string $key)
    {
        $this->store()->forget($key);
    }

    public function deleteAlpha(DemoFormId $id)
    {
        $this->delete(self::KEY_PREFIX_ALPHA.$id->getInt());
    }

    public function deleteBravo(DemoFormId $id)
    {
        $this->delete(self::KEY_PREFIX_BRAVO.$id->getInt());
    }

    public function updateAlpha(DemoFormAlphaData $data)
    {
        $this->putObject(self::KEY_PREFIX_ALPHA.$data->id->getInt(), $data);
    }

    public function updateBravo(DemoFormBravoData $data)
    {
        $this->putObject(self::KEY_PREFIX_BRAVO.$data->id->getInt(), $data);
    }


    public function getAlpha(DemoFormId $id): DemoFormAlphaData
    {
        $data = $this->getObjectOrNull(self::KEY_PREFIX_ALPHA.$id->getInt());

        if ($data === null) {
            $data = DemoFormAlphaData::makeWithId($id);
        }

        return $data;
    }

    public function getBravo(DemoFormId $id): DemoFormBravoData
    {
        $data = $this->getObjectOrNull(self::KEY_PREFIX_BRAVO.$id->getInt());

        if ($data === null) {
            $data = DemoFormBravoData::makeWithId($id);
        }

        return $data;
    }
}
