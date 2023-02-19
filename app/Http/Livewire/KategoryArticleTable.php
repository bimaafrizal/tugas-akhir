<?php

namespace App\Http\Livewire;

use App\Models\KategoryArticle;
use App\Repositories\KategoryArticle\KategoryArticleRepository;
use App\Service\KategoryArticle\KategoryArticleService;
use Livewire\Component;

class KategoryArticleTable extends Component
{
    protected $kategoryService;
    protected $listeners = ['categoryStore' => 'render'];

    public function __construct()
    {
        $this->kategoryService = new KategoryArticleService;
    }

    public function render()
    {
        return view('livewire.kategory-article-table', [
            'kategories' => $this->kategoryService->all()
        ]);
    }
}
