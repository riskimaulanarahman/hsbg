@extends('layouts.default')

@section('title', 'Keuangan Perusahaan')

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Keuangan Perusahaan</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="keuanganperusahaan" style="height: 640px; width:100%;"></div>
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/keuanganperusahaan");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/keuanganperusahaan", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/keuanganperusahaan/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/keuanganperusahaan/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}
// attribute
var dataGrid = $("#keuanganperusahaan").dxDataGrid({    
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
        mode: "popup",
        allowAdding: (role == 'admin' || role == 'keuangan') ? true : false,
        allowUpdating: (role == 'admin' || role == 'keuangan') ? true : false,
        allowDeleting: (role == 'admin' || role == 'keuangan') ? true : false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        { 
            caption: "Jenis Transaksi",
            dataField: "id_ref_jenis_transaksi_perusahaan",
            lookup: {
                dataSource: listJenistransaksi,  
                valueExpr: 'id',
                displayExpr: 'nama_transaksi_perusahaan',
            },
            validationRules: [{ type: "required" }]
        },
        { 
            caption: "Nilai Transaksi",
            dataField: "jumlah_nilai_transaksi",
            editorType: 'dxNumberBox',
            format: 'Rp #,##0.##',
            value: 0,
            editorOptions: {
                format: 'Rp #,##0.##',
            },
        },
        { 
            dataField: "tanggal_transaksi",
            dataType: "date",
            format: "dd-MM-yyyy",
        },
        {
            dataField: 'sistem_pembayaran',
            caption: 'Sistem Pembayaran',
            lookup: {
                dataSource: [{id:0,value:'Cash'},{id:1,value:'Transfer'}],
                valueExpr: 'id',
                displayExpr: 'value',
                searchEnabled: false
            },
        },
        {
            dataField: "doc_bukti_transaksi",
            allowFiltering: false,
            allowSorting: false,
            cellTemplate: cellTemplate,
            editCellTemplate: editCellTemplate,
        },
        {   
            caption: "Nama karyawan",
            dataField: "id_karyawan_penerima_gaji",
            lookup: {
                dataSource: listKaryawan,  
                valueExpr: 'id',
                displayExpr: 'nama_lengkap',
            },
        },
        { 
            dataField: "keterangan_transaksi",
            colSpan: 2,
            editorType: 'dxTextArea',
            editorOptions: {
                height: 90
            },
        },
    
    ],
    export: {
        enabled: true,
        fileName: "keuanganperusahaan",
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

function cellTemplate(container, options) {
    //   let imgElement = document.createElement("img");
    //   imgElement.setAttribute("src", "upload/" + options.value);
    //   imgElement.setAttribute("height", "50");
    //   imgElement.setAttribute("width", "70");
    if(options.value == null) {
        container.append('<img src="/assets/img/nofile.png" height="50" width="70">');

    } else {

        container.append('<a href="upload/'+options.value+'" target="_blank"><img src="/assets/img/showfile.png" height="50" width="70"></a>');
    }
    //   container.append('<a href="upload/'+options.value+'" target="_blank">'+imgElement+'</a>');
}

function editCellTemplate(cellElement, cellInfo) {
  let buttonElement = document.createElement("div");
  buttonElement.classList.add("retryButton");
  let retryButton = $(buttonElement).dxButton({
    text: "Retry",
    visible: false,
    onClick: function() {
      // The retry UI/API is not implemented. Use a private API as shown at T611719.
      for (var i = 0; i < fileUploader._files.length; i++) {
        delete fileUploader._files[i].uploadStarted;
      }
      fileUploader.upload();
    }
  }).dxButton("instance");

  $path = "";
  $adafile = "";
  let fileUploaderElement = document.createElement("div");
  let fileUploader = $(fileUploaderElement).dxFileUploader({
    multiple: false,
    accept: ".docx,.pdf,.xlsx,.csv,.png,.jpg,.jpeg",
    uploadMode: "instantly",
    name: "myFile",
    uploadUrl: apiurl + "/upload-berkas",
    onValueChanged: function(e) {
      let reader = new FileReader();
      reader.onload = function(args) {
        imageElement.setAttribute('src', args.target.result);
      }
      reader.readAsDataURL(e.value[0]); // convert to base64 string
    },
    onUploaded: function(e){
        $path = e.request.response;
        $adafile = false;
        cellInfo.setValue(e.request.responseText);
        retryButton.option("visible", false);
    },
    onUploadError: function(e){
        $path = "";
        DevExpress.ui.notify(e.request.response,"error");
    }
  }).dxFileUploader("instance");

  
  let imageElement = document.createElement("img");
  imageElement.classList.add("uploadedImage");
  //   if(cellInfo.value !== null) {
      imageElement.setAttribute('src', "upload/" +cellInfo.value);
// }
      imageElement.setAttribute('height', "50");
      
      cellElement.append(imageElement);
  cellElement.append(fileUploaderElement);
  cellElement.append(buttonElement);

}
</script>

@endpush