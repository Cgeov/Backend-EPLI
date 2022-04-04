<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceInformation;
use App\Models\ServiceOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{

    public function index($detailaction, $detailservice){
        

        $service_option = ServiceOption::where('service_option_code', '=', $detailservice)->first();

        if(!is_null($service_option)){
            
            $id = $service_option->service_id;

            if($detailaction == "list"){

                $service_information = ServiceInformation::where('service_id', '=', $id)->where('principal', '=', 1)->orderBy('id', 'desc')->paginate(4);

                if(count($service_information) > 0){

                    return view('action.list', [
                        'titulo' => $service_option->service_option_name,
                        'information' => $service_information
                    ]);

                }else{  

                    return redirect()->route('dashboard')
                    ->with(['message' => 'No hay '. $service_option->services->service_name .' ingresad@', 'tittle' => 'Advertencia', 'icon' => 'warning']);

                }

            }else if($detailaction == "add"){

                $services = Service::find($id);

                $service_id = $services->id;

                return view('action.add', [
                    'titulo' => $service_option->service_option_name,
                    'informacion' => $services,
                    'service_id' => $service_id
                ]);
    
            }

        }else{
            return view('dashboard');
        }
    }

    public function save(Request $request){

        $service_id = $request->input('service_id');

        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';

        $identificador = substr(str_shuffle($caracteres), 5, 5);

        if(preg_match("/^[0-9]{1,}$/", $service_id)){
            
            $title = $request->input('title');

            $description = $request->input('description');

            $main_picture = $request->file('main_picture');

            $principal = $request->input('principal');

            $image_path_name = null;

            $link = null;

            $document_name = null;

            $document_path_name = null;
            
            $errores = [];

            $imagenes_aceptadas = ['jpg', 'png', 'jpeg'];

            $documentos_aceptados = ['pdf', 'docs', 'xlsx'];

            $contador = 0;

            $verificador = false;

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\,\¿]{3,}$/", $title)){
                $errores[$contador] = 'Error con el Título, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
                $contador++;
            }

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\@\(\)\?\=\,\¿]{10,}$/", $description)){
                $errores[$contador] = 'Error con la Descripción, procura ingresar solo letras, números y caracteres especiales como (. _ - / : ! @) y que supere los 10 caracteres';
                $contador++;
            }

            if($main_picture){

                $image_path_name = $main_picture->getClientOriginalName();

                $extension = pathinfo($image_path_name, PATHINFO_EXTENSION);

                foreach($imagenes_aceptadas as $ext_img => $ext){
                    if($ext === $extension){
                        $verificador = true;
                        break;
                    }
                }

                if(!$verificador){
                    $errores[$contador] = 'Error con la portada, procura que la imagen sea .jpg .png .jpeg';
                    $contador++;
                }else{

                    $image_path_name = $identificador . '_' . $image_path_name;

                    Storage::disk('publicaciones')->put($image_path_name, File::get($main_picture));
                }

            }else{
                $errores[$contador] = 'Error con la portada, procura ingresar la portada';
                $contador++;
            }

            if($request->exists('link')){
                $link = $request->input('link');

                if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\@\?\=\#]{3,}$/", $link)){
                    $errores[$contador] = 'Error con el Link, favor revisar el link ingresado';
                    $contador++;
                }
            }

            if($request->exists('document_name')){
                $document_name = $request->file('document_name');

                if($document_name){

                    $document_path_name = $document_name->getClientOriginalName();
        
                    $extension = pathinfo($document_path_name, PATHINFO_EXTENSION);
        
                    foreach($documentos_aceptados as $ext_img => $ext){
                        if($ext === $extension){
                            $verificador = true;
                            break;
                        }
                    }
        
                    if(!$verificador){
                        $errores[$contador] = 'Error con el Documento, procura que el documento sea .pdf .docs .xlsx';
                        $contador++;
                    }else{
                        Storage::disk('documentos')->put($document_path_name, File::get($document_name));
                    }
        
                }else{
                    $errores[$contador] = 'Error con el Documento, procura ingresar el documento';
                    $contador++;
                }
            }

            if($contador != 0){

                return back()->with(['errores' => $errores]);
            
            }else{

                $consulta = ServiceInformation::create([
                    'title' => $title,
                    'description' => $description,
                    'main_picture' => $image_path_name,
                    'link' => $link,
                    'document_name' => $document_path_name,
                    'service_id' => $service_id,
                    'principal' => $principal,
                ]);

                if($consulta){
                    return redirect()->route('dashboard')
                    ->with(['message' => 'Se ha guardado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);
                }else{
                    
                    $errores[$contador] = 'ERROR FATAL, Ha ocurrido un error y no se ha podido realizar la acción. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
                    $contador++;

                    return back()->with(['errores' => $errores]);

                }

            }

        }else{

            return redirect()->route('dashboard')
                    ->with(['message' => 'Servicio no encontrado :( \nSi el error persiste comunicarse con el programador', 'tittle' => 'Error :/', 'icon' => 'error']);

        }        

    }

    public function getImage($filename){

        $file = Storage::disk('publicaciones')->get($filename);

        return new Response($file, 200);

    }

    public function update($id){

        $informacion = ServiceInformation::find($id);

        if (!is_null($informacion)) {

            $services = service::where('id', '=', $informacion->service_id)->first();

            return view('action.edit', [
                'titulo' => $services->service_name,
                'service_information_id' => $informacion->id,
                'information' => $informacion,
                'informacion' => $services
            ]);

        } else {
            return redirect()->route('dashboard')
                ->with(['message' => 'Error al encontrar el dato a modificar', 'tittle' => 'Advertencia', 'icon' => 'warning']);
        }
        
    }

    public function confirm_update(Request $request){

        $service_information_id = $request->input('service_information_id');

        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';

        $identificador = substr(str_shuffle($caracteres), 5, 5);

        if(preg_match("/^[0-9]{1,}$/", $service_information_id)){

            $informacion = ServiceInformation::find($service_information_id);
            
            $title = $request->input('title');

            $description = $request->input('description');

            $service_id = $informacion->service_id;

            $main_picture = $request->file('main_picture');

            $image_path_name = null;

            $link = null;

            $document_name = null;

            $document_path_name = null;
            
            $errores = [];

            $imagenes_aceptadas = ['jpg', 'png', 'jpeg'];

            $documentos_aceptados = ['pdf', 'docs', 'xlsx'];

            $contador = 0;

            $verificador = false;

            $verificadorImagen = false;

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\,\¿\?]{3,}$/", $title)){
                $errores[$contador] = 'Error con el Título, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
                $contador++;
            }

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\@\(\)\?\=\,\¿]{10,}$/", $description)){
                $errores[$contador] = 'Error con la Descripción, procura ingresar solo letras, números y caracteres especiales como (. _ - / : ! @) y que supere los 10 caracteres';
                $contador++;
            }

            if($main_picture){

                Storage::disk('publicaciones')->delete($informacion->main_picture);

                $image_path_name = $main_picture->getClientOriginalName();

                $extension = pathinfo($image_path_name, PATHINFO_EXTENSION);

                foreach($imagenes_aceptadas as $ext_img => $ext){
                    if($ext === $extension){
                        $verificador = true;
                        break;
                    }
                }

                if(!$verificador){
                    $errores[$contador] = 'Error con la portada, procura que la imagen sea .jpg .png .jpeg';
                    $contador++;
                }else{

                    $verificadorImagen = true;

                    $image_path_name = $identificador . '_' . $image_path_name;

                    Storage::disk('publicaciones')->put($image_path_name, File::get($main_picture));
                }

            }

            if($request->exists('link')){
                $link = $request->input('link');

                if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\@\?\=\#]{3,}$/", $link)){
                    $errores[$contador] = 'Error con el Link, favor revisar el link ingresado';
                    $contador++;
                }
            }

            if($request->exists('document_name')){
                $document_name = $request->file('document_name');

                if($document_name){

                    $document_path_name = $document_name->getClientOriginalName();
        
                    $extension = pathinfo($document_path_name, PATHINFO_EXTENSION);
        
                    foreach($documentos_aceptados as $ext_img => $ext){
                        if($ext === $extension){
                            $verificador = true;
                            break;
                        }
                    }
        
                    if(!$verificador){
                        $errores[$contador] = 'Error con el Documento, procura que el documento sea .pdf .docs .xlsx';
                        $contador++;
                    }else{
                        Storage::disk('documentos')->put($document_path_name, File::get($document_name));
                    }
        
                }else{
                    $errores[$contador] = 'Error con el Documento, procura ingresar el documento';
                    $contador++;
                }
            }

            if($contador != 0){

                return back()->with(['errores' => $errores]);
            
            }else{

                if($verificadorImagen){
                    //HA SUBIDO UNA NUEVA IMAGEN, POR LO CUAL SÍ SE MODIFICA
                    $consulta = DB::table('service_informations')
                                    ->where('id', $service_information_id)
                                    ->update(array(
                                        'title' => $title,
                                        'description' => $description,
                                        'main_picture' => $image_path_name,
                                        'link' => $link,
                                        'document_name' => $document_path_name,
                                        'service_id' => $service_id,
                                    ));
                }else{
                    //LA IMAGEN DE LA PORTADA SIGUE SIENDO LA MISMA, POR LO CUAL, NO SE MODIFICA
                    $consulta = DB::table('service_informations')
                                    ->where('id', $service_information_id)
                                    ->update(array(
                                        'title' => $title,
                                        'description' => $description,
                                        'link' => $link,
                                        'document_name' => $document_path_name,
                                        'service_id' => $service_id,
                                    ));
                }

                if($consulta){
                    return redirect()->route('dashboard')
                    ->with(['message' => 'Se ha actualizado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);
                }else{
                    
                    $errores[$contador] = 'ERROR FATAL, Ha ocurrido un error y no se ha podido realizar la acción. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
                    $contador++;

                    return back()->with(['errores' => $errores]);

                }

            }

        }else{

            return redirect()->route('dashboard')
                    ->with(['message' => 'Servicio no encontrado :( \nSi el error persiste comunicarse con el programador', 'tittle' => 'Error :/', 'icon' => 'error']);

        } 
    }

    public function delete($service_information){

        return back()->with(['eliminar' => $service_information]);

    }

    public function confirm_delete($id){

        $info = ServiceInformation::find($id);

        Storage::disk('publicaciones')->delete($info->main_picture);

        ServiceInformation::where('id' , '=' , $id)->delete();

        return back()->with(['success' => 'Éxito']);

    }
}
