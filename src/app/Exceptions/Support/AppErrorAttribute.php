<?php

declare(strict_types=1);

namespace App\Exceptions\Support;

use Attribute;

#[Attribute]
class AppErrorAttribute
{
    /**
     * http status code
     * @var int
     */
    public readonly int $httpStatus;

    /**
     * resource status code
     * 使い分け
     *   リソースが見つからない場合は404
     *   リソースのパラメータが無効な場合は4xx
     *   APIのエンドポイントが存在しない場合はnull
     *   サーバーエラーの場合はnull
     * @var ?int
     */
    public readonly ?int $resStatus;

    /**
     * LogicExceptionの場合 (実装としてのエラー・バグ)
     * @var ?bool
     */
    public readonly ?bool $logic;

    /**
     * @param int $httpStatus
     * @param int|null $resStatus
     * @param bool|null $logic
     */
    public function __construct(int $httpStatus, ?int $resStatus = null, ?bool $logic = null)
    {
        $this->httpStatus = $httpStatus;
        $this->resStatus = $resStatus;
        $this->logic = $logic;
    }
}
