$(document).ready(function(){
	getHistory();
	bindEvents();
});

var bindEvents = function(){
	$('#formText').submit(sendData);	
	
}, bindList = function(){
	$('a.inputItem').on('click', function(){
		var data = {id : $(this).attr('id-attr')}
		ajaxMod.doAjaxRequest({
			data: data,
			url: 'home/get-input',
			noModal : false,
			callback : function(rsp){
				if(rsp.status == 1){
					$("#textIn").val(rsp.obj.textIn);
					$("#textOut").val(rsp.obj.textOut);
				}
			}
		});
	});
},sendData = function(eve){
	eve.preventDefault();
	var data = $(this).serializeFormJSON();
	data.textInput = $.trim(data.textInput);
	if(!$.trim(data.textInput))
		return false;
	ajaxMod.doAjaxRequest({
		data : data,
		callback : function(rsp){
			if(rsp.status == 1){
				var testsCase = rsp.obj.usercases;
				var text = "";
				if(rsp.obj.passed){
					$.each(testsCase, function(index, item){
						if(item.result != "")
							text += item.result;
					});
				}else{
					text = rsp.obj.outMessage;
				}
				getHistory();
			}
		},
		url: 'home/process-data',
		noModal : false
	});
},getHistory = function(){	
	ajaxMod.doAjaxRequest({
		callback : function(rsp){
			var list = $("#consultasList");
			if(rsp.status == 1 ){
				list.empty();
				$.each(rsp.obj,function(index, item){
					var inputItem = $("<a/>").addClass('inputItem').addClass('list-group-item').css('height','2.5em');
					inputItem.attr('id-attr',item.id);
					inputItem.append('<span class="badge">'+item.usercases.length+'</span>');
					inputItem.append('<h6><b> '+item.id+' </b>'+item.outMessage+'</h6>')
					if(item.passed)
						inputItem.addClass('list-group-item-success');
					else
						inputItem.addClass('list-group-item-danger');
					list.append(inputItem);
				});
			}
			bindList();
		},
		url: 'home/get-history-list',
		noModal : true
	});
};