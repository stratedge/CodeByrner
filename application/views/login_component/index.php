<div class="cmpt">
	<h1>Login</h1>
	<ul id="login-form-errors" class="error" style="display: none;">
	</ul>
	<form id="login-form" method="POST" action="/cmpt/LoginComponent">
		<input type="hidden" name="do" value="login" />
		<input type="hidden" name="<?=$token_name?>" value="<?=$token_hash?>" />
		<input type="hidden" name="tz_offset" value="" id="tz_offset" />
		<table>
			<tr>
				<td>Email Address</td>
				<td><input type="text" id="email" name="email" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" id="password" name="password" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" />
			</td>
		</table>
	</form>
	
	<div class="login-form-error-list" style="display: none;">
		<div id="login-form-error-1">You must provide an email address to login.</div>
		<div id="login-form-error-2">You must provide a password to login.</div>
		<div id="login-form-error-3">Your email address or password is incorrect. Please try again.</div>
	</div>
	
	<script>
	
		$(document).observe('dom:loaded', function(e)
		{
			var now = new Date();
			$('tz_offset').value = now.getTimezoneOffset()/60*-1;
		})
	
		var v = new Validator();

		v.addEmptyCheck('email', {code: 1, classes: {element: 'email', classes: 'input-problem'}});
		v.addEmptyCheck('password', {code: 2, classes: {element: 'password', classes: 'input-problem'}});

		v.registerForm('login-form');
		
		$('login-form').observe('submit', function(e)
		{
			e.stop();
			
			var result = v.process(false);
			
			if(result.pass)
			{
				params = $('login-form').serialize(true);
				params['do'] = 'try-login';

				App.onFailure = function(response)
				{
					v.processFailure(response.data.result);
				}
				
				App.request('/cmpt/LoginComponent', 'POST', params);
			}
		});

	</script>
</div>