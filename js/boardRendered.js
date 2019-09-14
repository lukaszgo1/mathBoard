function swapContainers()
	{
	var visible = $(".rendered");
	var notVisible = $(".hiddenMathContainer");
	visible.attr('aria-hidden', 'true');
	visible.addClass('hiddenMathContainer');
	notVisible.removeClass('hiddenMathContainer');
	notVisible.addClass('rendered');
	notVisible.attr('aria-hidden', 'false');
	}

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
			if (response != $(".rendered").text())
				{
				$(".hiddenMathContainer").text(response);
				MathJax.Hub.Queue(["Typeset",MathJax.Hub, ".hiddenMathContainer"]);
				MathJax.Hub.Queue(swapContainers());
				window.setTimeout(getUpdatedContent, 10000);
				}
			}
		});
			}
		window.onload = function()
		{
		window.setTimeout(getUpdatedContent, 10000);
		}