<?php

namespace App\Http\Controllers;

use App\Http\Requests\homeStoreRequest;
use App\Http\Requests\homeUpdateRequest;
use App\Models\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $homes = home::all();
        return view('home', compact('homes'));
    }

    public function store(homeStoreRequest $request)
    {
        $input = $request->validated();

        home::create([

            'name' => $input['name'],
            'email' => $input['email'],
            'address' => $input['address'],
            'phone' => $input['phone'],

        ]);

        return redirect()->route('home')->with([
            'success' => 'Customer Added'
        ]);
    }

    public function destroy($id)
    {
        home::find($id)->delete($id);
        return redirect()->back();
    }


    public function edit($id)
    {
        $Edit = home::find($id);
        if ($Edit) {
            return response()->json([
                'status' => 200,
                'cutomer' => $Edit,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'not found',
            ]);
        }
    }

    public function update(homeUpdateRequest $request, $id)
    {
        $input = $request->validated();

   
        home::where([
            'id' =>$id,
        ])->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'address' => $input['address'],
            'phone' => $input['phone'],
        ]);

        return redirect()->back()->with([
            'success' => 'Customer updated'
        ]);

    }
}

/* $validator = Validator::make($request->all(),[
    'name'=>'required',
    'email'=>'required',
    'address'=>'required',
    'phone'=>'required',

]);

$customers = new home;
$customers->name = $request->input('name');
$customers->email = $request->input('email');;
$customers->address = $request->input('address');;
$customers->phone = $request->input('phone');;
$customers->save(); --}}


  public function editStudent(Request $request)
    {
        $studentId = $request->studentId;

        Student::where([
            'studentId' => $studentId,
        ])->update([
            'studentName' => $request->studentName,
            'dob' => $request->dob,
            'address' => $request->address,

        ]);
        return redirect()
            ->back()
            ->with('message', 'Student Edited');
    }




*/