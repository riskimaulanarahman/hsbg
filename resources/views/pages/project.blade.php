@extends('layouts.default')

@section('title', 'Data Project')

@push('css')
<style>
.dx-accordion-item-title {
    padding: 5px;
}
</style>
@endpush

@section('content')
	<!-- begin panel -->
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4 class="panel-title">Data Project</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="dokumen" style="height: 640px; width:100%;"></div>
            <div id="popup"></div>
            <div id="popprompt"></div>
            <div id="large-indicator"></div>
            
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/project");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/project", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/project/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/project/"+key, "DELETE");
    },
});

function moveEditColumnToLeft(dataGrid) {
    dataGrid.columnOption("command:edit", { 
        visibleIndex: -1,
        width: 80 
    });
}

const accordionItems = [
    {
        ID: 1,
        Title: '<i class="fa fa-clipboard-check"> Details </i>',
    },
    // {
    //     ID: 2,
    //     Title: '<i class="fa fa-clock"> Riwayat Proses </i>',
    // },
    // {
    //     ID: 3,
    //     Title: '<i class="fa fa-file-invoice-dollar"> Riwayat Pembayaran </i>',
    // },
];

const loadPanel = $('.loadpanel').dxLoadPanel({
    shadingColor: 'rgba(0,0,0,0.4)',
    position: { of: '#klienForm' },
    visible: false,
    showIndicator: true,
    showPane: true,
    shading: true,
    hideOnOutsideClick: false,
    onShown() {
      setTimeout(() => {
        loadPanel.hide();
      }, 3000);
    },
    onHidden() {
    //   showEmployeeInfo(employee);
        // dataGrid.refresh();
    },
  }).dxLoadPanel('instance');

const popupContentPrompt = function (data) {
    
    var namaklien = data.klien.nama_lengkap_klien;
    var jenispengurusan = data.pengurusanjasa.nama_pengurusan;
    var tanggalinput = data.tanggal_daftar_pengurusan;
    var statusproses = (data.status_selesai == 0) ? 'Selesai' : 'Belum Selesai';
    var statuspembayaran = (data.status_lunas == 0) ? 'Lunas' : 'Belum Lunas';

    return $('<div>').append(
      $(`<p>Klien: <strong>${namaklien}</strong>`),
      $(`<p>Jenis Pengurusan: <strong>${jenispengurusan}</strong></p>`),
      $(`<p>Pernah diinput tanggal: <strong>${tanggalinput}</strong></p>`),
      $(`<p>Status Proses: <strong>${statusproses}</strong></p>`),
      $(`<p>Status Pembayaran: <strong>${statuspembayaran}</strong></p>`),
      $(`<br><br>`),
      $(`<strong>Apakah Anda Yakin Ingin Membuat "Daftar Pengurusan" Baru ?</strong>`),
    );

}

const popupContentTemplate = function (daftarid,mode) {
        maindata = {};

        if(daftarid !== undefined) {
            $.getJSON(apiurl + "/project/"+daftarid,function(response) {
                $.each(response,function(x,y){
                    maindata[x] = y
                })
            })
        }

        const scrollView = $('<div />');

        scrollView.append(
            $("<div id='klienForm'>").dxForm({
                onInitialized: function(e) {
                    dxFormInstance = e.component;
                },
                labelMode : 'floating',
                readOnly: false,
                showColonAfterLabel: true,
                showValidationSummary: false,
                items: [ {
                itemType: 'group',
                caption: '',
                colCount : 2,
                items: [
                    {
                        dataField: 'sp',
                        label: {text: 'SP'},
                        validationRules: [{type: 'required'}],
                        editorOptions: {
                            readOnly: (role == 'admin') ? false : true,
                        }
                    },
                    {
                        dataField: 'witel',
                        label: {text: 'Witel'},
                        editorOptions: {
                            readOnly: (role == 'admin') ? false : true,
                        }
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'lokasi',
                        label: {text: 'Lokasi'},
                        editorOptions: {
                            readOnly: (role == 'admin') ? false : true,
                        }
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'nilaimaterialdrm',
                        label: {text: 'Nilai Material DRM'},
                        editorType: 'dxNumberBox',
                        editorOptions: {
                            format: 'Rp #,##0.##',
                            readOnly: (role == 'admin') ? false : true,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'nilaijasadrm',
                        label: {text: 'Nilai Jasa DRM'},
                        editorType: 'dxNumberBox',
                        editorOptions: {
                            format: 'Rp #,##0.##',
                            readOnly: (role == 'admin') ? false : true,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'nilaitotaldrm',
                        label: {text: 'Nilai Total DRM'},
                        editorType: 'dxNumberBox',
                        editorOptions: {
                            format: 'Rp #,##0.##',
                            readOnly: (role == 'admin') ? false : true,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'nilaitotalrekon',
                        label: {text: 'Nilai Total REKON'},
                        editorType: 'dxNumberBox',
                        editorOptions: {
                            format: 'Rp #,##0.##',
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'mitra',
                        label: {text: 'Mitra'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: listMitra,
                            valueExpr: 'nama_mitra',
                            displayExpr: 'nama_mitra',
                            searchEnabled: false,
                            readOnly: (role == 'admin') ? false : true,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'onair',
                        label: {text: 'On Air'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: ['Done','Not Yet'],
                            searchEnabled: false,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'progress',
                        label: {text: 'Progress %'},
                        editorOptions: {
                            readOnly: true,
                        },
                        // validationRules: [{type: 'required'}],
                    },
                    ],
                }, 
                {
                    itemType: "group",
                    caption: "",
                    colCount:10,
                    items: [{
                        itemType: 'button',
                        horizontalAlignment: 'left',
                        visible: (mode=='edit') ?true:false,
                        disabled: (role == 'admin' || role == 'user') ? false : true,
                        buttonOptions: {
                            text: 'Ubah',
                            type: 'default',
                            onClick: function(e) {

                                var values = dxFormInstance.option("formData");
                                delete values.created_at
                                delete values.updated_at
                                
                                var result = dxFormInstance.validate();
                                if(result.isValid) {
                                    sendRequest(apiurl + "/project/"+daftarid, "PUT", values);
                                    
                                    popup.hide();
                                    dataGrid.refresh();

                                } else {
                                    DevExpress.ui.dialog.alert("Your form is not complete or has invalid value, please recheck before submit","Error");
                                }
                            },
                            useSubmitBehavior: true,
                        },
                    },{
                        itemType: 'button',
                        horizontalAlignment: 'left',
                        visible: (mode=='edit') ?false:true,
                        buttonOptions: {
                            text: 'Simpan',
                            type: 'success',
                            onClick: function(e) {

                                var values = dxFormInstance.option("formData");
                                values.createdby = valuserid
                                delete values.created_at
                                delete values.updated_at

                                var result = dxFormInstance.validate();
                                if(result.isValid) {
                                    sendRequest(apiurl + "/project", "POST", values).then(function(response){
                                        dataGrid.refresh();
                                    });
                                } else {
                                    DevExpress.ui.dialog.alert("Your form is not complete or has invalid value, please recheck before submit","Error");
                                }

                            },
                            useSubmitBehavior: true,
                        },
                    },{
                        itemType: 'button',
                        horizontalAlignment: 'left',
                        buttonOptions: {
                            text: 'Batal',
                            type: 'danger',
                            onClick: function(e) {
                                popup.hide()
                            },
                            useSubmitBehavior: true,
                            
                        },
                    }],
                }],
                
            }),
            $("<hr>"),
            
        );
        // if(daftarid !== undefined) {
            scrollView.append(
                $("<div>").dxAccordion({
                    dataSource: accordionItems,
                    animationDuration: 600,
                    selectedItems: [accordionItems[0],accordionItems[1],accordionItems[2]],
                    collapsible: true,
                    multiple: true,
                    itemTitleTemplate: function (data) {
                        return '<small style="margin-bottom:10px !important ;">'+data.Title+'</small>'
                    },
                    itemTemplate: function (data) {
                        
                        if(data.ID == 1) {      
                            var store1 = new DevExpress.data.CustomStore({
                                key: "id",
                                load: function() {
                                    return sendRequest(apiurl + "/projectdetail/"+daftarid);
                                },
                                insert: function(values) {
                                    values.project_id = daftarid;
                                    return sendRequest(apiurl + "/projectdetail", "POST", values);
                                },
                                update: function(key, values) {
                                    return sendRequest(apiurl + "/projectdetail/"+key, "PUT", values);
                                },
                                remove: function(key) {
                                    return sendRequest(apiurl + "/projectdetail/"+key, "DELETE");
                                },
                            });       
                            return $("<div id='grid-projectdetail'>").dxDataGrid({    
                                dataSource: store1,
                                allowColumnReordering: true,
                                allowColumnResizing: true,
                                columnsAutoWidth: true,
                                // columnHidingEnabled: true,
                                wordWrapEnabled: true,
                                showBorders: true,
                                filterRow: { visible: true },
                                filterPanel: { visible: false },
                                headerFilter: { visible: true },
                                editing: {
                                    useIcons:true,
                                    mode: "cell",
                                    allowAdding: (role == 'admin' || role == 'user') ? true : false,
                                    allowUpdating: (role == 'admin' || role == 'user') ? true : false,
                                    allowDeleting: (role == 'admin') ? true : false,
                                },
                                searchPanel: {
                                    visible: true,
                                    width: 240,
                                    placeholder: 'Search...',
                                },
                                scrolling: {
                                    rowRenderingMode: 'virtual',
                                },
                                paging: {
                                    pageSize: 20,
                                },
                                pager: {
                                    visible: true,
                                    allowedPageSizes: [10, 20, 'all'],
                                    showPageSizeSelector: true,
                                    showInfo: true,
                                    showNavigationButtons: true,
                                    displayMode: 'compact'
                                },
                                columns: [
                                    // { 
                                    //     caption: "Jenis Dokumen",
                                    //     dataField: "id_ref_dokumen_klien",
                                    //     lookup: {
                                    //         dataSource: listDokumenklien,  
                                    //         valueExpr: 'id',
                                    //         displayExpr: 'nama_dokumen_klien',
                                    //     },
                                    //     validationRules: [{ type: "required" }]
                                    // },
                                    // {
                                    //     dataField: "foto_dokumen_klien",
                                    //     allowFiltering: false,
                                    //     allowSorting: false,
                                    //     cellTemplate: cellTemplate,
                                    //     editCellTemplate: editCellTemplate,
                                    // },
                                    { 
                                        dataField: "tanggal",
                                        dataType: "date",
                                        editorType: 'dxDateBox',
                                        format: "dd-MM-yyyy",
                                        width: 100,
                                        editorOptions: {
                                            displayFormat: "dd-MM-yyyy"
                                        },
                                    },
                                    { 
                                        dataField: "sub_status",
                                        caption: "Sub Status",
                                        lookup: {
                                            dataSource: listsubStatus,  
                                            valueExpr: 'substatus',
                                            displayExpr: 'substatus',
                                        },
                                    },
                                    { 
                                        dataField: "status",
                                        editorOptions: {
                                            readOnly: true
                                        }
                                    },
                                    { 
                                        dataField: "keterangan",
                                    },
                                    {
                                        caption: 'Galian Rojok',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'galian_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'galian_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'Penarikan HDPE',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'penarikanhdpe_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'penarikanhdpe_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'Tiang',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'tiang_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'tiang_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'Penarikan Kabel',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'penarikankabel_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'penarikankabel_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'HH/MH',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'hhmh_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'hhmh_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'OTB/ODP',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'otbodp_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'otbodp_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    {
                                        caption: 'Terminasi/Splice (OS/SM)',
                                        columns: [{
                                            caption: 'Plan',
                                            dataField: 'terminasi_plan',
                                            editorType: 'dxNumberBox',
                                            editorOptions: {
                                                readOnly: (role == 'admin') ? false : true,
                                            }
                                        }, {
                                            caption: 'Realisasi',
                                            dataField: 'terminasi_realisasi',
                                            editorType: 'dxNumberBox',
                                        }],
                                    },
                                    { 
                                        dataField: "finishinstalasi",
                                        caption: "Finish Instalasi",
                                        editorType: 'dxSelectBox',
                                        editorOptions: {
                                            dataSource: ['Done','Not Yet'],
                                            searchEnabled: false,
                                        },
                                    },
                                    { 
                                        dataField: "ujiterima",
                                        caption: "Uji Terima",
                                        editorType: 'dxSelectBox',
                                        editorOptions: {
                                            dataSource: ['Done','Not Yet'],
                                            searchEnabled: false,
                                        },
                                    },
                                
                                ],
                                summary: {
                                    totalItems: [
                                        {
                                            column: 'tanggal',
                                            // summaryType: 'sum',
                                            customizeText(data) {
                                                return 'Grand Total :'
                                            },
                                        },
                                        {
                                            column: 'galian_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'galian_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'penarikanhdpe_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'penarikanhdpe_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'tiang_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'tiang_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'penarikankabel_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'penarikankabel_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'hhmh_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'hhmh_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'otbodp_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'otbodp_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'terminasi_plan',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                        {
                                            column: 'terminasi_realisasi',
                                            summaryType: 'sum',
                                            customizeText(data) {
                                                return data.value
                                            },
                                        },
                                    ],
                                },
                                onInitialized: function(e) {
                                    dxGridInstance1 = e.component;
                                },
                                onContentReady: function(e){
                                    moveEditColumnToLeft(e.component);
                                },
                                onCellPrepared: function(e) {
                                    if(e.rowType=='totalFooter') {
                                        if(e.column.dataField == 'keterangan') {
                                            e.cellElement.innerHTML = 'Grand Total'
                                        }
                                    }
                                },
                                // onUpdated: function(e) {
                                //     dxFormInstance.option("formData",maindata);
                                // },
                                onToolbarPreparing: function(e) {
                                    e.toolbarOptions.items.unshift({						
                                        location: "after",
                                        widget: "dxButton",
                                        options: {
                                            hint: "Refresh Data",
                                            icon: "refresh",
                                            onClick: function() {
                                                dxGridInstance1.refresh();
                                            }
                                        }
                                    })
                                },
                            })
                        } 
                       
                    }
                })
            );
        // }



        scrollView.dxScrollView({
            width: '100%',
            height: '100%',
        })

        return scrollView;

};


const popup = $('#popup').dxPopup({
    contentTemplate: popupContentTemplate,
    container: '.content',
    showTitle: true,
    title: 'Project Data',
    visible: false,
    dragEnabled: false,
    hideOnOutsideClick: false,
    showCloseButton: true,
    fullScreen : true,
    onShown: function() {
        // console.log(maindata)
        dxFormInstance.option("formData",maindata);
        // dxFormInstance.itemOption("id_ref_pengurusan_jasa", "editorOptions", {readOnly:(maindata.id_ref_pengurusan_jasa == null) ? false : true});
        // dxFormInstance.itemOption("id_klien", "editorOptions", {readOnly:(maindata.id_klien == null) ? false : true});
        // if(role == 'admin' || role == 'user') {
        // } else {
        //     dxFormInstance.itemOption("proses_biasa_cepat", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("tanggal_daftar_pengurusan", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("total_biaya_daftar_pengurusan", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("status_lunas", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("status_selesai", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("status_aktif", "editorOptions", {readOnly: true });
        //     dxFormInstance.itemOption("keterangan_daftar_pengurusan", "editorOptions", {readOnly: true });
        // }
    },
    onHidden() {
        dataGrid.refresh();
    },

}).dxPopup('instance');

const popprompt = $('#popprompt').dxPopup({
    contentTemplate: popupContentPrompt,
    width: 500,
    height: 350,
    // container: '.content',
    showTitle: true,
    title: 'Data Duplikat',
    visible: false,
    dragEnabled: false,
    hideOnOutsideClick: false,
    showCloseButton: true,
    fullScreen : false,
    toolbarItems: [{
      widget: 'dxButton',
      toolbar: 'bottom',
      location: 'before',
      options: {
        // icon: 'email',
        text: 'Lanjut',
        onClick() {
            var valuespr = dxFormInstance.option("formData");
            valuespr.mode = 'ignore';

            console.log('from prompt :');
            console.log(valuespr);

            // var result = dxFormInstance.validate();
            // if(result.isValid) {
                sendRequest(apiurl + "/project", "POST", valuespr).then(function(response){

                    popprompt.hide();
                    dataGrid.refresh();
                    loadPanel.show()
                        
                    setTimeout(() => {
                        loadPanel.hide()

                        if(response.status !== 'error') {
                            $('#btndaftarid'+response.data.id).trigger('click')
                        }
                    }, 5000);

                });
            // } else {
            //     DevExpress.ui.dialog.alert("Your form is not complete or has invalid value, please recheck before submit","Error");
            // }
        },
      },
    }, {
      widget: 'dxButton',
      toolbar: 'bottom',
      location: 'after',
      options: {
        text: 'Batal',
        onClick() {
          popprompt.hide();
        },
      },
    }],

}).dxPopup('instance');

function resetGridDokumen() {
    console.log('hide')
    dataGrid.refresh();
}

var dataGrid = $("#dokumen").dxDataGrid({    
    dataSource: store,
    allowColumnReordering: true,
    allowColumnResizing: true,
    columnsAutoWidth: true,
    // columnHidingEnabled: true,
    wordWrapEnabled: true,
    showBorders: true,
    filterRow: { visible: true },
    filterPanel: { visible: true },
    headerFilter: { visible: true },
    editing: {
        useIcons:true,
        mode: "popup",
        allowAdding: false,
        allowUpdating: false,
        allowDeleting: (role == 'admin') ? true : false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        {
            caption: 'Action',
            cellTemplate: function(container, options) {
    
                $('<button class="btn btn-info btn-xs" id="btndaftarid'+options.data.id+'"><i class="fa fa-search"></i></button>').addClass('dx-button').on('dxclick', function(evt) {
                    evt.stopPropagation();
                        var daftarid = options.data.id
                        var mode = 'edit'
                        // if (role == 'admin' || role == 'user') {

                            popup.option({
                                contentTemplate: () => popupContentTemplate(daftarid,mode),
                            });
                            popup.show();

                        // } else {
                        //     DevExpress.ui.dialog.alert("Anda Tidak Memiliki Akses","Error");
                        // }
                }).appendTo(container);
            
            }
        },     
        { 
            dataField: "sp",
            caption: "SP"
        },
        {
            dataField: "witel",
            caption: "Witel"
        },
        {
            dataField: "lokasi",
            caption: "Lokasi"
        },
        {
            dataField: "nilaimaterialdrm",
            caption: "Nilai Material DRM",
            format: {
                type: "fixedPoint",
            }
        },
        {
            dataField: "nilaijasadrm",
            caption: "Nilai Jasa DRM",
            format: {
                type: "fixedPoint",
            }
        },
        {
            dataField: "nilaitotaldrm",
            caption: "Nilai Total DRM",
            format: {
                type: "fixedPoint",
            }
        },
        {
            dataField: "nilaitotalrekon",
            caption: "Nilai Total Rekon",
            format: {
                type: "fixedPoint",
            }
        },
        {
            dataField: "mitra",
            caption: "Mitra"
        },
        {
            dataField: "progress",
            caption: "Progress (%)"
        },
        {
            dataField: "onair",
            caption: "On Air"
        },
       
    ],
    export: {
        enabled: true,
        fileName: "Project",
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
        },{
            location: "after",
            widget: "dxButton",
            visible: (role == 'admin') ? true : false,
            options: {
                hint: "Add",
                icon: "add",
                onClick: function() {
                    popup.option({
                        contentTemplate: () => popupContentTemplate(),
                    });
                    popup.show();
                }
            }
        })
    },
}).dxDataGrid("instance");


//file upload

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

      imageElement.setAttribute('src', "upload/" +cellInfo.value);
      imageElement.setAttribute('height', "50");
      
      cellElement.append(imageElement);
  cellElement.append(fileUploaderElement);
  cellElement.append(buttonElement);

}

</script>

@endpush