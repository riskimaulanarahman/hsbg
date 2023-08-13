@extends('layouts.default')

@section('title', 'Simulasi | SSH')

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Simulasi SSH</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
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
	<!-- end panel -->
@endsection

@push('scripts')

<script>
const makeAsyncDataSource = function () {
    return new DevExpress.data.CustomStore({
      loadMode: 'raw',
      key: 'id',
      load() {
        return $.getJSON(apiurl+'/listmasterssh');
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
        $.getJSON(apiurl+'/getmasterssh/'+selectedValue,function(item){
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
        return sendRequest(apiurl + "/simulasi");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/simulasi", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/simulasi/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/simulasi/"+key, "DELETE");
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