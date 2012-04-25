<h2><?=$title?> Hazmat</h2>

<ul id="hazmat-form-errors" style="display: none;"></ul>

<div style="display: none;">
	<div id="hazmat-form-error-1">Please provide a name for this chemical</div>
	<div id="hazmat-form-error-2">There is no property ID number. Please reload the form and try again.</div>
</div>

<form id="hazmat-form">

	<input type="hidden" id="hazmat-id" name="hazmat_id" value="<?=$hazmat_id?>" />
	<input type="hidden" id="property-id" name="property_id" value="<?=$property_id?>" />
	<input type="hidden" id="do" name="do" value="update" />

	<table>
	
		<tr>
			<td>Chemical Name:</td>
			<td><input type="text" id="name" name="name" value="<?=$name?>" /></td>
		</tr>
		
		<tr>
			<td>Location:</td>
			<td><input type="text" id="location" name="location" value="<?=$location?>" /></td>
		</tr>
		
		<tr>
			<td>Quanitity:</td>
			<td>
				<input type="text" id="quantity" name="quantity" value="<?=$quantity?>" />
				<select id="quantity-unit-id" name="quantity_unit_id">
					<option value="0"></option>
					<?	foreach($quantity_unit_options as $option): ?>
						<option value="<?=$option['value']?>" <?=$option['selected']?>><?=$option['label']?></option>
					<?	endforeach; ?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Flammable:</td>
			<td><input type="checkbox" id="flammable" name="flammable" value="1" <?=$flammable?> /></td>
		</tr>
		
		<tr>
			<td>Toxic:</td>
			<td><input type="checkbox" id="toxic" name="toxic" value="1" <?=$toxic?> /></td>
		</tr>
		
		<tr>
			<td>Oxidizer:</td>
			<td><input type="checkbox" id="oxidizer" name="oxidizer" value="1" <?=$oxidizer?> /></td>
		</tr>
		
		<tr>
			<td>Corrosive:</td>
			<td><input type="checkbox" id="corrosize" name="corrosive" value="1" <?=$corrosive?> /></td>
		</tr>
		
		<tr>
			<td>UN Number:</td>
			<td><input type="text" id="un_number" name="un_number" value="<?=$un_number?>" /></td>
		</tr>
		
		<tr>
			<td>Guide Number:</td>
			<td><input type="text" id="guide_number" name="guide_number" value="<?=$guide_number?>" /></td>
		</tr>
		
		<tr>
			<td>NFPA Fire Rating:</td>
			<td><input type="text" id="nfpa_fire" name="nfpa_fire" value="<?=$nfpa_fire?>" /></td>
		</tr>
		
		<tr>
			<td>NFPA Health Rating:</td>
			<td><input type="text" id="nfpa_health" name="nfpa_health" value="<?=$nfpa_health?>" /></td>
		</tr>
		
		<tr>
			<td>NFPA Reactivity Rating:</td>
			<td><input type="text" id="nfpa_reactivity" name="nfpa_reactivity" value="<?=$nfpa_reactivity?>" /></td>
		</tr>
		
		<tr>
			<td>NFPA Special Code:</td>
			<td>
				<select name="nfpa_special_type_id">
					<option value="0"></option>
					<?	foreach($nfpa_special_type_options as $option): ?>
						<option value="<?=$option['value']?>" <?=$option['selected']?>><?=$option['label']?></option>
					<?	endforeach; ?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td></td>
			<td><input type="submit" value="<?=$title?>" /></td>
		</tr>
	
	</table>
</form>

<script>

	var v = new Validator('hazmat-form');
	v.addEmptyCheck('name', {code: 1, classes: {element: 'name', classes: 'input-problem'}});
	v.addEmptyCheck('property-id', {code: 2});

	$('hazmat-form').observe('submit', function(e)
	{
		e.stop();

		var result = v.process();

		if(!result.pass) return;

		var params = this.serialize(true);

		App.onSuccess = function(response)
		{
			switch(response.data.type)
			{
				case 'add':
					var hazmat = response.data.hazmat;
					HazmatsTable.addRow(hazmat);
					Lightbox.close();
					break;

				case 'update':
					var hazmat = response.data.hazmat;
					HazmatsTable.updateRow(hazmat);
					Lightbox.close();
					break;
			}
		}

		App.onFailure = function(response)
		{
			v.processFailure(response.data.result);
		}

		App.request('/cmpt/PropertyHazmatsComponent/', 'POST', params);

	});

</script>