<!--
Copyright (c) 2007 John Dyer (http://johndyer.name)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
-->

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<title>Color Picker</title>
	<style type="text/css">
	body, td {
		font-family: tahoma;
		font-size: 10pt;
	}
	body, form {
		margin: 0; padding: 0;
	}
	body {
		padding-top: 8px;
	}
	</style>
	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="imagetoolbar" content="false">
	<script type="text/javascript" src="refresh_web/prototype.js" ></script>
	<script type="text/javascript" src="refresh_web/colorpicker/colormethods.js" ></script>
	<script type="text/javascript" src="refresh_web/colorpicker/colorvaluepicker.js" ></script>
	<script type="text/javascript" src="refresh_web/colorpicker/slider.js" ></script>
	<script type="text/javascript" src="refresh_web/colorpicker/colorpicker.js" ></script>
	<script type="text/javascript">
	
	function SetColor() {
		if (parent && parent.SetColor) {
			cp1.updateVisuals();
			parent.SetColor(cp1.color.hex);
		}
	}
	
	function ClosePicker() {
		if (parent && parent.ClosePicker) {
			parent.ClosePicker();
		}
	}
	
	</script>

</head>
<body>
	<form method="GET" action="" onSubmit="return false;">
	<table border="0" cellspacing="4" cellpadding="0" align="center">
		<tr>
			<td valign="top" style="width: 256px height: 256px;">
				<div id="cp1_ColorMap"></div>
			</td>
			
			<td valign="top">
				<div id="cp1_ColorBar"></div>
			</td>

			<td valign="top">
				<table border="0" cellspacing="2" cellpadding="0">
					<tr>
						<td colspan="3" align="center">
							<div id="cp1_Preview" style="background-color: #fff; width: 60px; height: 60px; padding: 0; margin: 0; border: solid 1px #000;">
								<br />
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type="radio" id="cp1_HueRadio" name="cp1_Mode" value="0" />
						</td>
						<td>
							<label for="cp1_HueRadio">H:</label>
						</td>
						<td>
							<input type="text" id="cp1_Hue" value="0" style="width: 40px;" /> &deg;
						</td>
					</tr>

					<tr>
						<td>
							<input type="radio" id="cp1_SaturationRadio" name="cp1_Mode" value="1" />
						</td>
						<td>
							<label for="cp1_SaturationRadio">S:</label>
						</td>
						<td>
							<input type="text" id="cp1_Saturation" value="100" style="width: 40px;" /> %
						</td>
					</tr>

					<tr>
						<td>
							<input type="radio" id="cp1_BrightnessRadio" name="cp1_Mode" value="2" />
						</td>
						<td>
							<label for="cp1_BrightnessRadio">B:</label>
						</td>
						<td>
							<input type="text" id="cp1_Brightness" value="100" style="width: 40px;" /> %
						</td>
					</tr>

					<tr>
						<td colspan="3" height="5">

						</td>
					</tr>

					<tr>
						<td>
							<input type="radio" id="cp1_RedRadio" name="cp1_Mode" value="r" />
						</td>
						<td>
							<label for="cp1_RedRadio">R:</label>
						</td>
						<td>
							<input type="text" id="cp1_Red" value="255" style="width: 40px;" />
						</td>
					</tr>

					<tr>
						<td>
							<input type="radio" id="cp1_GreenRadio" name="cp1_Mode" value="g" />
						</td>
						<td>
							<label for="cp1_GreenRadio">G:</label>
						</td>
						<td>
							<input type="text" id="cp1_Green" value="0" style="width: 40px;" />
						</td>
					</tr>

					<tr>
						<td>
							<input type="radio" id="cp1_BlueRadio" name="cp1_Mode" value="b" />
						</td>
						<td>
							<label for="cp1_BlueRadio">B:</label>
						</td>
						<td>
							<input type="text" id="cp1_Blue" value="0" style="width: 40px;" />
						</td>
					</tr>


					<tr>
						<td>
							#:
						</td>
						<td colspan="2">
							<input type="text" id="cp1_Hex" value="FF0000" style="width: 60px;" />
						</td>
					</tr>

				</table>
			</td>
		</tr>
		<tr>
			<td valign="top"><input type="button" value="Set Color" onClick="SetColor()"> <input name="Button" type="button" value="Cancel" onClick="ClosePicker()"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	</form>
	

<div style="display:none;">
	<img src="refresh_web/colorpicker/images/rangearrows.gif" />
	<img src="refresh_web/colorpicker/images/mappoint.gif" />
	
	<img src="refresh_web/colorpicker/images/bar-saturation.png" />
	<img src="refresh_web/colorpicker/images/bar-brightness.png" />
	
	<img src="refresh_web/colorpicker/images/bar-blue-tl.png" />
	<img src="refresh_web/colorpicker/images/bar-blue-tr.png" />
	<img src="refresh_web/colorpicker/images/bar-blue-bl.png" />
	<img src="refresh_web/colorpicker/images/bar-blue-br.png" />
	<img src="refresh_web/colorpicker/images/bar-red-tl.png" />
	<img src="refresh_web/colorpicker/images/bar-red-tr.png" />
	<img src="refresh_web/colorpicker/images/bar-red-bl.png" />
	<img src="refresh_web/colorpicker/images/bar-red-br.png" />	
	<img src="refresh_web/colorpicker/images/bar-green-tl.png" />
	<img src="refresh_web/colorpicker/images/bar-green-tr.png" />
	<img src="refresh_web/colorpicker/images/bar-green-bl.png" />
	<img src="refresh_web/colorpicker/images/bar-green-br.png" />
	
	<img src="refresh_web/colorpicker/images/map-red-max.png" />
	<img src="refresh_web/colorpicker/images/map-red-min.png" />
	<img src="refresh_web/colorpicker/images/map-green-max.png" />
	<img src="refresh_web/colorpicker/images/map-green-min.png" />
	<img src="refresh_web/colorpicker/images/map-blue-max.png" />
	<img src="refresh_web/colorpicker/images/map-blue-min.png" />
	
	<img src="refresh_web/colorpicker/images/map-saturation.png" />
	<img src="refresh_web/colorpicker/images/map-saturation-overlay.png" />
	<img src="refresh_web/colorpicker/images/map-brightness.png" />
	<img src="refresh_web/colorpicker/images/map-hue.png" />
</div>

<script type="text/javascript">

Event.observe(window,'load',function() {
	cp1 = new Refresh.Web.ColorPicker('cp1',{startHex: '<?php
	
	if (isset($_GET['color'])) {
		echo str_replace("#", "", $_GET['color']);
	}
	else {
		echo "FFFFFF";
	}
	
	?>', startMode:'s'});
});

</script>
</body>
</html>