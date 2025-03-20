<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\AuthRequest;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(AuthRequest $request)
    {
        $response = $this->authService->login($request);

        return response($response, Response::HTTP_OK);
    }

    public function refresh(Request $request)
    {
        $response = $this->authService->refresh($request);

        return response($response, Response::HTTP_OK);
    }


    public function logout(){

        $response = $this->authService->logout();

        return response($response, Response::HTTP_OK);
    }

    public function verifyUser()
    {
        $response = $this->authService->verifyUser();

        return response($response,200);
    }
    
    public function getRutas(){
        $response = $this->authService->getRutas();

        return response ($response);
    }

    public function changePassword(Request $request){
        $response = $this->authService->changePassword($request);

        return response($response, Response::HTTP_OK);
    }
}
