<div class="col-md-12">
    <div class="btn-toolbar mb-2 mb-md-0">
        <x-buttons.create :href="route('admin.master_data.cities.create')" :title="__('Kota')" />
    </div>

    &nbsp;
    <table id="datatable-city" class="table table-centered table-nowrap mb-0 rounded" style="max-width: 100% !important">
        <thead class="thead-light">
            <th class="border-0 rounded-start">No</th>
            <th class="border-0">Provinsi</th>
            <th class="border-0">Kabupaten/Kota</th>
            <th class="border-0">Aksi</th>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>