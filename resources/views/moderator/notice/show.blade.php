@extends('custom_layouts.admin.app')

@push('css')

@endpush

@section('current-page')
<div class="breadcrumb-holder container-fluid">
    <ul class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('admin.index') }}" }}>Index</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.notice.index') }}" }}>Notice</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ul>
</div>
@endsection

@section('main-content')
@php
    use Carbon\Carbon;
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between">
                <h4 class="text-primary">{{ $notice->title }}</h4>
                <div>
                    <a href="{{ route('admin.notice.edit', $notice->id) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                    <a data-url="{{ route('admin.notice.destroy',$notice->id) }}" class="deleteNotice btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></a>
                </div>
            </div>
            <div class="card-body">
                {!! $notice->body !!}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card rounded-0">
            <div class="card-header">
                <h4>Latest 10 notices</h4>
            </div>
            <div class="card-body">
                <table class="table border border-dark">
                    <thead class="thead-light">
                        <tr class="border border-dark">
                            <th class="border border-dark" scope="col">#</th>
                            <th class="border border-dark" scope="col">Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $key => $item)
                        @if($notice->id != $item->id)
                            <tr class="border">
                                <th class="border border-dark">{{ $key+1 }}</th>
                                <td class="border border-dark"><a href="{{ route('admin.notice.show', $item->id) }}">{{ $item->title }}</a></td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')

<script>
    $(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

<script>
    $(document).on('submit', '#addNewSubject', function(event){
        event.preventDefault();
        $.ajax({
            url: "{{ route('admin.subject.store') }}",
            type: 'POST',
            data: $(this).serializeArray(),
            success: function(response){
                if (response.success) {
                    swal("Done!", 'New Subject Successfully Added!', "success")
                   .then(()=>{ location.reload()})
                } else {
                    swal("Error!", 'Something went wrong', "error");
                }
            }
        })
    })
</script>

<script>
    $(document).on('click', '.deleteNotice', function(){
        let url = $(this).data('url')
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function (response) {
                        console.log(response)
                        if (response.success) {
                            swal("Done!", 'Successfully Deleted', "success")
                            .then(()=>{
                                window.location.href = "{{ route('admin.notice.index') }}"
                            })
                        } else {
                            swal("Error!", 'Something went wrong', "error")
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })

    })
</script>

{{-- Search value --}}
<script>
    $( document ).ready(function() {
        let filter = document.getElementsByClassName("filterData");
        $(document).on('keyup', '#searchValue', function(){
            let value = $(this).val().toLowerCase()
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        })
    });
</script>
@endpush
