@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-dark'])

@section('title', 'Login Page')

@section('content')
	<!-- begin login -->
	<div class="login login-with-news-feed">
		<!-- begin news-feed -->
		<div class="news-feed">
			
			{{-- <div class="news-image" style="background-image: url(/assets/img/login-bg/login-bg-7.jpg)"></div> --}}
			<div class="col-md-12 text-white m-t-20">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">Simulasi</h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div id="gridBox" style="margin-bottom: 20px;"></div>
                                </div>
                                <div class="row col-md-4">
                                    <div id="default-contained"></div>
                                </div>
                            </div>
                            <hr>
                            <div id="simulasi" style="height: 400px; width:100%;"></div>
                        </div>
                </div>
			</div>
			<div class="news-caption">
				<h4 class="caption-title"><span><img style="max-width:50px; margin-top:-50px;" src="/assets/img/logo/sigi.png" alt=""></span><b> HSBG PU SIGI</b></h4>
				<p><small>KABUPATEN SIGI</small></p>
			</div>
		</div>
		<!-- end news-feed -->
		<!-- begin right-content -->
		<div class="right-content">
			<!-- begin login-header -->
			<div class="login-header">
				<div class="brand">
				    HSBG PU SIGI.
					{{-- SIM Notaris <b> Balikpapan </b> --}}
				</div>
				{{-- <div class="icon">
					<i class="fa fa-sign-in-alt"></i>
				</div> --}}
			</div>
			<!-- end login-header -->
			<!-- begin login-content -->
			<div id="poptamu"></div>
			<div class="login-content" style="margin-top:10px;">
				<form method="POST" class="margin-bottom-0" action="{{ route('login') }}">
				{{ csrf_field() }}

					<div class="form-group m-b-15">
						<!-- <input type="text" class="form-control form-control-lg" placeholder="Email Address" required /> -->
						<input id="username" type="text" class="form-control form-control-lg {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                name="username" value="{{ old('username') }}"  placeholder="Username " required autofocus>
						@if ($errors->has('username'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('username') ?: $errors->first('username') }}</strong>
						</span>
						@endif
					</div>
					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} m-b-15">
						<input id="password" type="password" name="password" class="form-control form-control-lg" placeholder="Password" required />
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
					<!-- <div class="checkbox checkbox-css m-b-30">
						<input type="checkbox" id="remember_me_checkbox" value="" name="remember" {{ old('remember') ? 'checked' : '' }} />
						<label for="remember_me_checkbox">
						Remember Me
						</label>
					</div> -->
					<div class="login-buttons">
						<button type="submit" class="btn btn-danger btn-block btn-lg"> <i class="fa fa-sign-in-alt"></i> Masuk</button>
					</div>
			
					<hr />
					<p class="text-center text-grey-darker mb-0">
						<a href="#">KABUPATEN SIGI</a> &copy; 2023
					</p>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end right-container -->
	</div>
	<!-- end login -->
@endsection

@push('scripts')

<script>
	const makeAsyncDataSource = function () {
    return new DevExpress.data.CustomStore({
      loadMode: 'raw',
      key: 'id',
      load() {
        return $.getJSON(apiurl+'/listmastersshhome');
      },
    });
  };
    $('#gridBox').dxDropDownBox({
        valueExpr: 'id',
        deferRendering: false,
        placeholder: 'Select a value...',
        displayExpr(item) {
            const formattedHarga = item.harga.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            return item && `${item.jenis_barang} | ${item.spesifikasi} (${formattedHarga})`;
        },
        showClearButton: true,
        dataSource: makeAsyncDataSource(),
        contentTemplate(e) {
            const value = e.component.option('value');
            const $dataGrid = $('<div>').dxDataGrid({
                dataSource: e.component.getDataSource(),
                columns: [
                    'id','jenis_barang', 'spesifikasi', 'satuan', 
                    { 
                        dataField: "harga",
                        editorType: 'dxNumberBox',
                        format: 'Rp #,##0.##',
                        value: 0,
                        editorOptions: {
                            format: 'Rp #,##0.##',
                        },
                    }
                ],
                hoverStateEnabled: true,
                paging: { enabled: true, pageSize: 10 },
                filterRow: { visible: true },
                scrolling: { mode: 'virtual' },
                selection: { mode: 'single' },
                selectedRowKeys: [value],
                height: '100%',
                onSelectionChanged(selectedItems) {
                    const keys = selectedItems.selectedRowKeys;
                    const hasSelection = keys.length;
                    // console.log(keys[0]);

                    e.component.option('value', hasSelection ? keys[0] : null);
                },
            });

            dataGrid = $dataGrid.dxDataGrid('instance');

            e.component.on('valueChanged', (args) => {
                dataGrid.selectRows(args.value, false);
                e.component.close();
            });

            return $dataGrid;
        },
    });

  $('#default-contained').dxButton({
    stylingMode: 'contained',
    text: 'Tambah Barang',
    type: 'default',
    width: 200,
    height: 30,
    onClick() {
        const selectedValue = $('#gridBox').dxDropDownBox('option', 'value');
        $.getJSON(apiurl+'/getmastersshhome/'+selectedValue,function(item){
            store.insert({
                jenis_barang: item.jenis_barang,
                spesifikasi: item.spesifikasi,
                satuan: item.satuan,
                harga: item.harga
            }).done(() => {
                DevExpress.ui.notify('Data berhasil ditambahkan');
                
                // Perbarui dataSource dataGridsimulasi
                dataGridsimulasi.refresh();
            }).fail(() => {
                DevExpress.ui.notify('Terjadi kesalahan saat menambahkan data', 'error', 3000);
            });
        }) 
        // DevExpress.ui.notify(`Selected Value: ${selectedValue}`);
        // dataGridsimulasi.refresh();
    },
  });

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/simulasihome");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/simulasihome", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/simulasihome/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/simulasihome/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}
// attribute
var dataGridsimulasi = $("#simulasi").dxDataGrid({    
    dataSource: store,
    allowColumnReordering: true,
    allowColumnResizing: true,
    columnsAutoWidth: true,
    // columnMinWidth: 80,
    wordWrapEnabled: true,
    showBorders: true,
    filterRow: { visible: false },
    filterPanel: { visible: false },
    headerFilter: { visible: true },
    editing: {
        useIcons:true,
        mode: "cell",
        allowAdding: false,
        allowUpdating: false,
        allowDeleting: true,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        { 
            dataField: "jenis_barang",
            sortOrder: "asc",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        { 
            dataField: "spesifikasi",
        },
        { 
            dataField: "satuan",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        { 
            dataField: "harga",
            editorType: 'dxNumberBox',
            format: 'Rp #,##0.##',
            value: 0,
            editorOptions: {
                format: 'Rp #,##0.##',
            },
            validationRules: [
                { 
                    type: "required" 
                }
            ],
        },  
    ],
    summary: {
      totalItems: [{
        column: 'harga',
        summaryType: 'sum',
        // valueFormat: 'currency',
        customizeText(data) {
          return 'Total: '+data.value.toLocaleString('id-ID', { currency: 'IDR' });
        },
      }],
    },
    export: {
        enabled: true,
        fileName: "master-ssh",
        excelFilterEnabled: true,
        allowExportSelectedData: true
    },
    onInitNewRow: function(e) {  

    } ,
    onContentReady: function(e){
        moveEditColumnToLeft(e.component);
    },
    onEditorPreparing: function(e) {

    },
    onToolbarPreparing: function(e) {
        dataGridsimulasi = e.component;

        e.toolbarOptions.items.unshift({						
            location: "after",
            widget: "dxButton",
            options: {
                hint: "Refresh Data",
                icon: "refresh",
                onClick: function() {
                    dataGridsimulasi.refresh();
                }
            }
        })
    },
}).dxDataGrid("instance");
</script>

@endpush
