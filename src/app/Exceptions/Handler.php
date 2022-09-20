<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Components\Route\RouteDetector;
use App\Constants\App\AppSystem;
use App\Exceptions\Runtime\AppInvalidSignatureException;
use App\Exceptions\Support\AppErrorPresentationInfo;
use App\Exceptions\Support\AppErrorResolvedInfo;
use App\Http\Resources\Error\ErrorJsonResponse;
use App\Http\ViewResources\Error\ErrorViewResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function routeDetector(): RouteDetector
    {
        return app(RouteDetector::class);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Override
    |--------------------------------------------------------------------------
    |
    |
    */

    public function render($request, Throwable $e)
    {
//        Log::debug('error.render', ['e' => $e]);
        Log::debug('error.render '.get_debug_type($e));

        return parent::render($request, $e);
    }

    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $this->routeDetector()->isApiRequest($request) ||
            parent::shouldReturnJson($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        Log::debug('error.unauthenticated '.get_debug_type($exception));

        return $this->shouldReturnJson($request, $exception)
            ? $this->unauthenticatedJsonCustom($request, $exception)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        Log::debug('error.convertValidationExceptionToResponse '.get_debug_type($e));
        // invalidJson or invalid
        return parent::convertValidationExceptionToResponse($e, $request);
    }

    protected function invalid($request, ValidationException $exception)
    {
        // default
        return parent::invalid($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->makeApiJson(
            message: $exception->getMessage(),
            code: AppErrorCode::ValidationError,
            httpStatusCode: $exception->status,
            e: $exception
        )->setResourceStatusCode($exception->status)
            ->setValidationErrors($exception->errors())
            ->response($request);
    }

    protected function renderExceptionResponse($request, Throwable $e)
    {
        Log::debug('error.renderExceptionResponse '.get_debug_type($e));
        // prepareJsonResponse or prepareResponse
        return parent::renderExceptionResponse($request, $e);
    }

    protected function prepareResponse($request, Throwable $e)
    {
        $pi = $this->convertToAppErrorPresentationInfo($request, $e);
        if ($pi->isUnknownException && app_core()->isDebug()) {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }
        $vr = ErrorViewResource::make(
            request: $request,
            message: $pi->message,
            appErrorCode: $pi->appCode,
            statusCode: $pi->status
        );

        $appSystem = app_core()->getSystem();
        $viewName = match ($appSystem) {
            AppSystem::Shop => 'shop.error.default',
            AppSystem::Seller => 'seller.error.default',
            AppSystem::Admin => 'admin.error.default',
            default => 'errors.default',
        };

        return response()->view($viewName, [
            'vr' => $vr,
        ], $pi->status, $pi->headers);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        $pi = $this->convertToAppErrorPresentationInfo($request, $e);

        return $this->makeApiJson(
            message: $pi->message,
            code: $pi->appCode,
            httpStatusCode: $pi->status,
            e: $e
        )->setResourceStatusCode($pi->resourceStatus)
            ->response($request)
            ->withHeaders($pi->headers);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param Throwable $e
     * @return Throwable
     */
    protected function prepareException(Throwable $e): Throwable
    {
        Log::debug('error.prepareException '.get_debug_type($e));
        $request = request();
        $isApi = $this->routeDetector()->isApiRequest($request);

        if ($e instanceof AppException) {
            $e->applyMessage();
        }

        if ($e instanceof InvalidSignatureException) {
            return new AppInvalidSignatureException($e->getMessage(), $e);
        }
        if ($e instanceof NotFoundHttpException) {
            if ($isApi) {
                return AppExceptions::notFoundEndpoint($e->getMessage(), $e);
            }

            return AppExceptions::notFoundPage($e->getMessage(), $e);
        }
        if ($e instanceof TokenMismatchException) {
            if (str_contains($e->getMessage(), 'CSRF')) {
                return AppExceptions::expiredPageByCSRF($e->getMessage(), $e);
            }
        }

        if ($e instanceof AuthorizationException && ! $e->hasStatus()) {
            return AppExceptions::accessDenied($e->getMessage(), $e);
        }

        if ($e instanceof ThrottleRequestsException) {
            return AppExceptions::tooManyAttempts($e->getMessage(), $e);
        }

        return parent::prepareException($e);
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Method
    |--------------------------------------------------------------------------
    |
    |
    */

    protected function getStatusMessageOrNull(int $status): ?string
    {
        if (array_key_exists(
            $status,
            \Symfony\Component\HttpFoundation\Response::$statusTexts)) {
            return \Symfony\Component\HttpFoundation\Response::$statusTexts[$status];
        }

        return null;
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return AppErrorPresentationInfo
     */
    protected function convertToAppErrorPresentationInfo($request, Throwable $e): AppErrorPresentationInfo
    {
        $result = new AppErrorPresentationInfo();
        if ($e instanceof AppException) {
            $info = $e->resolveInfo();
            $result->isHttpException = false;
            $result->isUnknownException = false;
            $result->status = $info->status;
            $result->resourceStatus = $info->resourceStatus;
            $result->message = $info->message;
            $result->appCode = $e->getAppErrorCode();
            $result->headers = [];

            if ($result->message === '') {
                $result->message = trans('error.app_error_default.message');
            }
        } else {
            $result->isHttpException = $this->isHttpException($e);
            $result->isUnknownException = ! $result->isHttpException;
            $result->status = $result->isHttpException ? $e->getStatusCode() : 500;
            $result->resourceStatus = null;
            $result->message = $result->isHttpException ? $e->getMessage() : 'Server Error';
            $result->appCode = ($result->status >= 400 && $result->status < 500) ?
                AppErrorCode::BadRequest : AppErrorCode::Unknown;
            $result->headers = $result->isHttpException ? $e->getHeaders() : [];
        }

        if ($result->isHttpException && $result->message === '') {
            if (($retMessage = $this->getStatusMessageOrNull($result->status)) !== null) {
                $result->message = $retMessage;
            }
        }

        return $result;
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticatedJsonCustom($request, AuthenticationException $e): JsonResponse
    {
        return $this->makeApiJson(
            message: $e->getMessage(),
            code: AppErrorCode::Unauthenticated,
            httpStatusCode: 401,
            e: $e
        )->response($request);
    }

    protected function makeApiJson(
        string $message,
        AppErrorCode $code,
        int $httpStatusCode,
        ?Throwable $e
    ): ErrorJsonResponse {
        $debugExceptionData = null;
        if ($e !== null && app_core()->isDebug()) {
            $debugExceptionData = $this->convertExceptionToArray($e);
        }

        return ErrorJsonResponse::makeByMc(
            message: $message,
            code: $code,
            httpStatusCode: $httpStatusCode
        )->setDebugExceptionData($debugExceptionData);
    }
}
