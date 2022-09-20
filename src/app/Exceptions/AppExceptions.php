<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Basic\AppBasicException;
use App\Exceptions\Basic\AppNotFoundResourceException;
use App\Exceptions\Logic\AppInvalidArgumentException;
use App\Exceptions\Logic\AppLogicException;
use App\Exceptions\Runtime\AppAccessDeniedException;
use App\Exceptions\Runtime\AppBadRequestException;
use App\Exceptions\Runtime\AppBadRouteParameterException;
use App\Exceptions\Runtime\AppExpiredPageByCSRFException;
use App\Exceptions\Runtime\AppNotFoundEndpointException;
use App\Exceptions\Runtime\AppNotFoundPageException;
use App\Exceptions\Runtime\AppRuntimeException;
use App\Exceptions\Runtime\AppTooManyAttemptException;
use Throwable;

final class AppExceptions
{
    const ARG_ATTRIBUTE = 'attribute';

    public static function badRequest(
        string $message = '',
        ?Throwable $previous = null
    ): AppBadRequestException {
        return new AppBadRequestException(
            $message,
            $previous
        );
    }

    public static function badRouteParam(
        ?string $attribute = null,
        string $message = '',
        ?Throwable $previous = null
    ): AppBadRouteParameterException {
        return new AppBadRouteParameterException(
            $attribute,
            $message,
            $previous
        );
    }

    public static function notFoundResource(
        ?string $attribute = null,
        string $message = '',
        ?Throwable $previous = null
    ): AppNotFoundResourceException {
        return new AppNotFoundResourceException(
            $attribute,
            $message,
            $previous
        );
    }

    public static function notFoundEndpoint(
        string $message = '',
        ?Throwable $previous = null
    ): AppNotFoundEndpointException {
        return new AppNotFoundEndpointException(
            $message,
            $previous
        );
    }

    public static function notFoundPage(
        string $message = '',
        ?Throwable $previous = null
    ): AppNotFoundPageException {
        return new AppNotFoundPageException(
            $message,
            $previous
        );
    }

    public static function expiredPageByCSRF(
        string $message = '',
        ?Throwable $previous = null
    ): AppExpiredPageByCSRFException {
        return new AppExpiredPageByCSRFException(
            $message,
            $previous
        );
    }

    public static function tooManyAttempts(
        string $message = '',
        ?Throwable $previous = null
    ): AppTooManyAttemptException {
        return new AppTooManyAttemptException(
            $message,
            $previous
        );
    }

    public static function accessDenied(
        string $message = '',
        ?Throwable $previous = null
    ): AppAccessDeniedException {
        return new AppAccessDeniedException(
            $message,
            $previous
        );
    }

    public static function logicException(
        AppErrorCode $appErrorCode,
        string $message = '',
        ?Throwable $previous = null
    ): AppLogicException {
        return new AppLogicException(
            $appErrorCode,
            [],
            $message,
            $previous
        );
    }

    public static function invalidArgumentException(
        AppErrorCode $appErrorCode,
        string $message = '',
        ?Throwable $previous = null
    ): AppInvalidArgumentException {
        return new AppInvalidArgumentException(
            $appErrorCode,
            [],
            $message,
            $previous
        );
    }

    public static function runtimeException(
        AppErrorCode $appErrorCode,
        string $message = '',
        ?Throwable $previous = null
    ): AppRuntimeException {
        return new AppRuntimeException(
            $appErrorCode,
            [],
            $message,
            $previous
        );
    }

    public static function basicException(
        AppErrorCode $appErrorCode,
        string $message = '',
        ?Throwable $previous = null
    ): AppBasicException {
        return new AppBasicException(
            $appErrorCode,
            [],
            $message,
            $previous
        );
    }

}
