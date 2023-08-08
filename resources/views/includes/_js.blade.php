<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $('#nama_mesin').select2({
                width: '100%',
                placeholder: 'Nama mesin',
                allowClear: true,
                tags: true,
            });
    $('.btn-delete').on('click', function() {
                    const userId = $(this).data('user-id');
                    const username = $(this).data('username');
                    const url = $(this).data('url');
                    const deleteForm = $('#deleteForm');

                    deleteForm.attr('action', url);
                    // Isi data pengguna yang akan dihapus ke dalam modal delete
                    deleteForm.find('.modal-body p').html(`Anda yakin ingin menghapus data <span class="fw-bold">${username}?</span>`);

                    // Set action URL form delete sesuai dengan ID pengguna yang akan dihapus
                    // Tampilkan modal delete
                    $('#deleteModal').modal('show');
                });
                $('#numbersOnlyInput').on('input', function() {
                    // Get the current value of the input field
                    let inputValue = $(this).val();

                    // Use a regular expression to replace any non-numeric characters with an empty string
                    let numericValue = inputValue.replace(/[^0-9]/g, '');

                    // Update the input field with the numeric value
                    $(this).val(numericValue);
                });
</script>
@yield('script')
