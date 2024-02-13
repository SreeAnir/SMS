$(document).ready(function () {
    $('body').on('click', '.table_row_restore', function (e) {
        e.preventDefault();

        let el = $(this);
        let item = el.closest('.menu-item');
        let table_id = el.closest('table').attr('id');
        let url = el.find('a').attr('href');
        let active_page =  window.LaravelDataTables[table_id].page() ;
        let options = {
            buttonsStyling: false,
            confirmButtonText: item.data('confirm-label') ?? "Yes, restore it!",
            cancelButtonText: item.data('cancel-label') ?? 'No, cancel!',
        }

        swalConfirm('', item.data('title') ?? `Are you sure you want to restore?`, options).then((result) => {
            if (result.isConfirmed) {
                swalLoader();

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {submit: true},
                    success: function (data) {
                        swalSuccess(data.message, 'Done', '').then((result) => {
                            if (window.LaravelDataTables && window.LaravelDataTables[table_id]) {
                                window.LaravelDataTables[table_id].page(active_page).draw('page')

                            } else {
                                console.log('Laravel datatable with id: ' + table_id + ' not found. Hence reloading!');
                                window.location.reload();
                            }
                        });
                    },
                    error: function (json) {
                        swalError('Something went wrong!', 'Failed', '');
                    }
                });

            } else if (result.isDenied) {
                swalError('Something went wrong!', 'Failed', '');
            }
        });
    });
});

