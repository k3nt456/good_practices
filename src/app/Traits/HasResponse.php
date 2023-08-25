<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

trait HasResponse
{
    # Estructura por defecto para los mensajes
    public function defaultStructure($code = JsonResponse::HTTP_OK, $message = 'OK', $data = null, $bool)
    {
        return [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'code' => $code,
            'status' => $bool,
            'data'  => $this->returnMessage($message, $data)
        ];
    }

    # Estructura para paginación
    private function paginationStructure($code, $message, $total, $data)
    {
        return [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'code' => $code,
            'status' => true,
            'data'  => $this->returnMessage($message, $data, $total)
        ];
    }

    # Estructura par mensaje exitoso
    public function successResponse($message = 'OK', $data = null)
    {
        $code = JsonResponse::HTTP_OK;
        $structure = $this->defaultStructure($code, $message, $data, true);

        return response()->json($structure, $code);
    }

    # Estructura para mensajes de error
    public function errorResponse($message, $code, $errors = null)
    {
        $errorsIsArray = is_array($errors);
        $errors = !$errorsIsArray || ($errorsIsArray && count($errors) > 0) ? $errors : null;
        $structure = $this->defaultStructure($code, $message, $errors, false);

        return response()->json($structure, $code);
    }

    # Estructura de paginación
    public function successPaginationResponse($message = 'OK', $total, $data)
    {
        $code = JsonResponse::HTTP_OK;
        $structure = $this->paginationStructure($code, $message, $total, $data);

        return response()->json($structure, $code);
    }

    # Detalle para paginación
    public function returnMessage($message, $data = null, $total = null)
    {
        if (is_null($data)) {
            return [
                'message' => $message,
            ];
        }

        if (!is_null($total)) {
            return [
                'message' => $message,
                'total' => $total,
                'detail' => $data
            ];
        }

        return [
            'message' => $message,
            'detail' => $data
        ];
    }

    # Verificación de paginación
    public function validatePagination($paginate)
    {
        if(empty($paginate)){
            return false;
        }

        if (!isset($paginate["perPage"]) || !isset($paginate["page"])){
            return false;
        }

        if($paginate['perPage'] == 0 || $paginate['page'] == 0){
            return false;
        }

        return $paginate;
    }

    # Estructura para mensaje de error en operaciones try - catch
    public function externalError($message, $errors = null)
    {
        $structure = $this->defaultStructure(500, 'Ocurrió un problema '.$message, $errors, false);

        return response()->json($structure, 500);
    }
}
