<h2>Delete Hazmat</h2>

<p>Are you sure you wish to remove <?=$name?> as a hazmat for this property? Deleting this hazmat cannot be undone.</p>

<button id="delete-confirm-btn">Delete Hazmat</button>

<script>

	$('delete-confirm-btn').observe('click', function(e)
	{
		e.stop();

		App.onSuccess = function(response)
		{
			HazmatsTable.removeRow(<?=$hazmat_id?>);
			Lightbox.close();
		}

		App.request('/cmpt/PropertyHazmatsComponent', 'POST', {'do': 'delete', 'hazmat_id': <?=$hazmat_id?>});

	});

</script>