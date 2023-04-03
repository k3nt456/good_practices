<?php

namespace App\Http\Controllers\Users;

use App\Services\Users\UserClientService;
use Illuminate\Http\Request;

class UserClientController extends Controller
{
    /** @var UserClientService  */
    private $userClientService;

    public function __construct(UserClientService $userClientService)
    {
        $this->middleware('auth:api', ['except' => ['store']]);
        $this->userClientService = $userClientService;
    }

    public function indexAuth(Request $request)
    {
        return $this->userClientService->getInfoAuth($request->all());
    }

    #falta rquest
    public function store(Request $request)
    {
        return $this->userClientService->create($request->all());
    }
}
