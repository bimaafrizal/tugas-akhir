<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use App\Models\Feature;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class SettingLandingPage extends Controller
{
    public function index()
    {
        $page = LandingPage::where('id', 1)->first();
        $fiturs = Feature::all();
        $collabs = Collaboration::all();
        return view('pages.dashboard2.setting-landing-page.index', compact('page', 'fiturs', 'collabs'));
    }

    public function homeEdit(Request $request)
    {
        $landingPage = LandingPage::where('id', 1)->first();
        $validateRequest = $request->validate([
            'title' => 'required|min:10|max:255',
            'subtitle' => 'required|min:10|max:255',
            'logo' => 'file|image|mimes:jpg,jpeg,png|max:50000',
            'image_title' => 'file|image|mimes:jpg,jpeg,png|max:50000',
            'image_title2' => 'file|image|mimes:jpg,jpeg,png|max:50000',
        ]);

        if ($request->logo != null) {
            $validateRequest['logo'] = $this->uploadImage($landingPage->logo, $request->logo);
        }
        if ($request->image_title != null) {
            $validateRequest['image_title'] = $this->uploadImage($landingPage->image_title, $request->image_title);
        }
        if ($request->image_title2 != null) {
            $validateRequest['image_title2'] = $this->uploadImage($landingPage->image_title2, $request->image_title2);
        }

        $landingPage->update($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil merubah landing page');
    }

    public function aboutEdit(Request $request)
    {
        $landingPage = LandingPage::where('id', 1)->first();
        $validateRequest = $request->validate([
            'title_about1' => 'required|min:10|max:255',
            'about1' => 'required|min:10|max:255',
            'image1' => 'file|image|mimes:jpg,jpeg,png|max:50000',
            'title_about2' => 'required|min:10|max:255',
            'about2' => 'required|min:10|max:255',
            'image2' => 'file|image|mimes:jpg,jpeg,png|max:50000',
        ]);

        if ($request->image1 != null) {
            $validateRequest['image1'] = $this->uploadImage($landingPage->image1, $request->image1);
        }
        if ($request->image2 != null) {
            $validateRequest['image2'] = $this->uploadImage($landingPage->image2, $request->image2);
        }

        $landingPage->update($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil merubah landing page');
    }

    public function footerEdit(Request $request)
    {
        $landingPage = LandingPage::where('id', 1)->first();
        $validateRequest = $request->validate([
            'footer' => 'required|min:10|max:255',
            'twitter' => 'nullable|min:3|max:255',
            'facebook' => 'nullable|min:3|max:255',
            'instagram' => 'nullable|min:3|max:255',
            'linkedin' => 'nullable|min:3|max:255',
        ]);

        $landingPage->update($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil merubah landing page');
    }

    public function uploadImage($oldFile, $newRequest)
    {
        if ($oldFile != null) {
            if (file_exists($oldFile)) {
                unlink(public_path($oldFile));
            }
        }
        $foto = $newRequest;
        $name = $foto->hashName();
        $foto->move(public_path('/landing-page/img/'), $name);
        return 'landing-page/img/' . $name;
    }

    public function createFitur()
    {
        return view('pages.dashboard2.setting-landing-page.create-fitur');
    }

    public function storeFitur(Request $request)
    {
        $validateRequest = $request->validate([
            'title' => 'required|min:10|max:150',
            'body' => 'required|min:10|max:250',
            'logo' => 'required',
        ]);
        $validateRequest['landing_page_id'] = 1;

        Feature::create($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil menambah data fitur');
    }

    public function editFitur($id)
    {
        $idDecrypt = decrypt($id);
        $data = Feature::where('id', $idDecrypt)->first();
        return view('pages.dashboard2.setting-landing-page.edit-fitur', compact('data'));
    }

    public function updateFitur(Request $request, $id)
    {
        $validateRequest = $request->validate([
            'title' => 'required|min:10|max:150',
            'body' => 'required|min:10|max:250',
            'logo' => 'required',
        ]);
        $validateRequest['landing_page_id'] = 1;

        $idDecrypt = decrypt($id);
        $data = Feature::where('id', $idDecrypt)->first();
        $data->update($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil merubah data fitur');
    }

    public function deleteFitur($id)
    {
        $idDecrypt = decrypt($id);
        Feature::where('id', $idDecrypt)->delete();
        return redirect(route('landing-page.index'))->with('success', 'Berhasil menghapus data fitur');
    }


    public function createInstansi()
    {
        return view('pages.dashboard2.setting-landing-page.create-instansi');
    }
    public function storeInstansi(Request $request)
    {
        $validateRequest = $request->validate([
            'title' => 'required|min:3|max:255',
            'logo' => 'required|file|image|mimes:jpg,jpeg,png|max:50000',
        ]);
        $validateRequest['landing_page_id'] = 1;

        $validateRequest['logo'] = $this->uploadImage(null, $request->file('logo'));
        Collaboration::create($validateRequest);

        return redirect(route('landing-page.index'))->with('success', 'Berhasil menambah data instansi');
    }
    public function editInstansi($id)
    {
        $idDecrypt = decrypt($id);
        $data = Collaboration::where('id', $idDecrypt)->first();
        return view('pages.dashboard2.setting-landing-page.edit-instansi', compact('data'));
    }
    public function updateInstansi($id, Request $request)
    {
        $validateRequest = $request->validate([
            'title' => 'required|min:3|max:255',
            'logo' => 'file|image|mimes:jpg,jpeg,png|max:50000',
        ]);
        $validateRequest['landing_page_id'] = 1;
        $idDecrypt = decrypt($id);
        $data = Collaboration::where('id', $idDecrypt)->first();

        $validateRequest['logo'] = $data->logo;
        if ($request->logo != null) {
            $validateRequest['logo'] = $this->uploadImage($data->logo, $request->file('logo'));
        }

        $data->update($validateRequest);
        return redirect(route('landing-page.index'))->with('success', 'Berhasil merubah data instansi');
    }

    public function deleteInstansi($id)
    {
        $idDecrypt = decrypt($id);
        $collab  = Collaboration::where('id', $idDecrypt)->first();

        if (file_exists($collab->logo)) {
            unlink(public_path($collab->logo));
        }
        $collab->delete();
        return redirect(route('landing-page.index'))->with('success', 'Berhasil menghapus data instansi');
    }
}
