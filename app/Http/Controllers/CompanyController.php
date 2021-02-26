<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('admin')->paginate(5);
        return response()->json(['data'=>$companies, 'status'=>200]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['url', 'name']);

        $validate = $request->validate([
            'name' => 'required|unique:companies|max:255|string',
            'url' => 'required|url',

            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


        $company = Company::create($input);
            if($request->logo){
                $fileName = 'company-'.$company->id.'.png';
                $request->logo->move(public_path('companies/logo/'), $fileName);
                $data['logo'] = $fileName;
                Company::where(['id' => $company->id])->update($data);
            }

        $user = User::create([
            'company' => $company->id,
            'role' => 'company',
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json(201);
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company  $company)
    {
        $input = $request->only(['url', 'logo', 'name']);

        $selectedCompany = Company::where('id', $company->id)->with('admin')->first();  //To get company admin ID
        $validate = $request->validate([
            'name' => 'required|max:255|string|unique:companies,name,'.$company->id,
            'url' => 'required|url',

            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$selectedCompany->admin->id],
        ]);

        
        if( $selectedCompany){
            if($request->logo){
                $fileName = 'company-'.$company->id.'.png';
                $request->logo->move(public_path('companies/logo/'), $fileName);
                $input['logo'] = $fileName;
            }
            $selectedCompany->update($input);
        }

        $user = User::where('id', $selectedCompany->admin->id)->update([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
        ]);


        return response()->json(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(null, 204);
    }
}
