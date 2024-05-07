@push('js')
    <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.summernote').summernote({
                height: 300,
            });

            var currentSlug = "{{ $page['slug'] ?? '' }}" ? "{{ $page['slug'] ?? '' }}" : null;
            var slugEvent;
            $('#name').on('input', function (e) {
                if ($('#name').val() == '') {
                    return;
                }

                clearTimeout(slugEvent);
                let self = $(this);
                slugEvent = setTimeout(function () {
                    let route = "{{ route('admin.content-website.page.slug_availability', ['']) }}";
                    let slug = slugify(self.val());
                    $.ajax({
                        method: 'GET',
                        dataType: 'json',
                        url: route + '/' + slug,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    }).done((result) => {
                        let newSlug = '';
                        if (result.data.is_available) {
                            newSlug = slug;
                        } else {
                            if (currentSlug === null) {
                                newSlug = result.data.alternative;
                            } else {
                                if (slug == currentSlug) {
                                    newSlug = currentSlug;
                                } else {
                                    newSlug = result.data.alternative;
                                }
                            }
                        }
                        $('#slug').val(newSlug);
                    });
                }, 1000);
            });
        });

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }
    </script>
@endpush

