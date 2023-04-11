<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('dashboard.users.index');
    }
    // get users with yajrabox delete and edit

    public function getallusers()
    {
        if (auth()->user()->can('viewAny', $this->user)) {
            $data = User::select('*');
        } else {
            $data = User::where('id', auth()->user()->id);
        }
        return   Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if (auth()->user()->can('update', $row)) {
                    $btn .= '<a href="' . Route('dashboard.users.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete', $row)) {
                    $btn .= '

                            <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm"  data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            })
            ->addColumn('status', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.' . $row->status);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }
    // delete
    public function delete(request $request)
    {
        $this->authorize('update', $this->user);
        if (is_numeric($request->id)) {
            User::where('id', $request->id)->delete();
        }
        return redirect()->route('dashboard.users.index');
    }
    // page create
    public function create()
    {
        $this->authorize('update', $this->user);
        return view('dashboard.users.add');
    }
    //store add
    public function store(Request $request)
    {
        $this->authorize('update', $this->user);

        $data = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'status' => 'nullable|in:null,admin,writer',
            'profile' => 'nullable',
        ];
        $validatedData = $request->validate($data);

        $data = $request->except('profile', 'password');
        if ($request->hasFile('profile') && $request->file('profile')->isValid()) {
            $image = $request->file('profile')->getClientOriginalName();
            $pathprofile = $request->file('profile')->storeAs('profile', Str::uuid() . $image, 'setting');
            $data['profile'] = $pathprofile;
        }
        User::create($data + ['password' => bcrypt($request->password)]);
        return redirect()->route('dashboard.users.index');
    }



    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('dashboard.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {

        $this->authorize('update', $user);
        $user->update($request->except('profile', 'password'));

        if (($request->has('profile')) && !empty($request->newpassword)) {
            $image = $request->file('profile')->getClientOriginalName();
            $pathprofile = $request->file('profile')->storeAs('profile', Str::uuid() . $image, 'setting');
            $user->update([
                'profile' => $pathprofile,
                'password' => bcrypt($request->newpassword),
            ]);
        } elseif ($request->has('profile') && empty($request->newpassword)) {
            $image = $request->file('profile')->getClientOriginalName();
            $pathprofile = $request->file('profile')->storeAs('profile', Str::uuid() . $image, 'setting');
            $user->update([
                'profile' => $pathprofile,
            ]);
        } else {
            $user->update([
                'password' => bcrypt($request->newpassword),
            ]);
        }

        return redirect()->route('dashboard.users.index');
    }

    public function destroy($id)
    {
        return $id;
    }
}
