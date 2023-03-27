$("#city").select2({
    width: "100%",
    dropdownParent: $("#modalAddEmp"),
    tags: false,
    multiple: false,
    // closeOnSelect:false,
    placeholder: "Please type here",
    maximumSelectionSize: 12,
    minimumInputLength: 2,
    createTag: function(params) {
        // empty string is not allow
        var term = $.trim(params.term);
        if (term === "") {
            return null;
        }
        return {
            id: term,
            text: term,
        };
    },
    templateResult: function(params) {
        return params.name || params.text;
    },
    templateSelection: function(params) {
        return params.name || params.text;
    },
    escapeMarkup: function(markup) {
        return markup;
    },
    ajax: {
        url: "city/get-city",
        dataType: "json",
        global: false,
        cache: true,
        delay: 0,
        data: function(params) {
            return {
                search: params.term
            };
        },
        processResults: function(results, params) {
            // remove existing tag after key press
            var term = $.trim(params.term);
            //term = term.toLowerCase();
            var searchedTags = $.map(results, function(tag) {
                //tag = tag.toLowerCase();
                return {
                    id: tag.id,
                    text: tag.name
                };
            });
            return {
                results: searchedTags
            };
        } //end of process results
    } // end of ajax
})


$(document).ready(function () {

    url = hostname + "employee/get-data-emp";
    table = $("#master_emp").DataTable({
        processing: true,
        serverSide: true,
        order: [],
        searching: true,
        info: false,
        //"pagingType": "listbox",
        pagingType: "numbers",
        bLengthChange: false,
        bPaginate: true,
        bProcessing: false,
        language: {
            emptyTable: "Data tidak ada",
            zeroRecords: "0 data",
            paginate: {
                previous: "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                next: " <i class='fa fa-angle-right' aria-hidden='true'></i> ",
                first: "<i class='fa fa-angle-double-left' aria-hidden='true'></i> ",
                last: "<i class='fa fa-angle-double-right' aria-hidden='true'></i> ",
            },
        },
        dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',

        ajax: {
            url: url,
            type: "POST",
            data: function (data) {
                data.search = $("#search_uom").val();
            },
        },
        fnPreDrawCallback: function () {
            $("tbody").html("");
        },
        drawCallback: function (hasil) {
            var api = this.api();
            var records_displayed = api.page.info().recordsDisplay;
            $(".dataTables_paginate > ul.pagination").addClass(
                "pagination-rounded justify-content-end mb-2"
            );
        },
        columnDefs: [{
                targets: [0],
                orderable: true,
                class: "align-middle",
            },
            {
                targets: [1],
                orderable: true,
                class: "align-middle",
            },
            {
                targets: [2],
                orderable: true,
                class: "align-middle text-center",
            },
            {
                targets: [3],
                orderable: true,
                class: "align-middle text-center",
            },
            {
                targets: [4],
                orderable: true,
                class: "align-middle text-center",
            },
        ],

        dom: '<"top"l>rt<"bottom left"pi><"caption right"><"clear">',
    });

    $("#search_emp").keyup(function (event) {
        table.ajax.reload(null, false);
    });

    $("#form_emp").validate({
        rules: {
            nik: {
                required: true,
            },
            full_name: {
                required: true,
            },
            jenis_kelamin: {
                required: true,
            },
            city: {
                required: true,
            },
            start_date: {
                required: true
            }
        },
        messages: {
            nik: "Nik harus diisi.",
            full_name: "Nama Lengkap harus diisi.",
            jenis_kelamin: "Jenis Kelamin harus diisi.",
            city: "Kota Kelahiran harus diisi.",
            start_date: "Tanggal lahir harus diisi."
        },
        errorElement: "small",
        errorPlacement: function (error, element) {
            var placement = $(element).data("error");
            error.insertAfter(element);
        },
        submitHandler: function (form, event) {
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: hostname + "employee/add_emp",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (data) {
                    $(".loading").removeClass("d-none");
                },
                success: function (data) {
                    var parse = JSON.parse(data);
                    if (parse.status == true) {
                        Swal.fire("Success", "Data berasil diperbarui", "success");
                        table.ajax.reload(null, false);
                        $("#form_emp").trigger("reset");
                        $('.city').empty();
                        $("#modalAddEmp").modal("hide");
                    } else {
                        Swal.fire("Failed", "Data gagal diperbarui "+ parse.message, "error");
                    }
                },
                complete: function (data) {
                    $(".loading").addClass("d-none");
                },
            });
        },
    });

    $("#form_emp_bulk").validate({
        rules: {
            file: {
                required: true,
            }
        },
        messages: {
            file: "File harus diisi.",
        },
        errorElement: "small",
        errorPlacement: function (error, element) {
            var placement = $(element).data("error");
            error.insertAfter(element);
        },
        submitHandler: function (form, event) {
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: hostname + "employee/import_data",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (data) {
                    $(".loading").removeClass("d-none");
                },
                success: function (data) {
                    var parse = JSON.parse(data);
                    if (parse.status == true) {
                        Swal.fire("Success", "Data berasil diperbarui", "success");
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire("Failed", "Data gagal diperbarui "+ parse.message, "error");
                    }
                },
                complete: function (data) {
                    $(".loading").addClass("d-none");
                },
            });
        },
    })

    $(document).on("click", ".btn-inactive-emp", function (e) {
        let id = $(this).attr("data-id");

        titleData = "Yakin mendelete data ini?";
        textData =
            "Apabila data ini didelete, maka emp akan di hapus dari sistem.";


        Swal.fire({
            title: titleData,
            text: textData,
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            cancelButtonText: "Batal",
            confirmButtonText: "Ya",
        }).then(function (t) {
            if (t.value) {
                $.ajax({
                    type: "POST",
                    url: hostname + "employee/delete/"+id,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        var parse = JSON.parse(data);
                        if (parse.status == true) {
                            Swal.fire("Success", "Data berasil diperbarui", "success");
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire("Failed", "Data gagal diperbarui", "error");
                        }
                    },
                });
            }
        });
    });
});

$(document).on("click", ".btn-update-emp", function () {
    let id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: hostname + "employee/get-detail-emp",
        data: {
            id: id
        },
        dataType: "json",
        success: function (data) {
            $('#_id_nik').val(data.nik)
            $('#_nik').val(data.nik);
            $('#_full_name').val(data.emp_fullname);
            $('#_called_name').val(data.emp_called);
            $('#_jenis_kelamin').val(data.emp_sex).trigger('change');
            $('#_start_date').val(data.emp_dob)
            $('#city_update').select2({
                width: "100%",
                dropdownParent: $("#modalUpdateEmp"),
                tags: false,
                multiple: false,
                placeholder: data.name,
                maximumSelectionSize: 12,
                minimumInputLength: 2,
                createTag: function(params) {
                    // empty string is not allow
                    var term = $.trim(params.term);
                    if (term === "") {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                    };
                },
                templateResult: function(params) {
                    return params.name || params.text;
                },
                templateSelection: function(params) {
                    return params.name || params.text;
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                ajax: {
                    url: "city/get-city",
                    dataType: "json",
                    global: false,
                    cache: true,
                    delay: 0,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(results, params) {
                        // remove existing tag after key press
                        var term = $.trim(params.term);
                        //term = term.toLowerCase();
                        var searchedTags = $.map(results, function(tag) {
                            //tag = tag.toLowerCase();
                            return {
                                id: tag.id,
                                text: tag.name
                            };
                        });
                        return {
                            results: searchedTags
                        };
                    } //end of process results
                } // end of ajax
            })
            $('#city_update').val(data.emp_bop).trigger('change')
            $("#modalUpdateEmp").modal("show");
        },
    });

    $("#form_update_emp").validate({
        rules: {
            full_name: {
                required: true,
            },
            jenis_kelamin: {
                required: true,
            },
            start_date: {
                required: true
            }
        },
        messages: {
            full_name: "Nama Lengkap harus diisi.",
            jenis_kelamin: "Jenis Kelamin harus diisi.",
            start_date: "Tanggal lahir harus diisi."
        },
        errorElement: "small",
        errorPlacement: function (error, element) {
            var placement = $(element).data("error");
            error.insertAfter(element);
        },
        submitHandler: function (form, event) {
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: hostname + "employee/update-emp",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function (data) {
                    $(".loading").removeClass("d-none");
                },
                success: function (data) {
                    var parse = JSON.parse(data);
                    if (parse.status == true) {
                        Swal.fire("Success", "Data berasil diperbarui", "success");
                        table.ajax.reload(null, false);
                        $('#city').empty()
                        $("#modalUpdateUom").modal("hide");
                    } else {
                        console.log(parse);
                        Swal.fire("Failed", "Data gagal diperbarui "+ parse.message, "error");
                    }
                },
                complete: function (data) {
                    $(".loading").addClass("d-none");
                },
            });
        },
    });
});
