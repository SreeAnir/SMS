class DeleteManager {
    data = {method: '_DELETE', delete_step: 'check'};

    constructor(el) {
        this.el = el;
        this.item = el.closest('.menu-item');
        this.table_id = el.closest('table').attr('id');
        this.url = el.find('a').attr('href');
        this.active_page =  window.LaravelDataTables[this.table_id].page() ;
        this.options = {
            buttonsStyling: false,
            confirmButtonText: this.item.data('confirm-label') ?? "Yes, delete!",
            cancelButtonText: this.item.data('cancel-label') ?? 'No, discard!',
        }

    }

    run() {
        $.ajax({
            url: this.url,
            type: 'DELETE',
            dataType: 'json',
            data: this.data,
            success: response => {
                //Check step
                if (response.status === 'checked') {
                    if (response.confirmation === 'remote') {
                        this.data.delete_step = 'confirm';
                        this.run();
                    } else {
                        swalConfirm('', this.item.data('title') ?? 'Are you sure you want to delete?', this.options)
                            .then((result) => {
                                if (result.isConfirmed) {
                                    this.data.delete_step = 'destroy';
                                    swalLoader();
                                    this.run();
                                }
                            });
                    }
                    return;
                }

                //Confirmation step
                if (response.status === 'confirm') {
                    swalConfirm(response.message, response.title ?? 'Confirm?', this.options).then(result => {
                        if (result.isConfirmed) {
                            this.data.delete_step = 'destroy';
                            swalLoader();
                            this.run();
                        }
                    });
                    return;
                }

                //Final destroy step
                if (response.status === 'success') {
                    swalSuccess(response.message, 'Done').then((result) => {
                        if (window.LaravelDataTables && window.LaravelDataTables[this.table_id]) {
                            window.LaravelDataTables[this.table_id].page(this.active_page).draw('page');
                        } else if (response.redirect) {
                            window.location.href = response.redirect;
                        } else if (route().current('*.show')) {
                            window.location.href = route(route().current().replace('.show', '.index'));
                        } else {
                            console.log('Laravel datatable with id: ' + this.table_id + ' not found. Hence reloading!');
                            window.location.reload();
                        }
                    });
                } else if (response.status === 'failed') {
                    swalError(response.message, 'Failed');
                } else {
                    swalError('Something went wrong!', 'Failed');
                }
            },
            error: function (json) {
                swalError('Something went wrong!', 'Failed');
            }
        });
    }
}

$(() => {
    $('body').on('click', '.table_row_delete', function (e) {
        e.preventDefault();
        let manager = new DeleteManager($(this));
        swalLoader();
        manager.run();
    });
});

