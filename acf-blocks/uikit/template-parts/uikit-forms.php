<?php
/**
 * Template part: UI Kit forms.
 * Parent block: UI Kit
 *
 * Displays common form elements.
 *
 * @package Eternia
 */

namespace eternia;

?>
<section class="uikit__forms" id="uikit-forms">
	<form>
		<div class="form-group">
			<label for="text">Tekstikenttä</label>
			<input type="text" id="text" name="text" placeholder="Text input">
		</div>
		<div class="form-group">
			<label for="textarea">Tekstialue</label>
			<textarea id="textarea" name="textarea" placeholder="Textarea"></textarea>
		</div>
		<div class="form-group">
			<label for="select">Valitse vaihtoehto</label>
			<select id="select" name="select">
				<option value="option1">Kissat</option>
				<option value="option2">Koirat</option>
				<option value="option3">Undulaatit</option>
			</select>
		</div>
		<div class="form-group">
			<label>Multiselect</label><br>

			<input type="checkbox" id="first" name="first" value="first">
			<label for="first">Ensimmäinen</label><br>
			
			<input type="checkbox" id="second" name="second" value="second">
			<label for="second">Toinen</label><br>

		</div>
		<div class="form-group">
			<label>Radio</label><br>

			<input type="radio" id="dogs" name="radio" value="Dogs">
			<label for="dogs">Koirat</label><br>

			<input type="radio" id="cats" name="radio" value="Cats">
			<label for="cats">Kissat</label><br>
		</div>

		<input type="submit" value="Submit">
	</form>
</section>