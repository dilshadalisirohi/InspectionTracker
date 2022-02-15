@extends('.layouts.app')

@section('title', __('Floor Plan'))

@section('content')
    <!-- main Section -->
    <div class="main-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="dash-heading mb-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>{{ __('Floor Plan') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div id="tw-loader" class="tw-loader">
                        <div class="tw-ellipsis">
                            <div></div><div></div><div></div><div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-10">
                <div class="col-lg-12 mb-30">
                    <div class="tw-card">
                        <div class="tw-card-header mb-10 d-flex justify-content-between">
                            Floor Plan List
                            <a class="btn btn-primary" href="{{ url('admin/add-floorplan') }}"><i class="fas fa-plus"></i> Add Floor Plan</a>
                        </div>
                        <div class="tw-card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="floorplan-table">
                                    <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>BR/Bath</th>
                                    <th>Housing Guidelines</th>
                                    <th>Front Porch</th>
                                    <th>Back Porch</th>
                                    <th>Total SQFT</th>
                                    <th>Attachments</th>
                                    @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2)
                                        <th>Options</th>
                                    @endif
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session()->has('message'))
        <input type="hidden" id="message" value="{!! session('message') !!}">
    @endif
    <!-- /main Section -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            let message = $('#message').val();
            if(message === 'success') {
                Toast.fire({
                    icon: 'success',
                    title: 'Added successfully'
                })
            } else if(message === 'updated') {
                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            } else if(message == 'failed') {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed. Try again'
                })
            }

            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2)
            $('#floorplan-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{!! route('getFloorPlans') !!}',
                dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'br_bath', name: 'br_bath' },
                    { data: 'housing_guideline_sqft', name: 'housing_guideline_sqft' },
                    { data: 'front_porch_sqft', name: 'front_porch_sqft' },
                    { data: 'back_porch_sqft', name: 'back_porch_sqft' },
                    { data: 'total_sqft', name: 'total_sqft' },
                    { data: 'attachment', name: 'attachment' },
                    { data: 'action', name: 'action', orderable: false },
                ],
                columnDefs: [
                    { "width": "20%", "targets": 8 },
                ],
                order: [[0, 'asc']]
            });

            $(document).on('click', '.deleteFloorPlan', function () {
                let id = $(this).data("id");
                axios.get('{{ url('delete-floorplan') }}/'+id)
                    .then(response => {
                        if(response.data == 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            })
                            $('#floorplan-table').DataTable().clear().destroy();
                            $('#floorplan-table').DataTable({
                                processing: true,
                                serverSide: true,
                                responsive: true,
                                ajax: '{!! route('getFloorPlans') !!}',
                                dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ],
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'name', name: 'name' },
                                    { data: 'br_bath', name: 'br_bath' },
                                    { data: 'housing_guideline_sqft', name: 'housing_guideline_sqft' },
                                    { data: 'front_porch_sqft', name: 'front_porch_sqft' },
                                    { data: 'back_porch_sqft', name: 'back_porch_sqft' },
                                    { data: 'total_sqft', name: 'total_sqft' },
                                    { data: 'attachment', name: 'attachment' },
                                    { data: 'action', name: 'action', orderable: false },
                                ],
                                columnDefs: [
                                    { "width": "20%", "targets": 8 },
                                ],
                                order: [[0, 'asc']]
                            });
                        }
                    })
            })
            @else
            $('#floorplan-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{!! route('getFloorPlans') !!}',
                dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'br_bath', name: 'br_bath' },
                    { data: 'housing_guideline_sqft', name: 'housing_guideline_sqft' },
                    { data: 'front_porch_sqft', name: 'front_porch_sqft' },
                    { data: 'back_porch_sqft', name: 'back_porch_sqft' },
                    { data: 'total_sqft', name: 'total_sqft' },
                    { data: 'attachment', name: 'attachment' },
                ],
                order: [[0, 'asc']]
            });

            $(document).on('click', '.deleteFloorPlan', function () {
                let id = $(this).data("id");
                axios.get('{{ url('delete-floorplan') }}/'+id)
                    .then(response => {
                        if(response.data == 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: 'Deleted successfully'
                            })
                            $('#floorplan-table').DataTable().clear().destroy();
                            $('#floorplan-table').DataTable({
                                processing: true,
                                serverSide: true,
                                responsive: true,
                                ajax: '{!! route('getFloorPlans') !!}',
                                dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ],
                                columns: [
                                    { data: 'id', name: 'id' },
                                    { data: 'name', name: 'name' },
                                    { data: 'br_bath', name: 'br_bath' },
                                    { data: 'housing_guideline_sqft', name: 'housing_guideline_sqft' },
                                    { data: 'front_porch_sqft', name: 'front_porch_sqft' },
                                    { data: 'back_porch_sqft', name: 'back_porch_sqft' },
                                    { data: 'total_sqft', name: 'total_sqft' },
                                    { data: 'attachment', name: 'attachment' },
                                ],
                                order: [[0, 'asc']]
                            });
                        }
                    })
            })
            @endif

        })
    </script>
@endpush
