<div class="component">

	<button id="add-hazmat-btn" class="header-btn add-btn">Add Hazmat</button>
	
	<h2>Property Hazmats</h2>
	
	<p id="no-hazmats">No hazmats have been added for this property.</p>
	
	<table id="hazmats-table" class="sort-table">
	
		<tr>
			<th><a href="#" class="sort-link sort-active" direction="asc">Chemical Name</a></th>
			<th><a href="#" class="sort-link">Quantity</a></th>
			<th><a href="#" class="sort-link">Flammable</a></th>
			<th><a href="#" class="sort-link">Toxic</a></th>
			<th><a href="#" class="sort-link">Oxidizer</a></th>
			<th><a href="#" class="sort-link">Corrosize</a></th>
			<th></th>
		</tr>
	
	</table>

</div>

<table style="display: none;">
	<tr id="hazmats-row-template">
		<td>#{name}</td>
		<td>#{quantity} #{quantity_unit}</td>
		<td>#{flammable}</td>
		<td>#{toxic}</td>
		<td>#{oxidizer}</td>
		<td>#{corrosive}</td>
		<td>
			<a href="#" class="view" onClick="return HazmatsTable.view(#{hazmat_id});" title="View Hazmat"></a>
			<a href="#" class="update" onClick="return HazmatsTable.update(#{hazmat_id});" title="Update Hazmat"></a>
			<a href="#" class="delete" onClick="return HazmatsTable.remove(#{hazmat_id});" title="Delete Hazmat"></a>
		</td>
	</tr>
</table>

<script>

	$('add-hazmat-btn').observe('click', function(e)
	{
		e.stop();
		var params = {
			'do': 'add',
			'property_id': <?=$property_id?>
		}
		Lightbox.get('/cmpt/PropertyHazmatsComponent', 'GET', params);
	});

	var HazmatsTableClass = Class.create({

		message: $('no-hazmats'),
		rows: false,
		table: $('hazmats-table'),
		
		initialize: function(rows)
		{
			var _this = this;
			
			this.rows = rows;
			this.checkEmpty();

			if(this.rows)
			{
				this.rows.each(function(row)
				{
					var tpl = new Template(_this.rowTemplate);
					var el = new Element('tr', {id: 'hazmat-' + row.hazmat_id}).update(tpl.evaluate(row));
					_this.table.insert(el);
				});
			}
		},

		checkEmpty: function()
		{
			if(!this.rows.length)
			{
				this.table.hide();
				this.message.show();
			}
			else
			{
				this.table.show();
				this.message.hide();
			}
		},

		addRow: function(hazmat)
		{
			var tpl = new Template(this.rowTemplate);
			var el = new Element('tr', {id: 'hazmat-' + hazmat.hazmat_id}).update(tpl.evaluate(hazmat));
			this.table.insert(el);
			this.rows.push(hazmat);
			this.checkEmpty();
		},

		//----------------------------------------------------------------

		update: function(hazmat_id)
		{
			Lightbox.get('/cmpt/PropertyHazmatsComponent', 'GET', {'do': 'update', 'hazmat_id': hazmat_id});
			return false;
		},

		//----------------------------------------------------------------

		updateRow: function(hazmat)
		{
			var tpl = new Template(this.rowTemplate);
			var el = new Element('tr', {id: 'hazmat-' + hazmat.hazmat_id}).update(tpl.evaluate(hazmat));
			$('hazmat-' + hazmat.hazmat_id).replace(el);
		},

		//----------------------------------------------------------------

		remove: function(hazmat_id)
		{
			Lightbox.get('/cmpt/PropertyHazmatsComponent', 'GET', {'do': 'delete', 'hazmat_id': hazmat_id});
			return false;
		},

		//----------------------------------------------------------------

		removeRow: function(hazmat_id)
		{
			var idx = 0;
			this.rows.each(function(row, index)
			{
				if(row.hazmat_id == hazmat_id) idx = index;
			});
			this.rows.splice(idx, 1);

			$('hazmat-' + hazmat_id).remove();
			this.checkEmpty();
		},

		//----------------------------------------------------------------

		view: function(hazmat_id)
		{
			Lightbox.get('/cmpt/PropertyHazmatsComponent', 'GET', {'do': 'details', 'hazmat_id': hazmat_id});
		},

		//----------------------------------------------------------------

		rowTemplate: $('hazmats-row-template').innerHTML
	
	});

	var HazmatsTable = new HazmatsTableClass(<?=json_encode($rows)?>);

	var SortHazmats = new TableSorter('hazmats-table');

</script>