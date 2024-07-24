<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Models\Nivel;
use Illuminate\Support\Facades\File;

class PreguntaController extends Controller
{
    public function getPreguntas(Request $request)
    {
        if (kvfj(Auth::user()->rol->permissions, 'get_preguntas')) {
            $preguntas = Pregunta::get();
            $nivels = Nivel::orderBy('name', 'asc')->get();
            return view('registrados.preguntas.index', compact('preguntas', 'nivels'));
        } else {
            return redirect()->route('home');
        }
    }

    public function postPregunta(Request $request)
    {

        $p = new Pregunta;
        $p->nivel_id = $request->input('nivel_id');
        $p->texto_pregunta = $request->input('texto_pregunta');
        $p->texto_respuesta = $request->input('texto_respuesta');

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('preguntas'), $imageName);
            $p->imagen = $imageName;
        }

        $p->save();

        return back()->with('message', 'Pregunta creada satisfactoriamente')->with('icon', 'success');
    }

    public function postEditPregunta(Request $request, $id)
    {
        $p = Pregunta::findOrFail($id);
        $p->nivel_id = $request->input('nivel_id');
        $p->texto_pregunta = $request->input('texto_pregunta');
        $p->texto_respuesta = $request->input('texto_respuesta');

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($p->imagen && File::exists(public_path('preguntas/' . $p->imagen))) {
                File::delete(public_path('preguntas/' . $p->imagen));
            }

            // Guardar la nueva imagen
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('preguntas'), $imageName);
            $p->imagen = $imageName;
        }

        $p->save();

        return back()->with('message', 'Pregunta actualizada satisfactoriamente')->with('icon', 'success');
    }

    public function deletePregunta($id)
    {
        $p = Pregunta::findOrFail($id);
        $p->status = ($p->status == 1) ? 0 : 1;
        $message = ($p->status == 1) ? 'Pregunta habilitada satisfactoriamente' : 'Pregunta habilitada satisfactoriamente';
        $p->save();
        return back()->with('message', $message)->with('icon', 'success');
    }
}