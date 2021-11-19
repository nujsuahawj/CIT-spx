@extends('layouts.basedoc')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{__('doc.import_doc')}}</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{__('doc.home')}}</a></li>
                <li class="breadcrumb-item active">{{__('doc.import_doc')}}</li>
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
                  @if (Auth::user()->rolename->name == 'admin' || Auth::user()->rolename->name == 'manager')
                    <a href="{{route('import_doc.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-add"></i>{{__('doc.add')}}</a>
                  @endif
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>{{__('doc.no')}}</th>
                      <th>{{__('doc.doc_no')}}</th>
                      <th>{{__('doc.date')}}</th>
                      <th>{{__('doc.doc_typename')}}</th>
                      <th>{{__('doc.short_title')}}</th>
                      <th>{{__('doc.external_partsname')}}</th>
                      <th>{{__('doc.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $stt = 1;    
                    @endphp

                    @foreach ($import_doc as $im)
                    <tr>
                      <td width=5%>{{$stt++}}</td>
                      <td>
                          <a href="{{ route('import_doc.show', $im->id) }}">{{$im->code}}</a>
                      </td>
                      <td>
                        <a href="{{ route('import_doc.show', $im->id) }}">{{date('d/m/Y', strtotime($im->date)) }}</a>
                      </td>
                      <td>
                        <a href="{{ route('import_doc.show', $im->id) }}">{{$im->typename->name}}</a>
                      </td>
                      <td>
                        <a href="{{ route('import_doc.show', $im->id) }}">{{$im->title}}</a>
                      </td>
                      <td>{{$im->externalname->name}}</td>
                      <td>
                        <form action=" {{ route('import_doc.destroy', $im->id) }} " method="POST">
                          @csrf
                          @method('DELETE')

                          <a href="{{route('download_import', $im->id)}}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                          
                          @if (Auth::user()->rolename->name == 'admin' || Auth::user()->rolename->name == 'manager')
                          <a href="{{ route('import_doc.edit', $im->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ທ່ານຕ້ອງການລຶບຂໍ້ມູນນີ້ ຫຼື ບໍ?')"><i class="fas fa-trash"></i></button>
                          @endif

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