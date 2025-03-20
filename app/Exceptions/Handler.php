<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    private $exceptions = [
        BadRequestException::class => Response::HTTP_BAD_REQUEST,
        AccessDeniedHttpException::class => Response::HTTP_FORBIDDEN,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
        UnprocessableEntityHttpException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        MethodNotAllowedHttpException::class => Response::HTTP_METHOD_NOT_ALLOWED,
        JWTException::class => Response::HTTP_UNAUTHORIZED,
        UnauthorizedException::class => Response::HTTP_UNAUTHORIZED,
        TokenExpiredException::class => Response::HTTP_UNAUTHORIZED,
        JWTException::class => Response::HTTP_FORBIDDEN,
        AuthenticationException::class => Response::HTTP_FORBIDDEN,

    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        $this->renderable(function (Throwable $e) {

            if (array_key_exists(get_class($e), $this->exceptions)) {
                return response()->json(['message' => $e->getMessage()], $this->exceptions[get_class($e)]);
            }

            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
