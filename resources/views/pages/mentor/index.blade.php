@extends('layouts.master')
@section('title', 'Data Mentor')
@section('section-header')
<div class="section-header">
    <h1>Data Mentor</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Data User</a></div>
      <div class="breadcrumb-item">Mentor</div>
    </div>
</div>    
@endsection
@section('content')
<div class="buttons">
  <a href="{{ route('create.mentor') }}" class="btn btn-lg btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Tambah Mentor</a>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4>Simple</h4>
              </div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Periode</th>
                      <th scope="col">NIM</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($mentor as $no =>$item)    
                      
                    <tr>
                      <th scope="row">{{ $mentor->firstItem()+$no }}</th>
                      <td>{{ $item->id_periode }}</td>
                      <td>{{ $item->nip_nim }}</td>
                      <td>{{ $item->nim }}</td>
                      <td>
                        <a href="{{ route('edit.mentor', $item->id_mentor) }}" class="btn btn-info">Edit</a>
                        <a href="#" item-id="{{ $item->id_mentor}}" class="btn btn-danger swal-confirm">
                          <form action="{{ route('delete.mentor', $item->id_mentor) }}" id="delete{{ $item->id_mentor}}" method="POST">
                          @csrf
                          @method('delete')
                        </form>
                          Delete
                        </a>
                        <a href="mentor/detail/{{ $item->id_mentor }}" class="btn btn-dark">Detail</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $mentor->links() }}
              </div>
            </div>     
        </div>
    </div>
</div>
@endsection

@push('page-scripts')
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
@endpush

@push('after-scripts')
<script>
$(".swal-confirm").click(function(e) {
  id = e.target.dataset.id;
  swal({
      title: 'Are you sure?'+id,
      text: 'Once deleted, you will not be able to recover this imaginary file!',
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        swal('Poof! Your imaginary file has been deleted!', {
          icon: 'success',
        });
        $('#delete${id}').submit();
      } else {
        swal('Your imaginary file is safe!');
      }
    });
});
</script>    
@endpush