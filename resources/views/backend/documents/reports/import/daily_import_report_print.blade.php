<html>
				<head>
				 	<title>{{__('doc.daily_import_report')}}</title>
                     <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}"/>
				 	<style>
				 	.main-content {
                        font-family: Phetsarath OT;
					    text-align: center;
					    width: 100%;
					}
                    .column {
                        font-family: Phetsarath OT;
                        float: left;
                        width: 33.33%;
                    }
                    .column-left{
                        font-family: Phetsarath OT;
                        text-align: left;
                    }
                    .column-center{
                        font-family: Phetsarath OT;
                        text-align: center;
                    }
                    .column-right{
                        font-family: Phetsarath OT;
                        text-align: right;
                    }

                    .column-four {
                        font-family: Phetsarath OT;
                        float: center;
                        width: 100%;
                    }
                    .label-sum{
                        font-family: Phetsarath OT;
                        text-align: left
                    }

                    .header-company-info{
                        font-family: Phetsarath OT;
                        text-align: left;
                        width:50%
                    }

					table.table {
                        font-family: Phetsarath OT;
					    width: 100%;
                        border-collapse : collapse; 
                        border : 1px solid black;
					    margin: 0 auto;
					    text-align: left;
					}

                    #customers {
                    border-collapse: collapse;
                    width: 100%;
                    }

                    #customers td, #customers th {
                    border: 1px solid #ddd;
                    padding: 5px;
                    }

                    #customers tr:nth-child(even){background-color: #f2f2f2;}

                    #customers tr:hover {background-color: #ddd;}

                    #customers th {
                    padding-top: 5px;
                    padding-bottom: 5px;
                    text-align: center;
                    }

				 	</style>
				</head>
				<body>
                    <div class="hearder-title">
                        <div class="main-content">
                            <label>{{__('doc.hearder-title1')}}</label> <br>
                            <label>{{__('doc.hearder-title2')}}</label> <br>
                        </div>
                    </div> <br>

                    <div class="hearder-content">
                        <div class="row">
                            <div class="column">
                                <div class="column-left">
                                    <img src="{{asset($branch->logo)}}" height="50" alt="Visa"> <br>
                                    <label><b>
                                          @if (Config::get('app.locale') == 'lo')
                                            {{ $branch->company_name_la }}
                                          @elseif (Config::get('app.locale') == 'en')
                                            {{ $branch->company_name_en }}
                                          @endif
                                    </b></label> <br>
                                    <label>
                                          @if (Config::get('app.locale') == 'lo')
                                            {{ $branch->address_la }}
                                          @elseif (Config::get('app.locale') == 'en')
                                            {{ $branch->address_en }}
                                          @endif
                                    </label> <br>
                                    <label>ໂທ: {{$branch->phone}}</label> <br>
                                </div>
                            </div>
                            <div class="column">
                                <div class="column-center">
                                    <br><br>
                                    <label><h3><b>{{__('doc.daily_import_report')}}</b></h3></label>
                                </div>
                            </div>
                            <div class="column">
                                <div class="column-right">
                                    <br><br><br><br>
                                    <label>{{__('doc.date')}}: @php echo date("d/m/Y") @endphp</label><br><br>
                                </div>
                            </div>
                        </div>
                    </div>

					<div class="main-content">
						<div class="parking-info">

							<table id="customers">
                                <thead>
                                    <tr align="center">
                                        <th style="width: 10px">{{__('doc.no')}}</th>
                                        <th>{{__('doc.doc_no')}}</th>
                                        <th>{{__('doc.doc_type')}}</th>
                                        <th>{{__('doc.short_title')}}</th>
                                        <th>{{__('doc.from')}}</th>
                                        <th>{{__('doc.no_doc')}}-{{__('doc.date')}}</th>
                                    </tr>
                                </thead>
                                @php
                                    $stt = 1;    
                                @endphp
                                <tbody>
                                    @foreach ($daily_import as $item)
                                    <tr>
                                        <td style="text-align:center">{{$stt++}}</td>
                                        <td style="text-align: center">{{$item->code}}</td>
                                        <td  style="text-align: center">{{$item->typename->name}}</td>
                                        <td>{{$item->short_title}}</td>
                                        <td style="text-align: center">{{$item->externalname->name}}</td>
                                        <td style="text-align: center">{{$item->doc_no}}-{{date('d/m/Y', strtotime($item->doc_date))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
							</table>
						</div>
					</div>

                    <div class="hearder-content">
                        <div class="row">
                            <br>
                            <div class="column">
                                <div class="column-center">
                                    <b>{{$branch->sign1}}</b>
                                </div>
                            </div>
                            <div class="column">
                                <div class="column-center">
                                    <b>{{$branch->sign2}}</b>
                                </div>
                            </div>
                            <div class="column">
                                <div class="column-center">
                                    <b>{{$branch->sign3}}</b>
                                </div>
                            </div>
                        </div>
                    </div>		
				</body>
                <script>
                    window.addEventListener("load", window.print());
                  </script>
			</html>