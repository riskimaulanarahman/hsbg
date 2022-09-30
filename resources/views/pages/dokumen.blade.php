@extends('layouts.default')

@section('title', 'Data Pengurusan')

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
			<h4 class="panel-title">Data Pengurusan</h4>
			<div class="panel-heading-btn">
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<div id="dokumen" style="height: 640px; width:100%;"></div>
            <div id="popup"></div>
            
		</div>
	</div>
	<!-- end panel -->
@endsection

@push('scripts')

<script>

var store = new DevExpress.data.CustomStore({
    key: "id",
    load: function() {
        return sendRequest(apiurl + "/dokumen");
    },
    insert: function(values) {
        return sendRequest(apiurl + "/dokumen", "POST", values);
    },
    update: function(key, values) {
        return sendRequest(apiurl + "/dokumen/"+key, "PUT", values);
    },
    remove: function(key) {
        return sendRequest(apiurl + "/dokumen/"+key, "DELETE");
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
        Title: '<i class="fa fa-clipboard-check"> Kelengkapan Dokumen </i>',
    },
    {
        ID: 2,
        Title: '<i class="fa fa-clock"> Riwayat Proses </i>',
    },
    {
        ID: 3,
        Title: '<i class="fa fa-file-invoice-dollar"> Riwayat Pembayaran </i>',
    },
];

const popupContentTemplate = function (daftarid,mode) {
        maindata = {};

        if(daftarid !== undefined) {
            $.getJSON(apiurl + "/dokumen/"+daftarid,function(response) {
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
                        dataField: 'id_klien',
                        label: {text: 'Klien'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: listKlien,
                            valueExpr: 'id',
                            displayExpr: 'nama_lengkap_klien',
                            searchEnabled: true
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'id_ref_pengurusan_jasa',
                        label: {text: 'Pengurusan Jasa'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: listPengurusanjasa,
                            valueExpr: 'id',
                            displayExpr: 'nama_pengurusan',
                            searchEnabled: false,
                        },
                        validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'proses_biasa_cepat',
                        label: {text: 'Proses'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: [{id:0,value:'Biasa'},{id:1,value:'Cepat'}],
                            valueExpr: 'id',
                            displayExpr: 'value',
                            searchEnabled: true
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'tanggal_daftar_pengurusan',
                        label: {text: 'Tanggal pengurusan'},
                        editorType: 'dxDateBox',
                        editorOptions: {
                            displayFormat: "dd-MM-yyyy"
                        },
                        validationRules: [{type: 'required'}],
                    },
                    {
                        dataField: 'total_biaya_daftar_pengurusan',
                        label: {text: 'Total Biaya'},
                        editorType: 'dxNumberBox',
                        editorOptions: {
                            format: 'Rp #,##0.##',
                        },
                        validationRules: [{type: 'required'}],

                    }, 
                    {
                        dataField: 'status_lunas',
                        label: {text: 'Status Lunas'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: [{id:0,value:'Lunas'},{id:1,value:'Belum Lunas'}],
                            valueExpr: 'id',
                            displayExpr: 'value',
                            searchEnabled: false
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'status_selesai',
                        label: {text: 'Status Selesai'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: [{id:0,value:'Selesai'},{id:1,value:'Belum Selesai'}],
                            valueExpr: 'id',
                            displayExpr: 'value',
                            searchEnabled: false
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'status_aktif',
                        label: {text: 'Status Aktif'},
                        editorType: 'dxSelectBox',
                        editorOptions: {
                            dataSource: [{id:0,value:'Aktif'},{id:1,value:'Tidak Aktif'}],
                            valueExpr: 'id',
                            displayExpr: 'value',
                            searchEnabled: false,
                        },
                        validationRules: [{type: 'required'}],
                    }, 
                    {
                        dataField: 'keterangan_daftar_pengurusan',
                        label: {text: 'Keterangan'},
                        colSpan: 2,
                        editorType: 'dxTextArea',
                        editorOptions: {
                            height: 90
                        },
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
                        buttonOptions: {
                            text: 'Ubah',
                            type: 'default',
                            onClick: function(e) {

                                var values = dxFormInstance.option("formData");
                                delete values.created_at
                                delete values.updated_at
                                delete values.deleted_status
                                
                                // console.log(apiurl + "/dokumen/"+daftarid, "PUT", values)
                                sendRequest(apiurl + "/dokumen/"+daftarid, "PUT", values);
                                
                                popup.hide();
                                dataGrid.refresh();
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
                                delete values.deleted_status

                                var result = dxFormInstance.validate();
                                if(result.isValid) {
                                    sendRequest(apiurl + "/dokumen", "POST", values).then(function(response){
                                        dataGrid.refresh();
                                        
                                        setTimeout(() => {
                                            if(response.status !== 'error') {
                                                $('#btndaftarid'+response.data.id).trigger('click')
                                            }
                                        }, 5000);
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
                                // dataGrid.refresh();
                            },
                            useSubmitBehavior: true,
                            
                        },
                    }],
                }],
                
            }),
            $("<hr>"),
            
        );
        if(daftarid !== undefined) {
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
                                    return sendRequest(apiurl + "/kelengkapandokumen/"+daftarid);
                                },
                                insert: function(values) {
                                    values.id_daftar_pengurusan = daftarid;
                                    return sendRequest(apiurl + "/kelengkapandokumen", "POST", values);
                                },
                                update: function(key, values) {
                                    return sendRequest(apiurl + "/kelengkapandokumen/"+key, "PUT", values);
                                },
                                remove: function(key) {
                                    return sendRequest(apiurl + "/kelengkapandokumen/"+key, "DELETE");
                                },
                            });       
                            return $("<div id='grid-kelengkapandokumen'>").dxDataGrid({    
                                dataSource: store1,
                                allowColumnReordering: true,
                                allowColumnResizing: true,
                                columnsAutoWidth: true,
                                wordWrapEnabled: true,
                                showBorders: true,
                                filterRow: { visible: true },
                                filterPanel: { visible: false },
                                headerFilter: { visible: true },
                                editing: {
                                    useIcons:true,
                                    mode: "popup",
                                    allowAdding: true,
                                    allowUpdating: true,
                                    allowDeleting: true,
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
                                    pageSize: 10,
                                },
                                pager: {
                                    visible: true,
                                    allowedPageSizes: [5, 10, 'all'],
                                    showPageSizeSelector: true,
                                    showInfo: true,
                                    showNavigationButtons: true,
                                    displayMode: 'compact'
                                },
                                columns: [
                                    { 
                                        caption: "Jenis Dokumen",
                                        dataField: "id_ref_dokumen_klien",
                                        lookup: {
                                            dataSource: listDokumenklien,  
                                            valueExpr: 'id',
                                            displayExpr: 'nama_dokumen_klien',
                                        },
                                        validationRules: [{ type: "required" }]
                                    },
                                    {
                                        dataField: "foto_dokumen_klien",
                                        allowFiltering: false,
                                        allowSorting: false,
                                        cellTemplate: cellTemplate,
                                        editCellTemplate: editCellTemplate,
                                    },
                                    { 
                                        dataField: "keterangan_dokumen_klien",
                                    },
                                    { 
                                        dataField: "nomor_dokumen",
                                    },
                                    { 
                                        dataField: "tanggal_penyerahan",
                                        dataType: "date",
                                        format: "dd-MM-yyyy",
                                    },
                                    { 
                                        dataField: "lokasi_penyerahan_dokumen_klien",
                                    },
                                
                                ],
                                onInitialized: function(e) {
                                    dxGridInstance1 = e.component;
                                },
                                onContentReady: function(e){
                                    moveEditColumnToLeft(e.component);
                                },
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
                        } else if(data.ID == 2) {
                            var store2 = new DevExpress.data.CustomStore({
                                key: "id",
                                load: function() {
                                    return sendRequest(apiurl + "/riwayatproses/"+daftarid);
                                },
                                insert: function(values) {
                                    // values.id_daftar_pengurusan = daftarid;
                                    // return sendRequest(apiurl + "/riwayatproses", "POST", values);
                                },
                                update: function(key, values) {
                                    return sendRequest(apiurl + "/riwayatproses/"+key, "PUT", values);
                                },
                                remove: function(key) {
                                    // return sendRequest(apiurl + "/riwayatproses/"+key, "DELETE");
                                },
                            });       
                            return $("<div id='grid-riwayatproses'>").dxDataGrid({    
                                dataSource: store2,
                                allowColumnReordering: true,
                                allowColumnResizing: true,
                                columnsAutoWidth: true,
                                wordWrapEnabled: true,
                                showBorders: true,
                                filterRow: { visible: false },
                                filterPanel: { visible: false },
                                headerFilter: { visible: true },
                                editing: {
                                    useIcons:true,
                                    mode: "cell",
                                    allowAdding: false,
                                    allowUpdating: true,
                                    allowDeleting: false,
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
                                    pageSize: 10,
                                },
                                pager: {
                                    visible: true,
                                    allowedPageSizes: [5, 10, 'all'],
                                    showPageSizeSelector: true,
                                    showInfo: true,
                                    showNavigationButtons: true,
                                    displayMode: 'compact'
                                },
                                columns: [
                                    { 
                                        caption: "Tahapan",
                                        dataField: "id_ref_tahapan_proses",
                                        lookup: {
                                            dataSource: listTahapanproses,  
                                            valueExpr: 'id',
                                        displayExpr: 'nama_tahapan_proses',
                                        },
                                        validationRules: [{ type: "required" }]
                                    },
                                    { 
                                        dataField: "tgl_mulai_riwayat_proses",
                                        caption: "Tgl Mulai",
                                        dataType: "date",
                                        format: "dd-MM-yyyy",
                                    },
                                    { 
                                        dataField: "tgl_akhir_riwayat_proses",
                                        caption: "Tgl Akhir",
                                        dataType: "date",
                                        format: "dd-MM-yyyy",
                                    },
                                    {
                                        dataField: "keterangan_riwayat_proses"
                                    },
                                    {
                                        dataField: 'durasi_tahapan_proses',
                                        editorType: 'dxNumberBox',
                                    },
                                    { 
                                        dataField: "status_proses_selesai",
                                        dataType: "boolean"
                                    },
                                ],
                                onInitialized: function(e) {
                                    dxGridInstance2 = e.component;
                                },
                                onContentReady: function(e){
                                    moveEditColumnToLeft(e.component);
                                },
                                onToolbarPreparing: function(e) {
                                    e.toolbarOptions.items.unshift({						
                                        location: "after",
                                        widget: "dxButton",
                                        options: {
                                            hint: "Refresh Data",
                                            icon: "refresh",
                                            onClick: function() {
                                                dxGridInstance2.refresh();
                                            }
                                        }
                                    })
                                },
                            })
                        } else if(data.ID == 3) {
                            var store3 = new DevExpress.data.CustomStore({
                                key: "id",
                                load: function() {
                                    return sendRequest(apiurl + "/riwayatpembayaran/"+daftarid);
                                },
                                insert: function(values) {
                                    values.id_daftar_pengurusan = daftarid;
                                    return sendRequest(apiurl + "/riwayatpembayaran", "POST", values);
                                },
                                update: function(key, values) {
                                    return sendRequest(apiurl + "/riwayatpembayaran/"+key, "PUT", values);
                                },
                                remove: function(key) {
                                    return sendRequest(apiurl + "/riwayatpembayaran/"+key, "DELETE");
                                },
                            });       
                            return $("<div id='grid-riwayatpembayaran'>").dxDataGrid({    
                                dataSource: store3,
                                allowColumnReordering: true,
                                allowColumnResizing: true,
                                columnsAutoWidth: true,
                                wordWrapEnabled: true,
                                showBorders: true,
                                filterRow: { visible: false },
                                filterPanel: { visible: false },
                                headerFilter: { visible: true },
                                editing: {
                                    useIcons:true,
                                    mode: "popup",
                                    allowAdding: true,
                                    allowUpdating: true,
                                    allowDeleting: true,
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
                                    pageSize: 10,
                                },
                                pager: {
                                    visible: true,
                                    allowedPageSizes: [5, 10, 'all'],
                                    showPageSizeSelector: true,
                                    showInfo: true,
                                    showNavigationButtons: true,
                                    displayMode: 'compact'
                                },
                                columns: [
                                    { 
                                        caption: "Uraian Bayar",
                                        dataField: "id_ref_uraian_bayar",
                                        lookup: {
                                            dataSource: listUraianbayar,  
                                            valueExpr: 'id',
                                            displayExpr: 'uraian_bayar',
                                        },
                                        validationRules: [{ type: "required" }]
                                    },
                                    {
                                        dataField: 'jumlah_pembayaran',
                                        editorType: 'dxNumberBox',
                                        format: 'Rp #,##0.##',
                                        editorOptions: {
                                            format: 'Rp #,##0.##',
                                        },
                                        validationRules: [{type: 'required'}],
                                    },
                                    { 
                                        dataField: "tanggal_pembayaran",
                                        caption: "Tgl Pembayaran",
                                        dataType: "date",
                                        format: "dd-MM-yyyy",
                                        validationRules: [{type: 'required'}],
                                    },
                                    {
                                        dataField: 'sistem_pembayaran',
                                        lookup: {
                                            dataSource: [{id:0,value:'Cash'},{id:1,value:'Transfer'}],
                                            valueExpr: 'id',
                                            displayExpr: 'value',
                                            searchEnabled: false
                                        },
                                        validationRules: [{type: 'required'}],
                                    },
                                    {
                                        dataField: 'uraianbayar.titipan_pajak',
                                        editorOptions: {
                                            disabled : true
                                        },
                                        lookup: {
                                            dataSource: [{id:0,value:'Ya'},{id:1,value:'Tidak'}],
                                            valueExpr: 'id',
                                            displayExpr: 'value',
                                            searchEnabled: false
                                        },
                                    },
                                    {
                                        dataField: "foto_bukti_pembayaran",
                                        allowFiltering: false,
                                        allowSorting: false,
                                        cellTemplate: cellTemplate,
                                        editCellTemplate: editCellTemplate,
                                    },
                                    { 
                                        dataField: "keterangan_pembayaran",
                                    },
                                ],
                                summary: {
                                    totalItems: [{
                                        column: 'jumlah_pembayaran',
                                        summaryType: 'sum',
                                        displayFormat: 'Total : Rp {0}',
                                        valueFormat: {
                                            type: 'fixedPoint',
                                            precision: 0
                                        },
                                    }],
                                },
                                onInitialized: function(e) {
                                    dxGridInstance2 = e.component;
                                },
                                onContentReady: function(e){
                                    moveEditColumnToLeft(e.component);
                                },
                                onToolbarPreparing: function(e) {
                                    e.toolbarOptions.items.unshift({						
                                        location: "after",
                                        widget: "dxButton",
                                        options: {
                                            hint: "Refresh Data",
                                            icon: "refresh",
                                            onClick: function() {
                                                dxGridInstance2.refresh();
                                            }
                                        }
                                    })
                                },
                            })
                        }
                    }
                })
            );
        }



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
    title: 'Pengurusan Jasa',
    visible: false,
    dragEnabled: false,
    hideOnOutsideClick: false,
    showCloseButton: false,
    fullScreen : false,
    onShown: function() {
        dxFormInstance.option("formData",maindata);
        dxFormInstance.itemOption("id_ref_pengurusan_jasa", "editorOptions", {disabled:(maindata.id_ref_pengurusan_jasa == null) ? false : true});
        dxFormInstance.itemOption("id_klien", "editorOptions", {disabled:(maindata.id_klien == null) ? false : true});
    },
    // onHidden: function() {
    //     resetGridDokumen();
    // },

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
        allowDeleting: false,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        {
            caption: 'Action',
            cellTemplate: function(container, options) {
    
                $('<button class="btn btn-info btn-xs" id="btndaftarid'+options.data.id+'">Edit</button>').addClass('dx-button').on('dxclick', function(evt) {
                    evt.stopPropagation();
                        var daftarid = options.data.id
                        var mode = 'edit'
                        popup.option({
                            contentTemplate: () => popupContentTemplate(daftarid,mode),
                        });
                        popup.show();
                }).appendTo(container);
            
            }
        },
        {
            dataField: 'status_aktif',
            encodeHtml: false,
            customizeText: function (e) {
                var arrText = ["<span class='btn btn-success btn-xs'>Aktif</span>","<span class='btn btn-danger btn-xs'>Tidak Aktif</span>"];
                return arrText[e.value];
            }
        },
        { 
            dataField: "klien.nama_lengkap_klien",
            caption: "Klien"
        },
        { 
            dataField: "pengurusanjasa.nama_pengurusan",
            caption: "Jenis Jasa"
        },
        { 
            dataField: "tanggal_daftar_pengurusan",
            caption: "Tanggal Daftar",
            dataType: "date",
            format: "dd-MM-yyyy",
        },
        { 
            dataField: "total_biaya_daftar_pengurusan",
            caption: "Total Biaya",
            format: {
                type: "fixedPoint",
            }
        },
        {
            dataField: 'status_lunas',
            encodeHtml: false,
            customizeText: function (e) {
                var arrText = ["<span class='btn btn-success btn-xs'>Lunas</span>","<span class='btn btn-danger btn-xs'>Belum Lunas</span>"];
                return arrText[e.value];
            }
        },
        {
            dataField: 'status_selesai',
            encodeHtml: false,
            customizeText: function (e) {
                var arrText = ["<span class='btn btn-success btn-xs'>Selesai</span>","<span class='btn btn-danger btn-xs'>Belum Selesai</span>"];
                return arrText[e.value];
            }
        }, 
        // { 
        //     dataField: "createdby.nama_lengkap",
        //     caption: "Created By"
        // },
        // { 
        //     dataField: "created_at",
        //     caption: "Created Date",
        //     dataType: "date",
        //     format: "dd-MM-yyyy HH:mm:ss",
        // },
       
    ],
    export: {
        enabled: true,
        fileName: "dokumen",
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
  container.append('<a href="upload/'+options.value+'" target="_blank"><img src="upload/'+options.value+'" height="50" width="70"></a>');
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
    accept: "image/*",
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