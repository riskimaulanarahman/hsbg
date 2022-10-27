@extends('layouts.default')

@section('title', 'Kelola | Klien')

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Kelola - Klien</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="kelola-klien" style="height: 640px; width:100%;"></div>
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/kelola-klien");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/kelola-klien", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/kelola-klien/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/kelola-klien/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}
// attribute
jenisidentitas = [{id:1,identitas:"KTP"},{id:2,identitas:"SIM"},{id:3,identitas:"PASSPORT"},{id:4,identitas:"LAINNYA"}];

var dataGrid = $("#kelola-klien").dxDataGrid({    
    dataSource: store,
    allowColumnReordering: true,
    allowColumnResizing: true,
    // columnsAutoWidth: true,
    columnHidingEnabled: true,
    // columnMinWidth: 80,
    wordWrapEnabled: true,
    showBorders: true,
    filterRow: { visible: true },
    filterPanel: { visible: true },
    headerFilter: { visible: true },
    editing: {
        useIcons:true,
        mode: "popup",
        allowAdding: (role == 'admin' || role == 'staff') ? true : false,
        allowUpdating: (role == 'admin' || role == 'staff') ? true : false,
        allowDeleting: (role == 'admin') ? true : false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        { 
            dataField: "nama_lengkap_klien",
            sortOrder: "asc",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
		'nama_badan_usaha',
        { 
            dataField: "alamat_klien",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        { 
            dataField: "nomor_identitas_klien",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        { 
            dataField: "jenis_identitas_klien",
            editorType: "dxSelectBox",
            validationRules: [
                { 
                    type: "required" 
                }
            ],
            editorOptions: {
                dataSource: jenisidentitas,  
                valueExpr: 'identitas',
                displayExpr: 'identitas',
            },
        },
        { 
            dataField: "telpon_1_klien",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        'telpon_2_klien',
        { 
            dataField: "email_klien",
            validationRules: [
                { 
                    type: "required" 
                }
            ]
        },
        'keterangan_klien'
       
    ],
    export: {
        enabled: true,
        fileName: "kelola-klien",
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