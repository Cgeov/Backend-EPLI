<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\ImageType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class ImageTypeController extends Controller
{

    public function index($image_type_code){
        
        $images = ImageType::where('image_type_code', '=', $image_type_code)->first();

        if(is_null($images)){

            return redirect()->route('dashboard')
                    ->with(['message' => 'Categoría de  imagenes no encontrada', 'tittle' => 'Advertencia', 'icon' => 'warning']);

        }else{

            $gallery = Gallery::where('type_image', '=', $images->id)->orderBy('id', 'desc')->paginate(8);

            $cantidad = count($gallery);

            return view('gallery.list', [
                'titulo' => $images->image_type,
                'informacion' => $gallery,
                'principal' => $images,
                'cantidad' =>  $cantidad
            ]);

        }

    }

    public function getImage($filename){

        $file = Storage::disk('galeria')->get($filename);

        return new Response($file, 200);

    }

    public function addImageGallery(Request $request){

        $id_image_type = $request->input('id_image_type');

        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyz';

        $identificador = substr(str_shuffle($caracteres), 5, 5);

        if(preg_match("/^[0-9]{1,}$/", $id_image_type)){

            $image_name = $request->file('image_name');

            $image_path_name = null;

            $errores = [];

            $imagenes_aceptadas = ['jpg', 'png', 'jpeg'];


            $contador = 0;

            $verificador = false;

            if($image_name){

                $image_path_name = $image_name->getClientOriginalName();

                $extension = pathinfo($image_path_name, PATHINFO_EXTENSION);

                foreach($imagenes_aceptadas as $ext_img => $ext){
                    if($ext === $extension){
                        $verificador = true;
                        break;
                    }
                }

                if(!$verificador){
                    $errores[$contador] = 'Error con la imagen, procura que la imagen sea .jpg .png .jpeg';
                    $contador++;
                }else{

                    $image_path_name = $identificador . '_' . $image_path_name;

                    Storage::disk('galeria')->put($image_path_name, File::get($image_name));
                }

            }else{
                $errores[$contador] = 'Error con la Imagen, procura ingresar la imagen';
                $contador++;
            }

            if($contador != 0){

                return back()->with(['errores' => $errores]);
            
            }else{

                $consulta = Gallery::create([
                    'image_name' => $image_path_name,
                    'type_image' => $id_image_type,
                ]);

                if($consulta){

                    return back()->with(['message' => 'Se ha guardado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);
                    
                    /*
                    return redirect()->route('dashboard')
                    ->with(['message' => 'Se ha guardado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);
                    */
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

    public function deleteImageGallery(Request $request){

        $gallery_id = $request->input('gallery_id');

        $errores = [];

        $contador = 0;

        if(preg_match("/^[0-9]{1,}$/", $gallery_id)){

            $informacion = Gallery::find($gallery_id)->first();

            if(is_null($informacion)){

                $errores[$contador] = 'ERROR FATAL, Imagen no encontrada en la base de datos. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
                $contador++;

                return back()->with(['errores' => $errores]);

            }else{

                Storage::disk('galeria')->delete($informacion->image_name);

                $eliminar = Gallery::where('id' , '=' , $gallery_id)->delete();

                if ($eliminar) {

                    return back()->with(['message' => 'Se ha eliminado exitosamente ! :)', 'tittle' => 'Éxito !', 'icon' => 'success']);
                
                } else {

                    $errores[$contador] = 'ERROR FATAL, Error al elimnar la imagen. Vuelva a intentarlo más tarde, si el error persiste favor llamar al técnico a cargo';
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
