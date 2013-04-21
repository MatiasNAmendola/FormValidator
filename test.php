<html>
<head>
<basefont face="Arial">
</head>
<body>
<form action="processor.php" method="POST">
<b>Name:</b>
<br>
<input type="text" name="name" size="15">
<p>
<b>Name 2:</b>
<br>
<input type="text" name="nameb" size="15">
</p>
<p>
<b>Age:</b>
<br>
<input type="text" name="age" size="2" maxlength="2">
<p>
<b>Sex:</b>
<br>
<input type="Radio" name="sex" value="m">Male
<input type="Radio" name="sex" value="f">Female
<p>
<b>Favourite sandwich type:</b>
<br>
<select name="stype">
<option value="">-select one-</option>
<option value="1">Thin crust</option>
<option value="2">Thick crust</option>
<option value="3">Toasted</option>
</select>
<p>
<b>Favourite sandwich filling:</b>
<br>
<input type="Checkbox" name="sfill[]" value="BLT">Bacon, lettuce tomato
<input type="Checkbox" name="sfill[]" value="EC">Egg and cheese <input
type="Checkbox" name="sfill[]" value="PBJ">Peanut butter and jelly
<p>
<input type="Submit" name="submit" value="Save">
</form>
</body>
</html>