<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parser</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="dark">
<div id="form" class="form-wrapper">
    <form action="/" method="get">
        <fieldset>
            <label class="text">
                <span>What are we parsing? *</span>
                <div class="input-wrapper">
                    <input name="site" type="url" value="<?= !empty($params['site']) ? htmlspecialchars($params['site']) : ''; ?>"
                           placeholder="Enter site URL"/>
                    <div class="error"><?= $errors['site'] ?? ''; ?></div>
                </div>
            </label>
            <label class="text">
                <span>Count of levels. How deep collect urls?*</span>
                <div class="input-wrapper">
                    <input name="level" type="number"
                           min="0"
                           max="999"
                           value="<?= !empty($params['level']) && is_numeric($params['level']) ? htmlspecialchars($params['level']) : 1; ?>"
                           placeholder="Levels"/>
                    <div class="error"><?= $errors['level'] ?? ''; ?></div>
                </div>
            </label>
            <label class="text">
                <span>Output file name</span>
                <div class="input-wrapper">
                    <input name="file_name" type="text"
                           value="<?= !empty($params['file_name']) ? htmlspecialchars($params['file_name']) : ''; ?>"
                           placeholder="Enter output file name"/>
                </div>
            </label>
            <label>
                <span class="label">Output file format</span>
                <div class="input-wrapper">
                    <label class="radio" for="txt">
                        <input type="radio" name="file_format" checked value="txt" id="txt"/>
                        <span>Text format (.txt)</span>
                    </label>
                    <div class="error"><?= $errors['file_format'] ?? ''; ?></div>
                </div>
                <div class="input-wrapper">
                    <label class="radio" for="csv">
                        <input type="radio" name="file_format" value="csv" id="csv"/>
                        <span>CSV format (.csv)</span>
                    </label>
                </div>
            </label>
        </fieldset>
        <!--
		<label class="dropdown">
			<span>Dropdown</span>
			<div class="input-wrapper">
				<select size="1">
					<option>-- Please choose --</option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
				</select>
			</div>
		</label>

		<label class="multiple">
			<span>Multiple</span>
			<div class="input-wrapper">
				<select class="multiple" size="3">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
				</select>
			</div>
		</label>

		<label class="text">
			<span>Some more information and also a label with a lot of text. So resize your browser and see whats happening...</span>
			<div class="input-wrapper">
				<textarea>Write, some text here  </textarea>
			</div>
		</label>
			-->
        <!--<fieldset class="radio-check-label">
			<span class="label">Do you like this?</span>

			<div class="input-wrapper">
				<label class="radio" for="yes">
					<input type="radio" name="foo" value="yes" id="yes"/>
					<span>Yes, please</span>
				</label>
			</div>

			<div class="input-wrapper">
				<label class="radio" for="no">
					<input type="radio" name="foo" value="no" id="no"/>
					<span>No, thanks</span>
				</label>
			</div>

			<div class="input-wrapper">
				<label class="radio" for="maybe" for="maybe">
					<input type="radio" name="foo" value="maybe" id="maybe"/>
					<span>Well, maybe</span>
				</label>
			</div>
		</fieldset>-->

        <!--<fieldset class="radio-check-label">
			<span class="label">Please check all</span>
			<div class="input-wrapper">
				<label class="checkbox" for="accept">
					<input type="checkbox" name="accept" id="accept"/>
					<span>Okay, I accept all u want</span>
				</label>
			</div>

			<div class="input-wrapper">
				<label class="checkbox" for="spam">
					<input type="checkbox" name="spam" id="spam"/>
					<span>Yes, send me all your spam.</span>
				</label>
			</div>

			<div class="input-wrapper">
				<label class="checkbox" for="toolbars">
					<input type="checkbox" name="toolbars" id="toolbars"/>
					<span>Install 1000 toolbars and add all available plugins to my browser</span>
				</label>

			</div>
		</fieldset>-->


        <input type="submit" name="submit" value="Submit"/>
        <input type="reset" name="reset" value="Reset"/>
    </form>
    <div class="clear"></div>
</div>


</body>
</html>