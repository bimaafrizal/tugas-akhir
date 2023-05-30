<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::all();
        return view('pages.dashboard2.template.index', compact('templates'));
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
     * @param  \App\Http\Requests\StoreTemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTemplateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decryptId = decrypt($id);
        $data = Template::find($decryptId);
        return view('pages.dashboard2.template.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTemplateRequest  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData =  $request->validate([
            'body' => 'required|min:10'
        ]);
        $decryptId = decrypt($id);
        $positions = [];
        $offset = 0;

        while (($pos = strpos($validateData['body'], '$', $offset))) {
            $positions[] = $pos;
            $offset = $pos + strlen('$');
        }

        $offset = 0;
        while (($pos = strpos($validateData['body'], ']', $offset))) {
            $positions[] = $pos;
            $offset = $pos + strlen(']');
        }

        $sortPosition = $this->bubble_sort($positions);

        $y = 1;
        for ($i = 0; $i < count($sortPosition); $i += 2) {
            if ($i == 0) {
                $replaceStr = substr($validateData['body'], $sortPosition[$i], $sortPosition[$i + 1] - $sortPosition[$i] + 1);
                $validateData['body'] = str_replace($replaceStr, '. ' . $replaceStr . '.', $validateData['body']);
            } else {
                $insertIndex = 3 * $y;

                $replaceStr = substr($validateData['body'], $sortPosition[$i] + $insertIndex, $sortPosition[$i + 1] - $sortPosition[$i] + 1);
                $validateData['body'] = str_replace($replaceStr, '. ' . $replaceStr . '.', $validateData['body']);

                $y += 1;
            }
        }
        // dd($validateData);

        $data = Template::find($decryptId);
        $data->update($validateData);

        return redirect(route('template.index'))->with('success', 'Berhasil merubah template notifikasi');
    }

    function bubble_sort($arr)
    {
        $size = count($arr) - 1;
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size - $i; $j++) {
                $k = $j + 1;
                if ($arr[$k] < $arr[$j]) {
                    // Swap elements at indices: $j, $k
                    list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
                }
            }
        }
        return $arr;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
}