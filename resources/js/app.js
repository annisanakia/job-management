(function($) { 
    const swalDeleteButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-outline-danger px-3 ms-2',
            cancelButton: 'btn btn-outline-secondary px-3'
        },
        buttonsStyling: false
    })
    window.swalDeleteButtons = swalDeleteButtons;
    
    const swalSaveButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-outline-success px-3 ms-2',
            cancelButton: 'btn btn-outline-secondary px-3'
        },
        buttonsStyling: false
    })
    window.swalSaveButtons = swalSaveButtons;
    
    const swalToast = Swal.mixin({
        position: "bottom-end",
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 4000,
        toast: true
    })
    window.swalToast = swalToast;

    function getData(url, target, data = {}, is_loader = true, skeleton){
        if(target == '' || target == undefined){
            target = '#container';
        }

        if(skeleton == '' || skeleton == undefined){
            skeleton = '#skeleton';
        }

        if(is_loader){
            var html_skeleton = $(skeleton).html();
            if(html_skeleton == '' || html_skeleton == undefined){
                $(target).append('<div class="loading d-flex justify-content-center align-items-center"><img src="'+assetImg+'/loader.gif" width="70px"/></div>');
            }else{
                $(target).html(html_skeleton);
            }
        }
    
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            success: function(data) { 
                $(target).html(data);
                $('.selectpicker').selectpicker('refresh');

                $('.btn-loading').removeAttr('disabled');
            },
            error: function (e) {
                $('.btn-loading').removeAttr('disabled');
                var message = e.responseJSON? e.responseJSON.message : '';
                var message_error = 'Something Wrong';
                if (message == 'Unauthenticated.') {
                    message_error = 'Unauthenticated';
                }
                swalDeleteButtons.fire(
                    'Warning !',
                    message_error,
                    'error'
                ).then((result) => {
                    if (result.isConfirmed && message == 'Unauthenticated.') {
                        location.reload();
                    }
                });
            }
        });
    }
    window.getData = getData;

    function postData(url, target, data = {}, is_loader = true){
        if(target == '' || target == undefined){
            target = '#container';
        }

        if(is_loader){
            $(target).append('<div class="loading d-flex justify-content-center align-items-center"><img src="'+assetImg+'/loader.gif" width="70px"/></div>');
        }
    
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(data) { 
                $(target).html(data);
                $('.selectpicker').selectpicker('refresh');
                
                $('.btn-loading').removeAttr('disabled');
            },
            error: function (e) {
                $('.btn-loading').removeAttr('disabled');
                swalDeleteButtons.fire(
                    'Warning !',
                    'Something Wrong',
                    'error'
                )
            }
        });
    }
    window.postData = postData;

    function getFilter($this){
        var value = $this.val().toLowerCase(),
            target = $this.attr('data-target'),
            countTrue = 0,
            status = false;

        if(target == '' || target == undefined){
            target = '.item';
        }

        $(target+':not(.empty)').filter(function() {
            status = $(this).find('.filterText').text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(status);
            countTrue += (status == true) ? 1 : 0;
        });

        if(countTrue <= 0){
            $(target+'.empty').toggle(true);
        }else{
            $(target+'.empty').toggle(false);
        }
    }
    window.getFilter = getFilter;

    function getLoader($this){
        if($this.hasClass("btn-loading")){
            $this.attr('disabled', true)
            $this.html("<i class='fas fa-circle-notch fa-spin'></i>");
        }
    }
    window.getLoader = getLoader;
})(jQuery)

$("a.btn-loading").on('click', function(){
    var disabled = $(this).attr('disabled');
    if (typeof disabled !== 'undefined' && disabled !== false) {
        return false;
    }

    $(this).attr('disabled', true);
    $(this).html("<i class='fas fa-circle-notch fa-spin'></i>");
});

$(".delete-list").on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var $this = $(this),
        href = $this.attr('href'),
        name = $this.attr('data-name');

    var title_delete = 'Are you sure delete data "'+name+'"?';
    if(name == '' || name == undefined){
        var title_delete = 'Are you sure delete this data?';
    }

    swalDeleteButtons.fire({
        title: title_delete,
        text: "Data that has been deleted cannot be restored and will delete all the relationship data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: href,
                data: {},
                type: 'POST',
                success: function (data) {
                    if(data.status_failed == 1){
                        swalDeleteButtons.fire(
                            'Delete Failed !!',
                            data.message,
                            'error'
                        )
                    }else{
                        swalDeleteButtons.fire(
                            'Data deleted!',
                            'Data deleted successfully.',
                            'success'
                        ).then(function() {
                            if ($(".page-item.active")[0]){
                                $(".page-item.active .page-link").click();
                            } else {
                                $this.closest("form").submit();
                            }
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swalDeleteButtons.fire(
                        'Warning !',
                        'Something Wrong',
                        'error'
                    )
                }
            });
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {}
    })
});

$(".delete").on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var $this = $(this),
        href = $this.attr('href'),
        name = $this.attr('data-name');

    var title_delete = 'Are you sure delete data "'+name+'"?';
    if(name == '' || name == undefined){
        var title_delete = 'Are you sure delete this data?';
    }

    swalDeleteButtons.fire({
        title: title_delete,
        text: "Data that has been deleted cannot be restored and will delete all the relationship data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: href,
                data: {},
                type: 'POST',
                success: function (data) {
                    if(data.status_failed == 1){
                        swalDeleteButtons.fire(
                            'Delete Failed !!',
                            data.message,
                            'error'
                        )
                    }else{
                        swalDeleteButtons.fire(
                            'Data deleted!',
                            'Data deleted successfully.',
                            'success'
                        ).then(function() {
                            window.location.reload(true);
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swalDeleteButtons.fire(
                        'Warning !',
                        'Something Wrong',
                        'error'
                    )
                }
            });
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {}
    })
});

$(".delete-data").on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var $this = $(this),
        href = $this.attr('href'),
        target = $this.attr('data-target');

    if(target == '' || target == undefined){
        target = '#container';
    }

    swalDeleteButtons.fire({
        title: 'Are you sure delete this data?',
        text: "Data that has been deleted cannot be restored",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: href,
                data: {},
                type: 'POST',
                success: function (data) {
                    if(data.status_failed == 1){
                        swalDeleteButtons.fire(
                            'Delete Failed !!',
                            data.message,
                            'error'
                        )
                    }else{
                        swalDeleteButtons.fire(
                            'Data deleted!',
                            'Data deleted successfully.',
                            'success'
                        ).then(function() {
                            $(target).html(data);
                        });
                    }
                },
                error: function(e) {
                    swalDeleteButtons.fire(
                        'Warning !',
                        'Something Wrong',
                        'error'
                    )
                }
            });
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {}
    })
});

$('#change-switch').on('click', '.group-switch', function (e) {
    if ($(this).hasClass('disabled')) {
        $(this).removeClass('disabled');
        $(this).parent('tr').find('.access').removeAttr('disabled');
        $(this).parent('tr').find('.text-input').removeAttr('disabled');
    } else {
        $(this).addClass('disabled');
        $(this).parent('tr').find('.access').attr('disabled', true);
        $(this).parent('tr').find('.text-input').attr('disabled', true);
    }
});

$("form:not(.form-validation-ajax)").submit(function (e) {
    getLoader($(this).find('button[type="submit"]'));
});

$(".form-validation-ajax:not(.order-link)").submit(function (e) {
    getLoader($(this).find('button[type="submit"]'));
});

$(".form-validation-ajax").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var url = $(this).attr('action'),
        target = $(this).attr('data-target'),
        data = $(this).serialize(),
        skeleton = $(this).attr('data-skeleton');
    getData(url, target, data, true, skeleton);
});

$(".form-validation-ajax .page-link").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var url = $(this).attr('href'),
        target = $('.form-validation-ajax').attr('data-target'),
        data = $('.form-validation-ajax').serialize(),
        skeleton = $('.form-validation-ajax').attr('data-skeleton');
    getData(url, target, data, true, skeleton);
});

$(".form-validation-ajax .order-link").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var url = $(this).attr('href'),
        target = $('.form-validation-ajax').attr('data-target'),
        data = $('.form-validation-ajax :not(.order-input)').serialize(),
        skeleton = $('.form-validation-ajax').attr('data-skeleton');
    getData(url, target, data, true, skeleton);
});

$(".button-collapse").on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var id = $(this).attr('data-id');
    var url = $(this).attr('href');
    var target = '.detail_list_'+id;
    if($(this).find('i').hasClass('fas fa-plus')){
        $(this).find('i').removeClass('fas fa-plus');
        $(this).find('i').addClass('fas fa-minus');

        $.ajax({
            url: url,
            type: 'GET',
            data: {},
            success: function(data) { 
                $(target).html(data);
            },
            error: function (e) {
                $('.btn-loading').removeAttr('disabled');
                var message = e.responseJSON? e.responseJSON.message : '';
                var message_error = 'Something Wrong';
                if (message == 'Unauthenticated.') {
                    message_error = 'Unauthenticated';
                }
                swalDeleteButtons.fire(
                    'Warning !',
                    message_error,
                    'error'
                ).then((result) => {
                    if (result.isConfirmed && message == 'Unauthenticated.') {
                        location.reload();
                    }
                });
            }
        });
    }else{
        $(this).find('i').removeClass('fas fa-minus');
        $(this).find('i').addClass('fas fa-plus');
        $(target).html('');
    }
});

$(".form-ajax-post").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var url = $(this).attr('action'),
        target = $(this).attr('data-target'),
        data = new FormData(this);
    postData(url, target, data);
});

$(".nav-process .tab-list").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var url = $(this).attr('data-href'),
        target = $(this).attr('data-target'),
        id = $(this).attr('data-id'),
        skeleton = $(this).attr('data-skeleton'),
        data = {id: id};

    if(id != ''){
        getData(url, target, data, true, skeleton);
    }
});

$(".nav-button-tab .tab-list").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var url = $(this).attr('data-href'),
        target = $(this).attr('data-target'),
        skeleton = $(this).attr('data-skeleton');

    getData(url, target, {}, true, skeleton);
});

$(".ajax-link").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    
    var url = $(this).attr('data-href'),
        target = $(this).attr('data-target'),
        status_form = $(this).attr('data-form'),
        skeleton = $(this).attr('data-skeleton');

    var data = {};
    if(status_form == 'true'){
        var data = $(this).closest('.form-ajax-link').serialize();
    }

    getData(url, target, data, true, skeleton);
});

$(".remove-list").click(function (e) {
    $(this).closest('tr').remove();
});

$(".checkbox-group").click(function (e) {
    $('.checkbox').not(this).prop('checked', this.checked);
});

$('.filterInput').on('keyup', function(e) {
    e.stopPropagation();
    e.stopImmediatePropagation();
    getFilter($(this));
});

$(".btn-submit-check").click(function (e) {
    var modal = $(this).closest('.modal');
    if (modal.find('.checkbox:checked').length === 0) {
        swalToast.fire(
            'Warning !',
            'Please checklist at least one data before submitting',
            'error'
        )
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    }else{
        modal.modal('toggle');
    }
});

$(".btn-fullscreen").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var target = $(this).attr('data-target');
    if(target == '' || target == undefined){
        target = '#container';
    }

    $(target).toggleClass("fullscreen");
    $(target).toggleClass("overflow-scroll");
    $('.main-header').toggleClass("position-static");
    $('.sidebar').toggleClass("d-none");
    $('.nav-button-tab').toggleClass("d-none");
    $('.logo-header').toggleClass("position-static");
    $('.footer').toggleClass("position-static");
    $('.sidebar-wrapper.scrollbar.scrollbar-inner').toggleClass("position-static");
    $('.main-panel').toggleClass("height-unset");
    $(this).find('i').toggleClass("fa-expand");
    $(this).find('i').toggleClass("fa-compress");
});