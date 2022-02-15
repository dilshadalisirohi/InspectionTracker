@extends('.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <!-- main Section -->
    <div class="main-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="dash-heading mb-10">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>{{ __('Dashboard') }}</h2>
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
                <div class="col-md-6">
                    @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                        <div class="form-group">
                            @php
                                $contractors = \App\Models\Company::all();
                            @endphp
                            <select name="" id="contractor" class="form-control">
                                @foreach($contractors as $contractor)
                                    @if($contractor->id == \Illuminate\Support\Facades\Auth::user()->company_id)
                                        <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            @php
                                $contractors = \App\Models\Company::all();
                            @endphp
                            <select name="" id="contractor" class="form-control">
                                <option value="all">All</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                <div class="col-md-6"></div>
                <div class="col-lg-3 mb-30">
                    <div class="tw-card">
                        <div class="tw-icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="tw-content">
                            <h3 id="TotalProjects"></h3>
                            <p>{{ __('Total') }}</p>
                            <p id="totalCount"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-30">
                    <div class="tw-card">
                        <div class="tw-icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="tw-content">
                            <h3 id="InprogressProjects"></h3>
                            <p>{{ __('Scheduled') }}</p>
                            <p id="scheduledCount"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-30">
                    <div class="tw-card">
                        <div class="tw-icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="tw-content">
                            <h3 id="TimeOut"></h3>
                            <p>{{ __('Cancelled') }}</p>
                            <p id="cancelledCount"></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-30">
                    <div class="tw-card">
                        <div class="tw-icon">
                            <i class="fa fa-file"></i>
                        </div>
                        <div class="tw-content">
                            <h3 id="CompletedProjects"></h3>
                            <p>{{ __('Submitted') }}</p>
                            <p id="submittedCount"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-10">
                <div class="col-lg-12">
                    <div class="tw-card">
                        <div class="tw-card-header">{{ __('Inspector Status') }}</div>
                        <canvas id="inspector"></canvas>
                    </div>
                </div>
            </div>

            <div class="row mt-10">
                <div class="col-lg-12">
                    <div class="tw-card">
                        <div class="tw-card-header mb-10 d-flex justify-content-between">
                            All Applications
                            <div>
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                                    <a class="btn btn-primary" href="{{ url('contractor/add-application') }}"><i class="fas fa-plus"></i> Add Application</a>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->role_id == 2)
                                    <a class="btn btn-primary" href="{{ url('admin/add-application') }}"><i class="fas fa-plus"></i> Add Application</a>
                                @endif
                            </div>
                        </div>
                        <style>
                            table tbody td {
                                min-width: 100px;
                            }
                        </style>
                        <div class="tw-card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Construction Type</label>
                                        <select name="" id="construction_type" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="Recon">Recon</option>
                                            <option value="Repair">Repair</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Inspection Type</label>
                                        <select name="" id="inspection_type" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="50">50%</option>
                                            <option value="100">100%</option>
                                            <option value="REHAB">REHAB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Inspection Status</label>
                                        <select name="" id="inspection_status" class="form-control">
                                            <option value="">Select...</option>
                                            <option value="Scheduled">Scheduled</option>
                                            <option value="Submitted">Submitted</option>
                                            <option value="Canceled">Canceled</option>
                                        </select>
                                    </div>
                                </div>
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2 || \Illuminate\Support\Facades\Auth::user()->role_id == 1)
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Inspector</label>
                                            <select name="" id="inspector" class="form-control">
                                                <option value="">Select...</option>
                                                @foreach($inspectors as $inspector)
                                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if(\Illuminate\Support\Facades\Auth::user()->role_id == 2 || \Illuminate\Support\Facades\Auth::user()->role_id == 3)
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Contractor</label>
                                            <select name="" id="contructor" class="form-control">
                                                <option value="">Select...</option>
                                                @foreach($contructors as $contructor)
                                                    <option value="{{ $contructor->id }}">{{ $contructor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="application-table">
                                    <thead>
                                    <th>ID</th>
                                    <th>HRIQ ID</th>
                                    <th>Applicant Name</th>
                                    <th>Applicant Address</th>
                                    <th>Applicant City</th>
                                    <th>Applicant Country</th>
                                    <th>Requested Date</th>
                                    <th>Requester Name</th>
                                    <th>Requester Email</th>
                                    <th>Requester Phone</th>
                                    <th>Construction Type</th>
                                    <th>Floor Plan</th>
                                    <th>Region</th>
                                    <th>Options</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="row">--}}
{{--                <div class="col-lg-3 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-icon">--}}
{{--                            <i class="fa fa-rocket"></i>--}}
{{--                        </div>--}}
{{--                        <div class="tw-content">--}}
{{--                            <h3 id="TotalTasks"></h3>--}}
{{--                            <p>{{ __('Total Tasks') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-icon">--}}
{{--                            <i class="fa fa-line-chart"></i>--}}
{{--                        </div>--}}
{{--                        <div class="tw-content">--}}
{{--                            <h3 id="DoingTasks"></h3>--}}
{{--                            <p>{{ __('Doing Tasks') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-icon">--}}
{{--                            <i class="fa fa-thumbs-o-down"></i>--}}
{{--                        </div>--}}
{{--                        <div class="tw-content">--}}
{{--                            <h3 id="TimeoutTasks"></h3>--}}
{{--                            <p>{{ __('Timeout Tasks') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-3 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-icon">--}}
{{--                            <i class="fa fa-thumbs-o-up"></i>--}}
{{--                        </div>--}}
{{--                        <div class="tw-content">--}}
{{--                            <h3 id="CompletedTasks"></h3>--}}
{{--                            <p>{{ __('Completed Tasks') }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <div class="col-lg-6 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-card-header">{{ __('Projects Status') }}</div>--}}
{{--                        <canvas id="pie_chart_projects"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-lg-6 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-card-header">{{ __('Staffs Status') }}</div>--}}
{{--                        <canvas id="pie_chart_staffs"></canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row">--}}
{{--                <div class="col-lg-12 mb-30">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-card-header mb-10">{{ __('Projects List') }}</div>--}}
{{--                        <div class="tw-card-body">--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table id="DataTableIdProject" class="table table-striped table-bordered">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th width="25%">{{ __('Project Name') }}</th>--}}
{{--                                        <th width="12%">{{ __('Created By') }}</th>--}}
{{--                                        <th width="18%">{{ __('Staff') }}</th>--}}
{{--                                        <th width="5%">{{ __('Client') }}</th>--}}
{{--                                        <th width="10%">{{ __('Start Date') }}</th>--}}
{{--                                        <th width="10%">{{ __('End Date') }}</th>--}}
{{--                                        <th width="10%">{{ __('Status') }}</th>--}}
{{--                                        <th width="10%">{{ __('Milestones') }}</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody></tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row dnone" id="ClientGridHideShow">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="tw-card">--}}
{{--                        <div class="tw-card-header mb-10">{{ __('Client List') }}</div>--}}
{{--                        <div class="tw-card-body">--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table id="DataTableIdClient" class="table table-striped table-bordered">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th width="31%">{{ __('Client/Country') }}</th>--}}
{{--                                        <th width="31%">{{ __('E-mail/Phone') }}</th>--}}
{{--                                        <th width="31%">{{ __('Social Media') }}</th>--}}
{{--                                        <th width="7%">{{ __('Photos') }}</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody></tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
    <!-- /main Section -->
@endsection
@push('scripts')
    <!-- Chart js -->
    <script src="{{asset('public/assets/js/Chart.min.js')}}"></script>
    <!-- datatables css/js -->
    <link rel="stylesheet" href="{{asset('public/assets/datatables/dataTables.bootstrap4.min.css')}}">
    <script src="{{asset('public/assets/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/assets/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript">
        {{--var base_url = "{{ url('/') }}";--}}
        {{--var public_path = "{{ asset('public') }}";--}}
        {{--var userid = "{{ Auth::user()->id }}";--}}
        {{--var roleid = "{{ Auth::user()->role_id }}";--}}
        {{--var TEXT = [];--}}
        {{--TEXT['View'] = "{{ __('View') }}";--}}
        {{--TEXT['Milestones View'] = "{{ __('Milestones View') }}";--}}
        $(document).ready(function() {
            let id = $('#contractor').val();
            let ctx = document.querySelector('#inspector')
            let myChart;

            axios.get('{{ url('contractorData') }}/'+id)
                .then(response => {
                    $('#totalCount').empty();
                    $('#submittedCount').empty();
                    $('#cancelledCount').empty();
                    $('#scheduledCount').empty();

                    $('#totalCount').append(response.data.total);
                    $('#submittedCount').append(response.data.submitted);
                    $('#cancelledCount').append(response.data.cancelled);
                    $('#scheduledCount').append(response.data.scheduled);

                    let labels = [];
                    let scheduled_data = [];
                    let submitted_data = [];
                    let cancelled_data = [];
                    let count = 0;
                    response.data.inspectors.map(value => {
                        labels.push(value.name)

                        scheduled_data.push(response.data.scheduled_inspector[count])
                        submitted_data.push(response.data.submitted_inspector[count])
                        cancelled_data.push(response.data.cancelled_inspector[count])
                        count++;
                    })


                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Scheduled',
                                    data: scheduled_data,
                                    borderColor: '#eea5ac',
                                    backgroundColor: '#eea5ac',
                                },
                                {
                                    label: 'Submitted',
                                    data: submitted_data,
                                    borderColor: '#fad24d',
                                    backgroundColor: '#fad24d',
                                },
                                {
                                    label: 'Canceled',
                                    data: cancelled_data,
                                    borderColor: '#1cb0f1',
                                    backgroundColor: '#1cb0f1',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false,
                                    text: 'Application Inspectors'
                                }
                            },
                            scales: {
                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        beginAtZero: true,
                                    }
                                }]
                            },
                        },
                    });
                })

            $('#contractor').on("change", function() {
                id = $('#contractor').val();
                axios.get('{{ url('contractorData') }}/'+id)
                    .then(response => {
                        $('#totalCount').empty();
                        $('#submittedCount').empty();
                        $('#cancelledCount').empty();
                        $('#scheduledCount').empty();

                        $('#totalCount').append(response.data.total);
                        $('#submittedCount').append(response.data.submitted);
                        $('#cancelledCount').append(response.data.cancelled);
                        $('#scheduledCount').append(response.data.scheduled);

                        let labels = [];
                        let scheduled_data = [];
                        let submitted_data = [];
                        let cancelled_data = [];
                        let count = 0;
                        response.data.inspectors.map(value => {
                            labels.push(value.name)

                            scheduled_data.push(response.data.scheduled_inspector[count])
                            submitted_data.push(response.data.submitted_inspector[count])
                            cancelled_data.push(response.data.cancelled_inspector[count])
                            count++;
                        })

                        myChart.destroy();
                        myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Scheduled',
                                        data: scheduled_data,
                                        borderColor: '#eea5ac',
                                        backgroundColor: '#eea5ac',
                                    },
                                    {
                                        label: 'Submitted',
                                        data: submitted_data,
                                        borderColor: '#fad24d',
                                        backgroundColor: '#fad24d',
                                    },
                                    {
                                        label: 'Canceled',
                                        data: cancelled_data,
                                        borderColor: '#1cb0f1',
                                        backgroundColor: '#1cb0f1',
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: false,
                                        text: 'Application Inspectors'
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        display: true,
                                        ticks: {
                                            beginAtZero: true,
                                        }
                                    }]
                                },
                            },
                        });
                    })
            })
        })

    </script>
    <script src="{{asset('public/pages/dashboard.js')}}"></script>
    <script>
            $(function () {
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })

            $('#construction_type').on('change', function () {
                $('#application-table').DataTable().destroy().clear();
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })

            $('#inspection_status').on('change', function () {
                $('#application-table').DataTable().destroy().clear();
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })

            $('#inspection_type').on('change', function () {
                $('#application-table').DataTable().destroy().clear();
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })

            $('#inspector').on('change', function () {
                $('#application-table').DataTable().destroy().clear();
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })

            $('#contructor').on('change', function () {
                $('#application-table').DataTable().destroy().clear();
                $('#application-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: true,
                    ajax: '{!! route('getApplications') !!}?construction_type='+$('#construction_type').val()+'&inspection_type='+$('#inspection_type').val()+'&inspection_status='+$('#inspection_status').val()+'&inspector='+$('#inspector').val()+'&contractor='+$('#contructor').val(),
                    dom: '<"row mt-4 top"<"col-md-3"l><"col-md-6 text-center"B><"col-md-3"f>>rtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'hriq_id', name: 'hriq_id' },
                        { data: 'applicant_name', name: 'application_name' },
                        { data: 'applicant_address', name: 'applicant_address' },
                        { data: 'applicant_city', name: 'applicant_city' },
                        { data: 'applicant_county', name: 'applicant_county' },
                        { data: 'requested_date', name: 'requested_date' },
                        { data: 'requester_name', name: 'requester_name' },
                        { data: 'requester_email', name: 'requester_email' },
                        { data: 'requester_phone', name: 'requester_phone' },
                        { data: 'construction_type', name: 'construction_type' },
                        { data: 'floor_plan', name: 'floor_plan' },
                        { data: 'region', name: 'region' },
                        { data: 'action', name: 'action', orderable: false },
                    ],
                    // columnDefs: [
                    //     { "width": "33%", "targets": 0 },
                    //     { "width": "33%", "targets": 1 },
                    //     { "width": "34%", "targets": 2 },
                    // ],
                    columnDefs: [
                        {
                            "targets": [ 0 ],
                            "visible": false
                        }
                    ],
                    order: [[0, 'desc']]
                });
            })
    </script>
@endpush
