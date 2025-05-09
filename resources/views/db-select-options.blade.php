@extends('layouts.master')

@section('title', ucwords( strtolower( str_replace('_',' ',$DBSelectOptions) ) ))


@section('content')

<div class="container flex-grow-1 table-responsive">
    <h1 class="pb-5">{{ ucwords( strtolower( str_replace('_',' ',$DBSelectOptions) ) ) }}</h1>
    <div class="pb-3 ms-2">
        <button type="button" class="btn btn-md btn-success" id="btn-new-record" name="btn-new-record"><i class="fas fa-plus-circle" aria-hidden="true"></i> New Record</button>
    </div>
    <table id="table" class="table table-striped table-hover" style="width:100%;">
    <input type="hidden" name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}" id="_token">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Actions</th>
                <th>Updated At</th>
            </tr>
        </tfoot>
    </table>
    @include('modals.generic-message')
    @include('modals.db-select-options.create-and-edit-option')
    @include('toasts.generic-toasts')
</div>

@endsection
@section('script')
<script>
    $(document).ready( function () {
        $.fn.dataTable.ext.errMode = 'none';
        datatable = $('#table').DataTable({
            "language": {
                //"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },  
            "searching": true,       
            "ajax": {
                type: "POST",
                url: "read",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : { 'DBSelectOptions' : "{{$DBSelectOptions}}", '_token':  "{{ csrf_token() }}"},
                dataType: 'json',
            },
            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "id",
                    "orderable": false,
                    render: function ( data, type, row ) {
                        return `<button type="button" class="btn btn-sm btn-primary btn-edit" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button>&nbsp;
                            <button type="button" class="btn btn-sm btn-danger btn-delete" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                    }
                },
                {
                    "data": "updated_at",
                }
            ],
            "order": [
                [2, 'desc'],
            ],
            "columnDefs": [
                {
                    targets: [2],
                    visible: false
                }
            ]
        }).on('error.dt', function(e, settings, techNote, message) {
            
            if (typeof techNote === 'undefined') {

            } else {
                // Show error in console
                console.error(message);
                myHelper_swalGenericError();
                datatable.destroy();
                $('#btn-new-record').hide();
                $('#adminlte-alert').hide();
                
            }
            return true;
        });
        
        $('#btn-new-record').click(function(event) {

            event.preventDefault();

            $('#formCreateAndEdit')[0].reset();
            $("[name='_method']").val("POST")
            $('#modalCreateAndEdit').modal('show');

        });

        $('#table tbody').off('click', 'button.btn-edit');
        $('#table tbody').on('click', 'button.btn-edit', function(event) {
            event.preventDefault();

            $('#formCreateAndEdit')[0].reset();
            $("[name='_method']").val("PATCH")
            $('#modalCreateAndEdit').modal('show');
            
            var currentRow = $(this).closest("tr");
            var data = $('#table').DataTable().row(currentRow).data();

            $('#name').val(data['name']);
            $('#id').val(data['id']);
        });

        $('#formCreateAndEdit').on('submit', function(e){
            e.preventDefault();
            
            postFormData = new FormData();
            postFormData.append("_token", "{{ csrf_token() }}");
            postFormData.append("_method", $("[name='_method']").val());
            postFormData.append("id", $('#id').val());
            postFormData.append("name", $('#name').val());
            postFormData.append("DBSelectOptions", "{{$DBSelectOptions}}");
            
            var ajaxURL = $("[name='_method']").val() === "POST" ? 'create' : 'update';
            
            $.ajax({
                url: ajaxURL,
                type: 'POST',
                dataType: 'json',
                data: postFormData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                beforeSend: function() {
                    $('#btnSave').prop('disabled',true);
                    $('#btnSave').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Working...');
                }
            })
            .always(function() {
                $('#btnSave').prop('disabled',false);
                $('#btnSave').html('Save');
            })
            .done(function(response) {
                if(response.success) {
                    $('#table').DataTable().ajax.reload(null, false);
                    $('#modalCreateAndEdit').modal('hide');
                    $('#formCreateAndEdit')[0].reset();

                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'));
                    toastBootstrap.show();
                } else {
                    alert("Something Went Wrong");
                }
            })
            .fail(function(response) {
                alert("Something Went Wrong");
            });
        });


        $('#table tbody').off('click', 'button.btn-delete');
        $('#table tbody').on('click', 'button.btn-delete', function(event) {
            
            var me=$(this),
            id=me.attr('value');

            $('#modalGenericMessage').modal('show');
            $('#idGenericMessage').val(id);
        });

        $('#btnModalGenericMessage').click(function(event) {

            event.preventDefault();
            
            $.ajax({
                url: 'delete',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token:  "{{ csrf_token() }}",
                    _method: "DELETE",
                    id: $('#idGenericMessage').val(),
                    DBSelectOptions: "{{$DBSelectOptions}}",
                },
                beforeSend: function() {
                    $('#btnModalGenericMessage').prop('disabled',true);
                    $('#btnModalGenericMessage').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Working...');
                }
            })
            .always(function() {
                $('#btnModalGenericMessage').prop('disabled',false);
                $('#btnModalGenericMessage').html('<strong>Yes</strong>');
            })
            .done(function(response) {
                if(response.success) {
                    $('#table').DataTable().ajax.reload(null, false);
                    $('#modalGenericMessage').modal('hide');

                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'));
                    toastBootstrap.show();

                    $('#idGenericMessage').val("0");
                } else {
                    alert("Something Went Wrong");
                }
            })
            .fail(function(response) {
                alert("Something Went Wrong");
            });

        });

        /*
        const toastTrigger = document.getElementById('btn-new-record')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
        }
        */
    });
</script>
@endsection