<h2>Add Contact</h2>

<ul id="add-contact-form-errors"></ul>

<form id="add-contact-form">
	<input type="hidden" name="do" value="add-contact" />
	<input type="hidden" name="property_id" value="<?=$property_id?>" />
	<table>
	
		<tr>
			<td>First Name:</td>
			<td><input type="text" id="first-name" name="first_name" /></td>
		</tr>
		
		<tr>
			<td>Last Name:</td>
			<td><input type="text" id="last-name" name="last_name" /></td>
		</tr>
		
		<tr>
			<td>Mobile Phone:</td>
			<td><input type="text" id="mobile-phone" name="mobile_phone" /></td>
		</tr>
		
		<tr>
			<td>Home Phone:</td>
			<td><input type="text" id="home-phone" name="home_phone" /></td>
		</tr>
		
		<tr>
			<td>Business Phone:</td>
			<td><input type="text" id="business-phone" name="business_phone" /></td>
		</tr>
		
		<tr>
			<td>Address 1:</td>
			<td><input type="text" id="address1" name="address1" value="<?=$address1?>" /></td>
		</tr>
		
		<tr>
			<td>Address 2:</td>
			<td><input type="text" id="address2" name="address2" value="<?=$address2?>" /></td>
		</tr>
		
		<tr>
			<td>City:</td>
			<td><input type="text" id="city" name="city" value="<?=$city?>" /></td>
		</tr>
		
		<tr>
			<td>State:</td>
			<td><input type="text" id="state" name="state" value="<?=$state?>" /></td>
		</tr>
		
		<tr>
			<td>Zip:</td>
			<td><input type="text" id="zip" name="zip" value="<?=$zip?>" /></td>
		</tr>
		
		<tr>
			<td>Email:</td>
			<td><input type="text" id="email" name="email" /></td>
		</tr>
		
		<tr>
			<td>Type:</td>
			<td>
				<select name="type" id="type">
					<option></option>
					<?	foreach($contact_types as $contact_type): ?>
						<option value="<?=$contact_type?>"><?=$contact_type?></option>
					<?	endforeach; ?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Notes:</td>
			<td><textarea id="notes" name="notes"></textarea></td>
		</tr>
		
		<tr>
			<td></td>
			<td><input type="submit" value="Add Contact" /></td>
		</tr>
	
	</table>

</form>

<div style="display: none;">
	<div id="add-contact-form-error-1">Please provide the contact's first name.</div>
	<div id="add-contact-form-error-2">Please provide the contact's last name.</div>
	<div id="add-contact-form-error-3">Please provide at least one phone number.</div>
	<div id="add-contact-form-error-4">There was a problem saving your contact, please try again.</div>
</div>

<script>

	var av = new Validator();
	av.addEmptyCheck('first-name', {code: 1, classes: {element: 'first-name', classes: 'input-problem'}});
	av.addEmptyCheck('last-name', {code: 2, classes: {element: 'last-name', classes: 'input-problem'}});
	av.addAnyCheck(['mobile-phone', 'home-phone', 'business-phone'], {code: 3, classes: {element: ['mobile-phone', 'home-phone', 'business-phone'], classes: 'input-problem'}})
	av.registerForm('add-contact-form');	

	$('add-contact-form').observe('submit', function(e)
	{
		e.stop();

		result = av.process();

		if(!result.pass) return;

		App.onSuccess = function(response)
		{
			var contact = response.data.contact;
			ContactsTable.addRow(contact);
			Lightbox.close();
		}

		App.onFailure = function(response)
		{
			av.processFailure(response.data.result);
		}

		var params = this.serialize(true);
		
		App.request('/cmpt/PropertyContactsComponent', 'POST', params);

	});
</script>