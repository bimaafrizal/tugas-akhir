<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManajemenUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\ManajemenUser\ManajemenUserService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $user = User::where('id', $decryptId)->first();

        if ($request->password == null) {
            $validateData['password'] = $user->password;
        } else {
            $validateData['password'] = Hash::make($validateData['password']);
        }

        $this->service->update($decryptId, $validateData);

        if ($user->role_id == 1) {
            return redirect(route('manajemen-user.index'))->with('success', 'User berhasil diedit');
        }
        return redirect(route('manajemen-user.index'))->with('success', 'Admin/Super Admin berhasil diedit');
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

    public function downloadData($id)
    {
        try {
            $decrypted = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            echo $e;
        }
        $data = User::with('role')->where('role_id', $decrypted)->get();
        if ($decrypted == 2 || $decrypted == 3) {
            $data = User::with('role')->where('role_id', 2)->orWhere('role_id', 3)->get();
        }

        if ($decrypted)
            $namaFile = 'Admin';
        if ($decrypted == 1) {
            $namaFile = 'User';
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        if ($decrypted == 1) {
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Nama');
            $sheet->setCellValue('C1', 'Email');
            $sheet->setCellValue('D1', 'Nomor HP');


            $row = 2;
            $number = 1;

            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, $number);
                $sheet->setCellValue('B' . $row, $item->name);
                $sheet->setCellValue('C' . $row, $item->email);
                $sheet->setCellValue('D' . $row, $item->phone_num);
                $row++;
                $number++;
            }

            $writer = new Xlsx($spreadsheet);
        } else {
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'Nama');
            $sheet->setCellValue('C1', 'Email');
            $sheet->setCellValue('D1', 'Nomor HP');
            $sheet->setCellValue('E1', 'Role');
            $sheet->setCellValue('F1', 'Status');


            $row = 2;
            $number = 1;

            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, $number);
                $sheet->setCellValue('B' . $row, $item->name);
                $sheet->setCellValue('C' . $row, $item->email);
                $sheet->setCellValue('D' . $row, $item->phone_num);
                $sheet->setCellValue('E' . $row, $item->role->name);
                $sheet->setCellValue('F' . $row, $item->status);
                $row++;
                $number++;
            }

            $writer = new Xlsx($spreadsheet);
        }


        $fileName = $namaFile . ' ' . Carbon::now() . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
