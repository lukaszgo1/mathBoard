var boardName = document.title.replace(" - editing", "");
function sendBoardContent()
	{
	$.ajax(
		{
		type: "post",
		url: "../php/boardUpdate.php",
		data: 
			{
			Content: $("textarea").val(),
			boardName: boardName
			},
		cache: false,
		success: function(response)
			{
			sendBoardContent();
			}
		});
			}
		window.onload = function()
		{
		window.setTimeout(sendBoardContent, 10000);
		}