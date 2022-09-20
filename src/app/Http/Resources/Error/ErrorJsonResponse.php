<?php

declare(strict_types=1);

namespace App\Http\Resources\Error;

use App\Exceptions\AppErrorCode;
use App\Http\Resources\Base\BaseAppJsonResponse;
use App\Services\Demo\DemoFormShowOutput;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use JsonSerializable;
use Throwable;

class ErrorJsonResponse extends BaseAppJsonResponse
{
    public static $wrap = 'error';

    public string $message;

    public AppErrorCode $code;

    public int $httpStatusCode;

    public array $validationErrors = [];

    public ?int $resourceStatusCode = null;

    public ?array $debugExceptionData = null;

    /**
     * @param array|null $debugExceptionData
     * @return ErrorJsonResponse
     */
    public function setDebugExceptionData(?array $debugExceptionData): static
    {
        $this->debugExceptionData = $debugExceptionData;

        return $this;
    }

    /**
     * @param int $httpStatusCode
     * @return ErrorJsonResponse
     */
    public function setHttpStatusCode(int $httpStatusCode): static
    {
        $this->httpStatusCode = $httpStatusCode;

        return $this;
    }

    /**
     * @param int|null $resourceStatusCode
     * @return ErrorJsonResponse
     */
    public function setResourceStatusCode(?int $resourceStatusCode): static
    {
        $this->resourceStatusCode = $resourceStatusCode;

        return $this;
    }


    /**
     * @param array $errors
     * @return ErrorJsonResponse
     */
    public function setValidationErrors(array $errors): static
    {
        $formatErrors = [];
        foreach ($errors as $key => $errorsInKey) {
            foreach ($errorsInKey as $index => $errorInKey) {
                if (is_string($errorInKey)) {
                    $formatErrors[$key][] = [
                        'message' => $errorInKey,
                        'code' => null,
                    ];
                } else {
                    $formatErrors[$key][] = $errorInKey;
                }
            }
        }

        $this->validationErrors = $formatErrors;

        return $this;
    }


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        $validationErrors = $this->validationErrors;
        if (empty($validationErrors)) {
            $validationErrors = null;
        }

        $message = $this->message;
        if ($message === '') {
            $message = 'Server Error';
        }

        return [
            'message' => $message,
            'code' => $this->code->value,
            'validation_errors' => $validationErrors,
            'resource_status' => $this->resourceStatusCode,
        ];
    }

    public function with($request)
    {
        $extras = [];
        if ($this->debugExceptionData !== null) {
            $extras['_debug_exception'] = $this->debugExceptionData;
        }

        return array_merge(parent::with($request), $extras);
    }

    public function withResponse($request, $response)
    {
        parent::withResponse($request, $response);
        $response->setStatusCode($this->httpStatusCode);
    }

    public static function makeByMc(
        string $message,
        AppErrorCode $code,
        int $httpStatusCode
    ): static {
        $ret = new self(null);
        $ret->message = $message;
        $ret->code = $code;
        $ret->httpStatusCode = $httpStatusCode;

        return $ret;
    }
}
