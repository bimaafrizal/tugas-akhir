<?php

namespace App\Http\Livewire;

use App\Models\KategoryArticle;
use App\Service\KategoryArticle\KategoryArticleService;
use Livewire\Component;

class KategoryArticleTable extends Component
{
    protected $kategoryService;
    protected $listeners = ['categoryStore' => 'handleStore'];

    public function __construct()
    {
        $this->kategoryService = new KategoryArticleService;
    }

    public function render()
    {
        return view('livewire.kategory-article-table', ['kategories' => $this->kategoryService->all()]);
    }

    public function editStatus($id, $status)
    {
        $this->kategoryService->updateStatus($id, $status);
        session()->flash('success', 'Berhasil Merubah Setatus Kategori');
    }

    public function handleStore()
    {
        $this->dispatchBrowserEvent('refresh-datatable');
        $this->render();
    }
}
