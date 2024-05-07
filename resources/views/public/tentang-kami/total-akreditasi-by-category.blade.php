@extends('layouts.public')

@section('content')
<section class="text-gray-600 body-font py-10 container mx-auto">
    <div class="max-w-md mx-auto xl:max-w-5xl lg:max-w-5xl md:max-w-2xl bg-white flex-row relative">
        <div class="m-6 md:mx-0 bg-white text-blue-900 rounded-t">
            <h5 class="text-gray-700 text-2xl capitalize">Jumlah Perpustakaan Terakreditasi</h5>
        </div>

        <table class="pb-16 border-collapse border border-gray w-full text-left">
            <thead>
                <th class="border border-green bg-green-500 text-white py-2 px-6">No.</th>
                <th class="border border-green bg-green-500 text-white py-2 px-6">Jenis Perpustakaan</th>
                <th class="border border-green bg-green-500 text-white py-2 px-6">Jumlah</th>
            </thead>
            <tbody>
                @foreach ($totals['data']['per_category'] ?? [] as $total)
                    <tr>
                        <td class="border border-gray py-2 px-6">{{ $loop->iteration }}</td>
                        <td class="border border-gray py-2 px-6">{{ $total['category'] }}</td>
                        <td class="border border-gray py-2 px-6">{{ $total['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td class="border border-gray py-2 px-6">Total</td>
                    <td class="border border-gray py-2 px-6">{{ $totals['data']['per_category_total'][0]['total'] ?? 0 }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>
@endsection
