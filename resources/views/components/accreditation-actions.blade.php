<div class="btn-toolbar">
    @foreach ($actions as $action)
        <x-buttons.create :href="route('admin.akreditasi.create', ['type' => $action])" :title="__('Akreditasi '.ucfirst($action))" style="margin-right: 20px" />
    @endforeach
</div>
