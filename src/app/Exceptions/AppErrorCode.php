<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Support\AppErrorAttribute as Attr;
use LogicException;
use ReflectionEnumBackedCase;

enum AppErrorCode: int
{
    /*
    |--------------------------------------------------------------------------
    | 一般エラー
    |--------------------------------------------------------------------------
    |
    |
    */

    #[Attr(httpStatus: 400)]
    case BadRequest = 400001;

    #[Attr(httpStatus: 400)]
    case BadRequestJson = 400002;

    #[Attr(httpStatus: 400, resStatus: 400)]
    case BadRequestRouteParameter = 400003;

    #[Attr(httpStatus: 400, resStatus: 400)]
    case BadRequestParameter = 400004;

    #[Attr(httpStatus: 401)]
    case Unauthenticated = 401001;

    #[Attr(httpStatus: 403)]
    case AccessDenied = 403001;

    #[Attr(httpStatus: 403)]
    case InvalidSignature = 403002;

    #[Attr(httpStatus: 404)]
    case NotFoundPage = 404001;

    #[Attr(httpStatus: 404)]
    case NotFoundEndpoint = 404002;

    #[Attr(httpStatus: 404, resStatus: 404)]
    case NotFoundResource = 404003;

    #[Attr(httpStatus: 419)]
    case ExpiredPageByCSRF = 419001;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case ValidationError = 422001;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case InvalidParameter = 422002;

    #[Attr(httpStatus: 419)]
    case TooManyAttempts = 429001;

    #[Attr(httpStatus: 500)]
    case Unknown = 500001;

    /*
    |--------------------------------------------------------------------------
    | ドメイン別エラー
    |--------------------------------------------------------------------------
    |
    |
    */

    #[Attr(httpStatus: 422, resStatus: 422)]
    case DemoDomainExample = 422101;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case DemoNeedsInputProfile = 422102;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case UserAlreadyExists = 422103;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case NoPasswordOnPasswordChange = 422104;

    #[Attr(httpStatus: 422, resStatus: 422)]
    case MismatchCurrentPassword = 422105;

    /*
    |--------------------------------------------------------------------------
    | 個別の内部エラー Logic Exception
    |--------------------------------------------------------------------------
    |
    |
    */

    #[Attr(httpStatus: 500)]
    case LOGIC_EXCEPTION_GENERAL = 500101;

    #[Attr(httpStatus: 500)]
    case LOGIC_EXCEPTION_NO_DEF_BASE_RULE_LANG = 500102;

    #[Attr(httpStatus: 500)]
    case LOGIC_EXCEPTION_ILLEGAL_AUTH_USER_MODEL = 500103;

    #[Attr(httpStatus: 500)]
    case LOGIC_EXCEPTION_NO_EMAIL_ON_LOGIN_EVENT = 500104;

    /*
    |--------------------------------------------------------------------------
    | 個別の内部エラー Invalid Argument 間違った引数のエラー
    |--------------------------------------------------------------------------
    |
    |
    */

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_GENERAL = 500201;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_INT_ID = 500202;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_STRING_CODE = 500203;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_BANK_CODE = 500211;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DEMO_FORM_ID = 500221;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_ORDER_ID = 500231;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_ORDER_ID_FIXED_DIGITS = 500232;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_ORDER_ID_MIN_VALUE = 500233;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_SHOP_ID = 500241;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_SHOP_ID = 500251;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_SELLER_ID = 500261;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_EMAIL_ADDRESS = 500271;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_PASSWORD = 500281;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_PASSWORD_SYMBOLS = 500282;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_PASSWORD_NUMBERS = 500283;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_PASSWORD_UPPERCASE_LETTERS = 500284;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_PASSWORD_LOWERCASE_LETTERS = 500285;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_GOOGLE_ID = 500291;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_MEMBER_ID = 500301;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_MEMBER_ID = 500311;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_MEMBER_ID_FIXED_DIGITS = 500312;
    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_DISPLAY_MEMBER_ID_MIN_VALUE = 500313;

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_ADMIN_USER_ID = 500321;

    // バリデーションルール

    #[Attr(httpStatus: 500)]
    case INVALID_ARGUMENT_RULE_BASE_ENUM_CLASS_TYPE = 500401;

    /*
    |--------------------------------------------------------------------------
    | 個別の内部エラー Runtime Exception
    |--------------------------------------------------------------------------
    |
    |
    */

    #[Attr(httpStatus: 500)]
    case RUNTIME_EXCEPTION_GENERAL = 500501;

    #[Attr(httpStatus: 500)]
    case RUNTIME_EXCEPTION_ILLEGAL_GOOGLE_AUTH_EMAIL = 500511;

    #[Attr(httpStatus: 500)]
    case RUNTIME_EXCEPTION_ILLEGAL_GOOGLE_AUTH_EMAIL_VERIFIED_FLAG = 500512;

    #[Attr(httpStatus: 500)]
    case RUNTIME_EXCEPTION_CANT_GENERATE_NEW_TOKEN = 500521;

    /*
    |--------------------------------------------------------------------------
    | メソッド
    |--------------------------------------------------------------------------
    |
    |
    */

    public function getStatusCodeInt(): int
    {
        $reflection = new ReflectionEnumBackedCase($this::class, $this->name);
        foreach ($reflection->getAttributes(Attr::class) as $a) {
            $instance = $a->newInstance();
            if ($instance instanceof Attr) {
                return $instance->httpStatus;
            }
        }
        // PHPのLogicException
        throw new LogicException('No Definition Status');
    }

    public function getResourceCodeInt(): ?int
    {
        $reflection = new ReflectionEnumBackedCase($this::class, $this->name);
        foreach ($reflection->getAttributes(Attr::class) as $a) {
            $instance = $a->newInstance();
            if ($instance instanceof Attr) {
                return $instance->resStatus;
            }
        }
        // PHPのLogicException
        throw new LogicException('No Definition Status');
    }
}
