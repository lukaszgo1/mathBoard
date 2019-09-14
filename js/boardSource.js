var boardName = document.title;
function getUpdatedContent()
	{
	$.ajax(
		{
		type: "post",
		url: "../php/boardGetContent.php",
		data: 
			{
			boardName: boardName
			},
		cache: false,
		success: function(response)
			{
			if (response != $("pre").html())
				{
				$("pre").html(response);
				window.setTimeout(getUpdatedContent, 10000);
				}
			}
		});
			}
		window.onload = function()
		{
		window.setTimeout(getUpdatedContent, 10000);
		}