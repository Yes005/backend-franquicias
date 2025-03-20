<?php

namespace App\Http\Controllers\Franquicias;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\v1\FranquiciaFileRequest;
use App\Http\Requests\v1\FranquiciaAnulacionRequest;
use App\Http\Requests\v1\FranquiciaObservacionRequest;
use App\Http\Requests\v1\FranquiciaRequest;
use App\Http\Requests\v1\FranquiciasActualizarFechasRequest;
use App\Models\Franquicia;
use App\Services\FranquiciaService;

class FranquiciaController extends Controller
{
    protected $FranquiciaService;

    public function __construct(FranquiciaService $FranquiciaService)
    {
        $this->FranquiciaService = $FranquiciaService;        
    }

    public function createBorrador(FranquiciaRequest $request){
        $crear = $this->FranquiciaService->createBorrador($request);

        return response($crear, 201);
    }

    public function editBorrador(FranquiciaRequest $request, $id){
        $editar = $this->FranquiciaService->editBorrador($request, $id);

        return response($editar);
    }

    public function getDetalleFranquicia($id){
        $detalle = $this->FranquiciaService->getDetalleFranquicia($id);

        return $detalle;
    }

    public function getFranquicias(Request $request){
        $franquicias = $this->FranquiciaService->getFranquicias($request);
        return response($franquicias['data'])->header('total_rows',$franquicias['total']);
    }

    public function createFranquicia(FranquiciaRequest $request, $id){
        $crear = $this->FranquiciaService->createFranquicia($request,$id);

        return response($crear);
    }

    public function sendFranquiciaObservacion(FranquiciaObservacionRequest $request, $id){
        $observar = $this->FranquiciaService->sendFranquiciaObservacion($request, $id);

        return response($observar);
    }

    public function createFranquiciaRevision(FranquiciaRequest $request){
        $crear_revision = $this->FranquiciaService->createFranquiciaRevision($request);

        return response($crear_revision, 201);
    }

    public function uploadFile(FranquiciaFileRequest $request)
    {
        $response = $this->FranquiciaService->uploadFile($request);
        return response()->json($response, 201);
    }

    public function getFiles($id)
    {
        $files = $this->FranquiciaService->getFiles($id);
        return $files;
    }

    public function previewFile($id)
    {
        $response = $this->FranquiciaService->previewFile($id);
        return $response;
    }

    public function deleteFile($id)
    {
        $response = $this->FranquiciaService->deleteFile($id);
        return $response;
    }
    
    public function resolveFranquicia(FranquiciaRequest $request){
        $solventar = $this->FranquiciaService->resolveFranquicia($request);

        return response($solventar);

    }

    public function compareFranquicia(Request $request){
        $comparar = $this->FranquiciaService->compareFranquicia($request);

        return response($comparar);
    }

    public function cancelFranquicia(FranquiciaAnulacionRequest $request){
        $anular = $this->FranquiciaService->cancelFranquicia($request);

        return response($anular);
    }

    public function approveFranquicia(Request $request){
        $aprobar = $this->FranquiciaService->approveFranquicia($request);

        return $aprobar;
    }

    public function editFechasFranquicias(FranquiciasActualizarFechasRequest $request){

        $actualizar =  $this->FranquiciaService->editFechasFranquicia($request);

        return $actualizar;
    }

    public function expiredInstitucion($id){
        $expired = $this->FranquiciaService->expiredInstitucion($id);

        return $expired;
    }

}
