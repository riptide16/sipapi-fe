<div class="btn-toolbar mb-2 mb-md-0">
    <x-buttons.create :href="route('admin.master_data.villages.create')" :title="__('Kelurahan')" />
</div>

&nbsp;
<table id="datatable-village" class="table table-centered table-nowrap mb-0 rounded" style="width: 100%">
    <thead class="thead-light">
        <th class="border-0 rounded-start">No</th>
        <th class="border-0">Provinsi</th>
        <th class="border-0">Kabupaten/Kota</th>
        <th class="border-0">Kecamatan</th>
        <th class="border-0">Name</th>
        <th class="border-0">Kode Pos</th>
        <th class="border-0">Aksi</th>
    </thead>
    <tbody>
    </tbody>
</table>