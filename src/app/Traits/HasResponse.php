<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

trait HasResponse
{
    /**
     * Default structure to prepare any json response
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    #Estructura principal para las respuestas, se añadió un detail2 a si se quiere mandar un detalle aparte del principal, solo se usa en casos puntuales
    public function defaultStructure($code = JsonResponse::HTTP_OK, $message = 'OK', $data = null, $bool, $detail2 = null)
    {
        return [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'code' => $code,
            'status' => $bool,
            'data'  => $this->returnMessage($message, $data, $detail2)
        ];
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function defaultResponse($message = 'OK', $code = JsonResponse::HTTP_NO_CONTENT)
    {
        $structure = $this->defaultStructure($code, $message, null, null);

        return response()->json($structure, $code);
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    #Uso para respuestas exitosas
    public function successResponse($message = 'OK', $data = null)
    {
        $code = JsonResponse::HTTP_OK;
        $structure = $this->defaultStructure($code, $message, $data, true);
        // $structure['data'] = $data;

        return response()->json($structure, $code);
    }

    /**
     * @param $errors
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    #Uso para respuestas erroneas controladas, se puede manndar un array en errors, caso contrario se manda nulo
    public function errorResponse($message, $code, $errors = null, $detail2 = null)
    {
        $errorsIsArray = is_array($errors);
        $errors = !$errorsIsArray || ($errorsIsArray && count($errors) > 0) ? $errors : null;
        $structure = $this->defaultStructure($code, $message, $errors, false, $detail2);

        return response()->json($structure, $code);
    }

    /**
     * @param bool $bool
     * @param string $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    #Estructura del mensaje final
    public function returnMessage($message, $data = null, $detail2 = null)
    {
        if (is_null($data)) {
            return [
                'message' => $message,
            ];
        }
        if(!is_null($detail2)){
            return  [
                'message' => $message,
                $detail2 => $data
            ];
        }
        return  [
            'message' => $message,
            'detail' => $data
        ];
    }

    /**
     * @param $paginate
     * @return \Illuminate\Http\JsonResponse
     */
    #Validacion de paginacion
    public function validatePagination($paginate)
    {
        if(empty($paginate)){
            return [];
        }
        if(!isset($paginate['perPage']) || !isset($paginate['page'])){
            return [];
        }
        return $paginate;
    }
}
