<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $companies = Company::with(['tasks' => function ($query) {
                $query->select('id', 'name', 'description', 'is_completed', "start_at", "expired_at", 'company_id','user_id') 
            ->with(['user:id,name']);}])
            ->get();

            //Company::with(['tasks.user'])->get();

            return response()->json($companies,200);
        }catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al cargar las empresas.',
            'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
        'name' => ['required', 'string'],
        ]);

         try {

            $company = new Company();

            $company->name = $request->name;

            $company->save();

            return response()->json(['company' => $company], 201);

        }catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al guardar la empresa.',
            'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function update(Request $request, $id)
    {

        $request->validate([
        'name' => ['required', 'String'],
        ]);

        try {
            $company = Company::find($id);

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            $company->name = $request->name;

            $company->save();

            return response()->json(['company' => $company], 200);

        } catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al editar la empresa.',
            'message' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function delete($id)
    {
        try {
            $company = Company::findOrFail($id);

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            $company->delete();

            return response()->json(['Company deleted succesfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
            'error' => 'Error al eliminar la empresa.',
            'message' => $e->getMessage(),
            ], 500);
        }
    }
}
