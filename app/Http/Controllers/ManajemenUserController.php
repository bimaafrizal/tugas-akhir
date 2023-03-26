<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManajemenUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\ManajemenUser\ManajemenUserService;
use Illuminate\Http\Request;

class ManajemenUserController extends Controller
{
    public $service;
    public function __construct(ManajemenUserService $manajemenService)
    {
        $this->service = $manajemenService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id', 1)->get();
        $admins = User::where('role_id', 2)->orwhere('role_id', 3)->get();
        return view('pages.dashboard2.manajemen-user.index', compact('users', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('pages.dashboard2.manajemen-user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManajemenUserRequest $request)
    {
        $this->service->create($request->all());
        return redirect(route('manajemen-user.index'))->with('success', 'berhasil menambahkan admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decryptId = decrypt($id);
        $data = User::where('id', $decryptId)->first();
        $roles = Role::where('id', '!=', 1)->get();
        return view('pages.dashboard2.manajemen-user.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $decryptId = decrypt($id);
        $validateData = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'email:dns', 'unique:users,email,' . $decryptId],
            'phone_num' => ['required', 'min:9', 'max:13', 'unique:users,phone_num,' . $decryptId],
            'password' => ['nullable', 'confirmed', 'min:5', 'max:255'],
            'role_id' => ['required']
        ]);
        if ($request->password == null) {
            $validateData['password'] = $request->user()->password;
        }
        $this->service->update($decryptId, $validateData);
        return redirect(route('manajemen-user.index'))->with('success', 'User berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function editStatus(Request $request, $id)
    {
        $decryptId = decrypt($id);

        $this->service->updateStatus($decryptId, $request->is_active);
        return redirect(route('manajemen-user.index'))->with('success', 'Status Admin berhasil dirubah');
    }
}
