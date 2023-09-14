<?php

namespace App\Services\Food;

use App\Http\Resources\FoodResource;
use App\Models\Food\Food;
use App\Traits\HasResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodService
{
    use HasResponse;

    public function index($withPagination)
    {
        $food = Food::foodFilters() # Filtrado por el modelo
            ->orderBy('id', 'asc');

        $food = !empty($withPagination)
            ? $food->paginate($withPagination['perPage'], page: $withPagination['page'])
            : $food->get();

        $foodResource = FoodResource::collection($food->load('userAdded', 'userAccepts'));

        # En caso de usar paginación
        if (!empty($withPagination)) {
            $paginationData = [
                'current_page' => $food->currentPage(),
                'data' => $foodResource,
                'first_page_url' => $food->url(1),
                'from' => $food->firstItem(),
                'last_page' => $food->lastPage(),
                'last_page_url' => $food->url($food->lastPage()),
                'links' => $food->links(),
                'next_page_url' => $food->nextPageUrl(),
                'path' => $food->url($food->currentPage()),
                'per_page' => $food->perPage(),
                'prev_page_url' => $food->previousPageUrl(),
                'to' => $food->lastItem(),
                'total' => $food->total(),
            ];
        }

        return $this->successResponse('Lectura exitosa.', $paginationData ?? $foodResource);
    }

    public function store($params)
    {
        DB::beginTransaction();
        try {
            # Verificar duplicidad de la comida
            $validate = $this->checkNameDuplication($params['name']);
            if (!$validate->original['status']) return $validate;

            # Verificar los cálculos de los hidratos
            $hydrates = $this->calculateHydrates($params['kcal'], $params['protein'], $params['fat']);
            if (!$hydrates->original['status']) return $hydrates;

            $food = Food::create([
                'name'          => $params['name'],
                'amount'        => $params['amount'],
                'kcal'          => $params['kcal'],
                'protein'       => $params['protein'],
                'fat'           => $params['fat'],
                'hydrates'      => $hydrates->original['data']->detail,
                'iduser_added'  => Auth::user()->id
            ]);
            $food->fresh();

            DB::commit();
            return $this->successResponse('Registro de alimento creado satisfactoriamente.', $food);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la creación de un registro de alimento.', $th->getMessage());
        }
    }

    public function update($id, $params)
    {
        DB::beginTransaction();
        try {
            # Verificar validez del registro
            $validate = $this->verifyfood($id);
            if (!$validate->original['status']) return $validate;

            # Verificar duplicidad de la comida
            if (isset($params['name'])) {
                $validate = $this->checkNameDuplication($params['name'], $id);
                if (!$validate->original['status']) return $validate;
            }

            $food = Food::find($id);
            $kcal = $params['kcal'] ?? $food->kcal;
            $protein = $params['protein'] ?? $food->protein;
            $fat = $params['fat'] ?? $food->fat;

            # Verificar los cálculos de los hidratos
            $hydrates = $this->calculateHydrates($kcal, $protein, $fat);
            if (!$hydrates->original['status']) return $hydrates;

            $food->update([
                'name'      => $params['name'] ?? $food->name,
                'amount'    => $params['amount'] ?? $food->amount,
                'kcal'      => $kcal,
                'protein'   => $protein,
                'fat'       => $fat,
                'hydrates'  => $hydrates->original['data']->detail
            ]);

            DB::commit();
            return $this->successResponse('Registro de alimento actualizado satisfactoriamente.', $food);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la actualización de un registro de alimento.', $th->getMessage());
        }
    }

    public function deleteLogical($id)
    {
        DB::beginTransaction();
        try {
            # Verificar validez del registro
            $validate = $this->verifyfood($id);
            if (!$validate->original['status']) return $validate;

            $food = Food::find($id);
            $food->update(['status' => 2]);

            DB::commit();
            return $this->successResponse('Registro de alimento eliminado satisfactoriamente.', $food);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la eliminación de un registro de alimento.', $th->getMessage());
        }
    }

    public function deletePhysical($id)
    {
        DB::beginTransaction();
        try {
            # Verificar validez del registro
            $validate = $this->verifyfood($id);
            if (!$validate->original['status']) return $validate;

            $food = Food::find($id);
            $food->delete();

            DB::commit();
            return $this->successResponse('Registro de alimento eliminado permanentemente.', $food);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->externalError('durante la eliminación de un registro de alimento.', $th->getMessage());
        }
    }

    private function calculateHydrates($kcal, $protein, $fat)
    {
        $hydrates = round($kcal - (($protein * 4 + $fat * 9) / 4), 2);
        if ($hydrates < 0) {
            return $this->errorResponse('Verifique sus datos ingresados.', 400);
        }
        return $this->successResponse('OK', $hydrates);
    }

    private function checkNameDuplication($name, $id = false)
    {
        $name = Food::where('name', $name)->active();
        if ($id)  $name->whereNot('id', $id);
        $name = $name->first();

        if ($name) return $this->errorResponse('El nombre ya se encuentra registrado.', 400);

        return $this->successResponse('OK');
    }

    private function verifyfood($id)
    {
        $food = Food::activeForID($id)->first();
        if (!$food) return $this->errorResponse('El registro de alimento seleccionado no esta disponible', 400);

        return $this->successResponse('OK');
    }
}
