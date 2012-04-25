<div class="component">

	<button id="add-contact-btn" class="header-btn add-btn">Add Contact</button>
	
	<h2>Property Contacts</h2>
	
	<p id="no-contacts">No contacts have been added for this property.</p>
	
	<table id="contacts-table" class="sort-table">
	
		<tr>
			<th><a href="#" class="sort-link sort-active" direction="asc">Contact</a></th>
			<th><a href="#" class="sort-link">Type</a></th>
			<th><a href="#" class="sort-link">Mobile</a></th>
			<th><a href="#" class="sort-link">Home</a></th>
			<th><a href="#" class="sort-link">Business</a></th>
			<th></th>
		</tr>
	
	</table>

</div>

<table style="display: none;">
	<tr id="contacts-row-template">
		<td>#{last_name}, #{first_name}</td>
		<td>#{type}</td>
		<td>#{mobile_phone}</td>
		<td>#{home_phone}</td>
		<td>#{business_phone}</td>
		<td>
			<a href="#" class="view" onClick="return ContactsTable.view(#{contact_id});" title="View Contact"></a>
			<a href="#" class="update" onClick="return ContactsTable.update(#{contact_id});" title="Update Contact"></a>
			<a href="#" class="delete" onClick="return ContactsTable.remove(#{contact_id});" title="Delete Contact"></a>
		</td>
	</tr>
</table>

<script>

	$('add-contact-btn').observe('click', function(e)
	{
		e.stop();
		var params = {
			'do': 'add-contact-form',
			'property_id': <?=$property_id?>
		}
		Lightbox.get('/cmpt/PropertyContactsComponent', 'GET', params);
	});

	var ContactsTableClass = Class.create({

		message: $('no-contacts'),
		rows: false,
		table: $('contacts-table'),
		
		initialize: function(rows)
		{
			var _this = this;
			
			this.rows = rows;
			this.checkEmpty();

			this.rows.each(function(row)
			{
				var tpl = new Template(_this.rowTemplate);
				var el = new Element('tr', {id: 'contact-' + row.contact_id}).update(tpl.evaluate(row));
				_this.table.insert(el);
			});
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

		addRow: function(contact)
		{
			var tpl = new Template(this.rowTemplate);
			var el = new Element('tr', {id: 'contact-' + contact.contact_id}).update(tpl.evaluate(contact));
			this.table.insert(el);
			this.rows.push(contact);
			this.checkEmpty();
		},

		//----------------------------------------------------------------

		update: function(contact_id)
		{
			Lightbox.get('/cmpt/PropertyContactsComponent', 'GET', {'do': 'update-form', 'contact_id': contact_id});
			return false;
		},

		//----------------------------------------------------------------

		updateRow: function(contact)
		{
			var tpl = new Template(this.rowTemplate);
			var el = new Element('tr', {id: 'contact-' + contact.contact_id}).update(tpl.evaluate(contact));
			$('contact-' + contact.contact_id).replace(el);
		},

		//----------------------------------------------------------------

		remove: function(contact_id)
		{
			Lightbox.get('/cmpt/PropertyContactsComponent', 'GET', {'do': 'delete-confirmation', 'contact_id': contact_id});
			return false;
		},

		//----------------------------------------------------------------

		removeRow: function(contact_id)
		{
			var idx = 0;
			this.rows.each(function(row, index)
			{
				if(row.contact_id == contact_id) idx = index;
			});
			this.rows.splice(idx, 1);

			$('contact-' + contact_id).remove();
			this.checkEmpty();
		},

		//----------------------------------------------------------------

		view: function(contact_id)
		{
			Lightbox.get('/cmpt/PropertyContactsComponent', 'GET', {'do': 'view-contact', 'contact_id': contact_id});
		},

		//----------------------------------------------------------------

		rowTemplate: $('contacts-row-template').innerHTML
	
	});

	var ContactsTable = new ContactsTableClass(<?=json_encode($rows)?>);

	var SortContacts = new TableSorter('contacts-table');

</script>