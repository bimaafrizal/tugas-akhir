<?php

namespace App\Http\Livewire;

use App\Http\Requests\UpdateKategoryArticleRequest;
use App\Service\KategoryArticle\KategoryArticleService;
use Livewire\Component;

class EditKatagoryArticle extends Component
{
    public $name;
    public $id;
    protected $kategoryService;

    public function __construct()
    {
        $this->kategoryService = new KategoryArticleService;
    }

    public function mount($data)
    {
        $this->name = $data->name;
        $this->id = $data->id;
    }

    public function render()
    {
        return view('livewire.edit-katagory-article');
    }

    public function update()
    {
        $data = $this->validate((new UpdateKategoryArticleRequest())->rules());
        $this->kategoryService->update($this->id, $data);
        return redirect()->to(route('kategory-article'))->with('success', 'Kategori berhasil di edit');
    }
}