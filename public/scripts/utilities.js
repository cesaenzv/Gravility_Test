var ajaxMod = (function () {
    var url, type, sync = false;
    var modalShow= function(){
        $("#myModal").modal('show');
    },modalHide=function(){
        $("#myModal").modal('hide');
    },doAjaxRequest = function (att) {
        if (att.data == undefined)
            att.data = {};
        if(!att.noModal)
            modalShow();   

        att.data._token = $('meta[name="csrf-token"]').attr('content'); 

        $.ajax({
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            type: 'POST',
            async: false,
            url: att.url,
            data: JSON.stringify(att.data),
            success: function (rsp) {
                if(!att.noModal)
                    modalHide();       
                if(att.callback != undefined)
                    att.callback(rsp);
                else
                    return rsp;
            },
            error:function(data){
                if(!att.noModal)
                    modalHide();
            }
        });
    };
    return {
        doAjaxRequest : doAjaxRequest,
        modalShow : modalShow,
        modalHide : modalHide
    }
})();
