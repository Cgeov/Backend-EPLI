<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOption;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function index(){

        $informacion = Service::orderBy('id', 'asc')->get();

        $cantidad = count($informacion);

        return view('service.list', [
            'cantidad' => $cantidad,
            'servicios' => $informacion
        ]);
    
    }

    public function addService(Request $request){

        $errores = [];

        $contador = 0;

        $slider = 0;

        $link = 0;

        $document = 0;

        $details = 0;

        $service_name = $request->input('service_name');

        $service_code = $request->input('service_name');

        $service_icon = $request->input('service_icon');

        $add = $request->input('add');

        $list = $request->input('list');

        if(!is_null($request->input('slider'))){
            $slider = 1;
        }

        if(!is_null($request->input('link'))){
            $link = 1;
        }

        if(!is_null($request->input('document'))){
            $document = 1;
        }

        if(!is_null($request->input('details'))){
            $details = 1;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_name)){
            $errores[$contador] = 'Error con el nombre del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_code)){
            $errores[$contador] = 'Error con el código del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_icon)){
            $errores[$contador] = 'Error con el icono del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $add)){
            $errores[$contador] = 'Error con la opción de agregar, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $list)){
            $errores[$contador] = 'Error con la opción de listar, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if($contador != 0){

            return back()->with(['errores' => $errores]);
        
        }else{

            $consulta = Service::create([
                'service_name' => $service_name,
                'service_code' => $service_code,
                'service_icon' => $service_icon,
                'slider' => $slider,
                'link' => $link,
                'document' => $document,
                'details' => $details,
            ]);

            $lastId = $consulta->id;

            $add_code = $request->input('add_code');

            ServiceOption::create([
                'service_option_name' => $add,
                'service_option_code' => $add_code,
                'service_id' => $lastId,
                'action' => 'add',
            ]);

            $list_code = $request->input('list_code');

            $ultimaConsulta = ServiceOption::create([
                'service_option_name' => $list,
                'service_option_code' => $list_code,
                'service_id' => $lastId,
                'action' => 'list',
            ]);

            if($ultimaConsulta){
                
                return back()->with(['message' => 'Se ha guardado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);

            }else{
                
                $errores[$contador] = 'ERROR FATAL, Ha ocurrido un error y no se ha podido realizar la acción. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
                $contador++;

                return back()->with(['errores' => $errores]);

            }

        }

    }

    public function editServiceView($id_service){

        
        $service = Service::find($id_service);

        $add = ServiceOption::where('service_id', '=', $service->id)->where('action', '=', 'add')->first();

        $list = ServiceOption::where('service_id', '=', $service->id)->where('action', '=', 'list')->first();

        return back()->with(['editar' => 'true', 'informacion' => $service, 'add' => $add, 'list' => $list]);

    }

    public function editService(Request $request){

        $errores = [];

        $contador = 0;

        $slider = 0;

        $link = 0;

        $document = 0;

        $details = 0;

        $service_name = $request->input('edit_service_name');

        $service_code = $request->input('edit_service_code');

        $service_icon = $request->input('edit_service_icon');

        $service_id = $request->input('service_id');

        $add = $request->input('edit_add');

        $list = $request->input('edit_list');

        if(!is_null($request->input('edit_slider'))){
            $slider = 1;
        }

        if(!is_null($request->input('edit_link'))){
            $link = 1;
        }

        if(!is_null($request->input('edit_document'))){
            $document = 1;
        }

        if(!is_null($request->input('edit_details'))){
            $details = 1;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_name)){
            $errores[$contador] = 'Error con el nombre del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_code)){
            $errores[$contador] = 'Error con el código del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $service_icon)){
            $errores[$contador] = 'Error con el icono del servicio, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $add)){
            $errores[$contador] = 'Error con la opción de agregar, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $list)){
            $errores[$contador] = 'Error con la opción de listar, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
            $contador++;
        }

        if($contador != 0){

            return back()->with(['errores' => $errores]);
        
        }else{

            Service::where('id', $service_id)->update([
                'service_name' => $service_name,
                'service_code' => $service_code,
                'service_icon' => $service_icon,
                'slider' => $slider,
                'link' => $link,
                'document' => $document,
                'details' => $details,
            ]);

            $id_add = $request->input('edit_id_add');

            $add_code = $request->input('edit_add_code');

            ServiceOption::where('id', $id_add)->update([
                'service_option_name' => $add,
                'service_option_code' => $add_code,
                'service_id' => $service_id,
                'action' => 'add',
            ]);

            $id_list = $request->input('edit_id_list');

            $list_code = $request->input('edit_list_code');

            $ultimaConsulta = ServiceOption::where('id', $id_list)->update([
                'service_option_name' => $list,
                'service_option_code' => $list_code,
                'service_id' => $service_id,
                'action' => 'list',
            ]);

            if($ultimaConsulta){
                
                return back()->with(['message' => 'Se ha actualizado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);

            }else{
                
                $errores[$contador] = 'ERROR FATAL, Ha ocurrido un error y no se ha podido realizar la acción. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
                $contador++;

                return back()->with(['errores' => $errores]);

            }

        }

    }

    public function deleteServiceView($service_id){

        return back()->with(['eliminar' => $service_id]);

    }

    public function confirm_delete($id){

        $errores = [];

        $contador = 0;

        $ultimaConsulta = Service::where('id' , '=' , $id)->delete();

        if($ultimaConsulta){
                
            return back()->with(['message' => 'Se ha eliminado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);

        }else{
            
            $errores[$contador] = 'ERROR FATAL, Ha ocurrido un error y no se ha podido realizar la acción. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
            $contador++;

            return back()->with(['errores' => $errores]);

        }

    }

}
