<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SelectCertificateStatus extends Component
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
        $statuses = [
            [
                'id' => 'ditandatangani',
                'name' => 'Ditandatangani'
            ],
            [
                'id' => 'dikirim',
                'name' => 'Dikirim'
            ],
            [
                'id' => 'cetak_sertifikat',
                'name' => 'Cetak Sertifikat'
            ],
        ];

        return view('components.forms.select-certificate-status', compact('statuses'));
    }
}
