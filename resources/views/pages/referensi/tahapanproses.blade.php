@extends('layouts.default')

@section('title', 'Referensi | Tahapan Proses')

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Referensi - Tahapan Proses</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="ref-tahapanproses" style="height: 640px; width:100%;"></div>
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/tahapanproses");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/tahapanproses", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/tahapanproses/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/tahapanproses/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}
// attribute
var dataGrid = $("#ref-tahapanproses").dxDataGrid({    
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
        mode: "batch",
        allowAdding: (role == 'admin') ? true : false,
        allowUpdating: (role == 'admin') ? true : false,
        allowDeleting: false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
		{ 
            dataField: "id_ref_pengurusan_jasa",
			caption: "Pengurusan Jasa",
            sortOrder: "asc",
            // editorOptions: {
            //     disabled: false,
            // },
            lookup: {
                dataSource: listPengurusanjasa,
                valueExpr: 'id',
                displayExpr: 'nama_pengurusan',
                searchEnabled: false,
            },
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        { 
            dataField: "nomor_urut_tahapan_proses",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
		{ 
            dataField: "nama_tahapan_proses",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
		{ 
			dataField: "keterangan_tahapan_proses",
        },
		{ 
			dataField: "status_aktif",
			dataType: "boolean",
            encodeHtml: false,
            customizeText: function (e) {
                var arrText = ["<span class='btn btn-danger btn-xs'>Tidak Aktif</span>","<span class='btn btn-success btn-xs'>Aktif</span>"];
                return arrText[e.value];
            }
		},
       
    ],
    export: {
        enabled: true,
        fileName: "referensi-tahapanproses",
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
        dataGrid = e.component;

        e.toolbarOptions.items.unshift({						
            location: "after",
            widget: "dxButton",
            options: {
                hint: "Refresh Data",
                icon: "refresh",
                onClick: function() {
                    dataGrid.refresh();
                }
            }
        })
    },
}).dxDataGrid("instance");
</script>

@endpush