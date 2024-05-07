<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SelectCategoryInstrument extends Component
{
    public $fill;
    public $placeholder;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($placeholder, $fill)
    {
        $this->fill = $fill;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $categories = [
            [
                'id' => 'Perpustakaan Desa',
                'name' => 'Perpustakaan Desa'
            ],
            [
                'id' => 'Kecamatan',
                'name' => 'Kecamatan'
            ],
            [
                'id' => 'Kabupaten Kota',
                'name' => 'Kabupaten Kota'
            ],
            [
                'id' => 'Provinsi',
                'name' => 'Provinsi'
            ],
            [
                'id' => 'SD MI',
                'name' => 'SD MI'
            ],
            [
                'id' => 'SMP MTs',
                'name' => 'SMP MTs'
            ],
            [
                'id' => 'SMA SMK MA',
                'name' => 'SMA SMK MA'
            ],
            [
                'id' => 'Perguruan Tinggi',
                'name' => 'Perguruan Tinggi'
            ],
            [
                'id' => 'Khusus',
                'name' => 'Khusus'
            ],
        ];

        return view('components.forms.select-category-instrument', compact('categories'));
    }
}
