<?php

namespace App\Http\Controllers;

use App\Models\DetailServiceInformation;
use App\Models\ServiceInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DetailServiceInformationController extends Controller
{
    
    public function listDetailView($id_service_information){

        $detalles = DetailServiceInformation::where('workshop_course', '=', $id_service_information)->paginate(4);

        $cantidad = count($detalles);

        $informacionPrincipal = ServiceInformation::find($id_service_information);

        if(!is_null($informacionPrincipal)){

            return view('detailService.list', [
                'principal' => $informacionPrincipal,
                'detalles' => $detalles,
                'cantidad' => $cantidad,
            ]);

        }else{

            return redirect()->route('dashboard')
                    ->with(['message' => 'Elemento no encontrado :(', 'tittle' => 'Advertencia', 'icon' => 'warning']);

        }
    }

    public function addDetailView($id_service_information){

        $informacionPrincipal = ServiceInformation::find($id_service_information);

        if(!is_null($informacionPrincipal)){

            return view('detailService.add', [
                'principal' => $informacionPrincipal,
            ]);

        }else{

            return redirect()->route('dashboard')
                    ->with(['message' => 'Elemento no encontrado :(', 'tittle' => 'Advertencia', 'icon' => 'warning']);

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

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!]{3,}$/", $title)){
                $errores[$contador] = 'Error con el Título, procura ingresar solo letras, números y caracteres especiales como (. _ - / : !) y que supere los 3 caracteres';
                $contador++;
            }

            if(!preg_match("/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ\s\.\_\-\/\:\!\@\(\)\?\=]{10,}$/", $description)){
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

                $lastId = $consulta->id;

                $id_service_information = $request->input('service_information_id');

                $agregarRelacion = DetailServiceInformation::create([
                    'workshop_course' =>  $id_service_information,
                    'detail' => $lastId
                ]);

                if($agregarRelacion){
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
}
