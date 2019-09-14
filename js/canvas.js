var text = "";
var direction = "";

function performAnimation(curWidth, canvasHeight)
	{
	cnv.clearRect(0, 0, curWidth, canvasHeight);
	cnv.globalAlpha = 1;
	cnv.fillStyle = '#6c757d';
	cnv.fillRect(0, 0, curWidth, canvasHeight);
	var metrics = cnv.measureText(text);
	var textWidth = metrics.width;
	if (direction == "right")
		{
		textXpos += 5;
		if (textXpos > curWidth - textWidth)
			{
			direction = "left";
			}
		}
		else
			{
			textXpos -= 10;
			if (textXpos < 10)
				{
				direction = "right";
				}
			}
cnv.font = "18pt sans-serif";
cnv.fillStyle = '#FFFFFF';
cnv.textBaseline = 'top';
cnv.fillText  ( text, textXpos, 15);    
}    

function init () 
	{
	canvasHeight = 50;
	curWidth = screen.width;
	canvas = document.getElementById("canvas");
	// set width of the Canvas to the width of the screen
	canvas.width = curWidth;
	canvas.height = canvasHeight;
	cnv=canvas.getContext("2d");
	setInterval("performAnimation(curWidth, canvasHeight)", 200);
	direction = "right";
	textXpos = 5;
	text = "Math Board";
	}

init()