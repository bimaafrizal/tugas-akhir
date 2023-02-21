<?php

namespace App\Http\Livewire;

use App\Http\Requests\StoreKategoryArticleRequest;
use App\Service\KategoryArticle\KategoryArticleService;
use Livewire\Component;

class CreateKategoryArticle extends Component
{
    public $name;
    protected $service;

    public function __construct()
    {
        $this->service = new KategoryArticleService;
    }

    public function render()
    {
        return view('livewire.create-kategory-article');
    }

    public function store()
    {
        $data = $this->validate((new StoreKategoryArticleRequest())->rules());
        $this->service->insert($data);

        $this->makeNull();

        session()->flash('success', 'Kategory Article Berhasil Dibuat');
        $this->emit('categoryStore');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function makeNull()
    {
        $this->name = null;
    }
}