@extends('layouts.basedoc')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('doc.depart')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">{{__('doc.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('doc.depart')}}</li>
              </ol>
            </div>
          </div>
        </div>
      </section>
  
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <a href="{{route('depart.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('doc.add')}}</a>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('doc.no')}}</th>
                      <th>{{__('doc.departname')}}</th>
                      <th>{{__('doc.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $stt = 1;    
                    @endphp

                    @foreach ($depart as $dp)
                    <tr>
                      <td>{{$stt++}}</td>
                      <td>{{$dp->name}}</td>
                      <td>
                        <form action=" {{ route('depart.destroy', $dp->id) }} " method="POST">
                          @csrf
                          @method('DELETE')

                            <a href="{{ route('depart.edit', $dp->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>

                        </form>
                      </td>
                    </tr>
                    @endforeach
                    
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
@endsection