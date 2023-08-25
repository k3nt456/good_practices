<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCreateRequest;
use App\Http\Requests\FoodUpdateRequest;
use App\Services\Food\FoodService;
use App\Traits\HasResponse;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    use HasResponse;
    /** @var FoodService */
    private $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->middleware('auth:api');
        $this->foodService = $foodService;
    }

    public function index(Request $request)
    {
        $withPagination = $this->validatePagination($request->only('perPage', 'page'));
        return $this->foodService->index($withPagination);
    }

    public function store(FoodCreateRequest $request)
    {
        return $this->foodService->store($request->validated());
    }

    public function update($id, FoodUpdateRequest $request)
    {
        return $this->foodService->update($id, $request->validated());
    }

    public function deleteLogical($id)
    {
        return $this->foodService->deleteLogical($id);
    }

    public function deletePhysical($id)
    {
        return $this->foodService->deletePhysical($id);
    }
}
