/*
	Admin.js controls basic user interaction in the authoring area
 */
$(document).ready(function() 
{
	// catch delete clicks and confirm delete	
	$('.delete').click(function(d)
	{
		d.preventDefault();
		var delete_link = $(this).attr('href');
		$("#dialog_delete").dialog(
			{
				title: 'Confirm Delete'
				,modal: true
				,buttons: [
					{
						text: 'Delete',
						click: function() { window.location.href = delete_link; }
					}
					,{
						text: 'cancel',
						click: function() { $(this).dialog("close"); }
					}
				]
			});
	});
	
	// set cancel button link
	$('.button_cancel').click(function()
	{
		scene_id = $(this).attr('scene_id');
		document.location.href='edit?scene_id='+scene_id;
	});
	
	// if messages div has content show in pop-up
	if (messages = $('#dialog_message'))
	{		
		if (messages.children('p').html()) /* && messages.children('p').html().length > 0)  */
		{
			//messages.css('display','block');
			$("#dialog_message").dialog(
					{ 
						title: 'Message'
						,buttons: [
					    {
					        text: 'Close',
					        click: function() { $(this).dialog("close"); }
					    }]
					});		
		}
	}
	
	//when the page loads fire these events to set up the form (if it exists)
	$('input[name=cell_ids]').focusout();
	$('input[name=cell_id]').focusout();
				
	// jQuery UI init
    $("#accordion").accordion({ collapsible: true, active: false, animated: false }); //autoHeight: true
    $("#tabs").tabs();
    
    // select tab (if tab param exists)
    params = getQueryParams();
    if (params['tab']) 
    {
		$("#tabs").tabs('select',params['tab']);
	}
});	

function getQueryParams()
{
	var items = new Array()
	var queryParamString = document.location.toString().split('?');
	if (queryParamString.length > 0)
	{
		if (queryParamString[1])
		{
			params = queryParamString[1].split('&');
			for(i=0;i<params.length;i++)
			{
				item = params[i].split('=');
				items[item[0]] = unescape(item[1]);
			}
		}
	}
	return items;
}	
