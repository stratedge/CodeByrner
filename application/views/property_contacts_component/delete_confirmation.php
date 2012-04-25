<h2>Delete Contact</h2>

<p>Are you sure you wish to remove <?=$first_name?> <?=$last_name?> as a contact for this property? Deleting this contact cannot be undone.</p>

<button id="delete-confirm-btn">Delete Contact</button>

<script>

	$('delete-confirm-btn').observe('click', function(e)
	{
		e.stop();

		App.onSuccess = function(response)
		{
			ContactsTable.removeRow(<?=$contact_id?>);
			Lightbox.close();
		}

		App.request('/cmpt/PropertyContactsComponent', 'POST', {'do': 'delete', 'contact_id': <?=$contact_id?>});

	});

</script>