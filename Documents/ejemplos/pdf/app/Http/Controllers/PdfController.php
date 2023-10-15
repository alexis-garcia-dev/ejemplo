<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
//use validator;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class PdfController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => $validate->errors()
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Successfully created user!',
            'user' => $user
        ], 201);
    }


    public function excel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function pdf()
    {

        $users = User::all();
        $total = User::count();
        $pdf = \PDF::loadView('pdf', compact('users', 'total'));
        return $pdf->download('ejemplo.pdf');
    }


    public function excel2()
    {
        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Aquí va el creador, como cadena")
            ->setLastModifiedBy('Parzibyte') // última vez modificado por
            ->setTitle('Mi primer documento creado con PhpSpreadSheet')
            ->setSubject('El asunto')
            ->setDescription('Este documento fue generado para parzibyte.me')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('La categoría');
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Productos");
        $encabezado = ["id", "Nombre", "Email"];

        $hoja->fromArray($encabezado, null, 'A1');
        $fila = 2;
        $user = User::all();
        foreach ($user as $user) {
            $hoja->setCellValueByColumnAndRow(1, $fila, $user->id);
            $hoja->setCellValueByColumnAndRow(2, $fila, $user->name);
            $hoja->setCellValueByColumnAndRow(3, $fila, $user->email);
            $fila++;
        }

        $nombreDelDocumento = "usuarios.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
    }
}
