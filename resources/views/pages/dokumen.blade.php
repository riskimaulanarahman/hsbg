@extends('layouts.default')

@section('title', 'Dokumen')

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
			<h4 class="panel-title">Dokumen</h4>
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

        $.getJSON(apiurl + "/dokumen/"+daftarid,function(response) {
            $.each(response,function(x,y){
                maindata[x] = y
            })
        })

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
                            searchEnabled: true
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
                            displayFormat: "dd/MM/yyyy"
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
                            text: 'Update',
                            type: 'default',
                            onClick: function(e) {

                                var values = dxFormInstance.option("formData");
                                delete values.created_at
                                delete values.updated_at
                                delete values.deleted_status
                                
                                // console.log(apiurl + "/dokumen/"+daftarid, "PUT", values)
                                sendRequest(apiurl + "/dokumen/"+daftarid, "PUT", values);
                                popup.hide()
                            },
                            useSubmitBehavior: true,
                        },
                    },{
                        itemType: 'button',
                        horizontalAlignment: 'left',
                        // visible: true,
                        visible: (mode=='edit') ?false:true,
                        buttonOptions: {
                            text: 'Save',
                            type: 'success',
                            onClick: function(e) {

                                var values = dxFormInstance.option("formData");
                                values.createdby = valuserid
                                delete values.created_at
                                delete values.updated_at
                                delete values.deleted_status
                                
                                sendRequest(apiurl + "/dokumen", "POST", values);

                                popup.hide()
                            },
                            useSubmitBehavior: true,
                        },
                    },{
                        itemType: 'button',
                        horizontalAlignment: 'left',
                        buttonOptions: {
                            text: 'Back',
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
                        return $("<div id='grid-kelengkapandokumen'>").dxDataGrid({    
                            dataSource: store1,
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
                                allowAdding: true,
                                allowUpdating: true,
                                allowDeleting: true,
                            },
                            scrolling: {
                                mode: "virtual"
                            },
                            columns: [
                                { 
                                    caption: "Jenis Dokumen",
                                    dataField: "id_ref_dokumen_klien",
                                    editorType: "dxSelectBox",
                                    lookup: {
                                        dataSource: listDokumenklien,  
                                        valueExpr: 'id',
                                        displayExpr: 'nama_dokumen_klien',
                                    },
                                    validationRules: [{ type: "required" }]
                                },
                                { 
                                    dataField: "nomor_dokumen",
                                },
                            
                            ],
                            onInitialized: function(e) {
                                dxGridInstance = e.component;
                            },
                            onContentReady: function(e){
                                moveEditColumnToLeft(e.component);
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
                        })
                    } else if(data.ID == 2) {
                       
                    } else if(data.ID == 3) {
                      
                    }
                }
            })
        );


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
    title: 'Dokumen Klien',
    visible: false,
    dragEnabled: false,
    hideOnOutsideClick: false,
    showCloseButton: false,
    fullScreen : false,
    onShown: function() {
        dxFormInstance.option("formData",maindata);
    },
    onHidden: function() {
        resetGridDokumen();
    },
    // toolbarItems: [{
    //     widget: "dxButton",
    //     toolbar: "top",
    //     location: "after",
    //     options: { 
    //         icon: "close",
    //         type: "danger",
    //         text: "Close", 
    //         onClick: function(e) { 
    //             popup.hide();
    //         }
    //     }
    // }]
}).dxPopup('instance');

function resetGridDokumen() {
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
        allowDeleting: true,
    },
    scrolling: {
        mode: "virtual"
    },
    columns: [
        {
            caption: 'Action',
            cellTemplate: function(container, options) {
    
                $('<button class="btn btn-info btn-xs">Edit</button>').addClass('dx-button').on('dxclick', function(evt) {
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
            dataField: "klien.nama_lengkap_klien",
            caption: "Klien"
        },
        { 
            dataField: "tanggal_daftar_pengurusan",
            caption: "Tanggal Pengurusan"
        },
        { 
            dataField: "createdby.nama_lengkap",
            caption: "Created By"
        },
        { 
            dataField: "created_at",
            caption: "Created Date",
            dataType: "date",
            format: "dd/MM/yyyy HH:mm:ss",
        },
       
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
</script>

@endpush