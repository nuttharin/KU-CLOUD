class DatabaseLogs {
    constructor(){
        let datatableFileLogObject = null;
        let datatableLogViewer = null;
        let fileLogViewer = [];
        let filelogSelect =null;
        let fileLogList = [];
        let ModalStack = null;

        let updateDatatableFileLog = () => {
            let Datatable = [];
            datatableFileLogObject.fnClearTable();

            if (fileLogList.length > 0) {
                $.each(fileLogList, function (index, item) {
                    var ret = [];
                    ret[0] = item.file;
                    ret[1] = item.size;
                    ret[2] = ` <center>
                                    <button type="button" class="btn btn-warning btn-sm btn-look-file" index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Look">
                                        <i class="fas fa-file"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm btn-download-file" index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Download">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-file"  index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>`;
                    Datatable.push(ret);
                });
                datatableFileLogObject.fnAddData(Datatable);
            }

            
            $('#table-file-log').on('click', '.btn-look-file', function () {
                onlookFileClick($(this).attr('index'));
            });

            $('#table-file-log').on('click', '.btn-download-file', function () {
                onBtnDownloadFile($(this).attr('index'));
            });

            $('#table-file-log').on('click', '.btn-delete-file', function () {
                onDeleteFileClick($(this).attr('index'));
            });

            $('[data-toggle="tooltip"]').tooltip();
        };

        let onlookFileClick = (index) => {
            $(".log-viewer").show();
            $(".file-log-viewer").hide();
            $("#file-size").html('');
            $("#path-file").html('');
            if (datatableLogViewer === null) {
                datatableLogViewer = $('#table-log').dataTable({});
            }

            $("#btn-back").unbind().click(function () {
                onBtnBackClick();
            });

            filelogSelect = null;
            filelogSelect = fileLogList[index];
            getFileLogViewer(fileLogList[index].folder, fileLogList[index].file);
        };


        let onBtnDownloadFile = (index) => {
            downloadFileLog(fileLogList[index].file);
        }

      
        let onDeleteFileClick = (index) => {
            swal({
                title: "Are you sure?",
                text: `to delete this file : ${fileLogList[index].file}`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    deleteFileLog(fileLogList[index].file);
                } else {
                    return;
                }
            });
        }

        let downloadFileLog = (file) => {
            $.ajax({
                url: `${END_POINT}company/database/log/download`,
                data : {
                    file_name : file
                },
                success: (res) => {
                    var binaryData = [];
                    binaryData.push(res);
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob(binaryData, {type: "application/text"}));
                    a.href = url;
                    a.download = file;
                    a.click();
                    window.URL.revokeObjectURL(url);
                },
                error: (error) => {
                    console.log(error);
                },
            });
        };

        let deleteFileLog = (file) => {
            $.ajax({
                url: `${END_POINT}company/database/logfile`,
                method:"DELETE",
                data : {
                    file_name : file
                },
                success: (res) => {
                  console.log(res);
                  this.refreshDatatable();
                  $("#btn-back").click();
                },
                error: (error) => {
                    console.log(error);
                },
            });
        };

        let getFileLogViewer = (folder,file) => {
            showLoadingStatus(true, $('#table-log'));
            $.ajax({
                url: `${END_POINT}company/database/logfile`,
                data: {
                    folder:folder,
                    file: file
                },
                success: (res) => {
                    fileLogViewer = res.data;
                    updateDatatableFileLogViewer();
                    showLoadingStatus(false, $('#table-log'));
                },
                error: (error) => {
                    console.log(error);
                },
            });
        };

        let onBtnBackClick = () => {
            $(".log-viewer").hide();
            $(".file-log-viewer").show();
        };

        let updateDatatableFileLogViewer = () => {
            let Datatable = [];
            datatableLogViewer.fnClearTable();
            if (fileLogViewer.logs.length > 0) {
                $("#path-file").html(`logs/${fileLogViewer.current_file}`);
                $("#file-size").html(`${fileLogViewer.size}`);
                $.each(fileLogViewer.logs, function (index, item) {
                    var ret = [];
                    ret[0] = `<i class="${item.level_img}" style="color:${item.level_color}"></i> <span class="text-${item.level_class}">${item.level}</span>`;
                    ret[1] = item.date;
                    ret[2] = `<div class='text-wrap width-200'>${item.text}</div>`;
                    ret[3] = item.stack ? `<button class='btn btn-danger btn-sm btn-radius btn-stack' index="${index}">stack</button>` : '';
                    Datatable.push(ret);
                });
                datatableLogViewer.fnAddData(Datatable);

                $('#table-log').on('click', '.btn-stack', function () {
                    onBtnStackClick($(this).attr('index'));
                });
            }

            $("#btn-download-file").unbind().click(function () {
                downloadFileLog(filelogSelect.file);
            });

            $("#btn_delete_file").unbind().click(function(){
                swal({
                    title: "Are you sure?",
                    text: `to delete this file : ${filelogSelect.file}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        deleteFileLog(filelogSelect.file);
                    } else {
                        return;
                    }
                });
               
            })
        };

        let onBtnStackClick = (index) => {
            if (ModalStack === null) {
                ModalStack = ` <div class="modal fade" id="modal-stack">
                                <div class="modal-dialog modal-lg" width:"900px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="title-user">Stack</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <textarea class="form-control" style="width:100%;height:400px" id="text-stack" readonly></textarea>
                                        </div>

                                        <div class="modal-footer">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $('body').append(ModalStack);
            }

            $("#modal-stack").modal('show');
            $("#text-stack").html(fileLogViewer.logs[index].stack);

        };

        this.initialAndRun = () => {
            this.refreshDatatable();
        };

        let initialDatatable = () => {
            if(datatableFileLogObject !== null){
                return false;
            }

            datatableFileLogObject = $("#table-file-log").dataTable({});
        };

        let showLoadingStatus = (show, datatable) => {
            if (show) {
                $(".dataTables_wrapper").hide();
                datatable.hide();
                $('.lds-roller').show();
            }
            else {
                $(".dataTables_wrapper").show();
                datatable.show();
                $('.lds-roller').hide();
            }
        };

        this.refreshDatatable = () => {
            showLoadingStatus(true, $('#table-file-log'));
            $.ajax({
                url: `${END_POINT}company/database/log/file`,
                method: 'GET',
                success: function (res) {
                    console.log(res);
                    initialDatatable();
                    fileLogList = res.file_log.files;
                    updateDatatableFileLog();
                    showLoadingStatus(false, $('#table-file-log'));
                    $("#total_size").html(`Size : ${res.file_log.size_total}`)
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    }
}

$(document).ready(function () {
    let databaseLogs = new DatabaseLogs();
    databaseLogs.initialAndRun();
});