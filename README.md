<h1>Welcome To CodeByrner!</h1>

CodeByrner is a small set of files added to the base CodeIgniter library, along with only one infintismal change to a standard CodeIgniter file.

<b>Whoa, a single change to a core CodeIgniter file? What gives? That sounds...bad.</b>

Yeah, I tried to avoid it. Tried all kinds of things to load the necessary files before your first controller was loaded, but as it turns out none of those methods either 1) worked, or 2) were in any way very clean or elegant. Now, updating a file in the CodeIgniter core is not exactly elegant either, but it was a small change to make the system work within with CodeIgniter's standard hooks system at just the right time. Using the hooks system allows greater control later, and I wanted to leave both you and I open to that.

<b>Ok...so what changed?</b>

Simple, all I did was add my own hook to the CodeIgniter.php file. It happens right after the system checks for a MY_Controller class and loads it if it finds it. This way CI_Controller and MY_Controller are loaded (and we need them to be), but the controller for the page being requested hasn't been loaded yet. I called it the pre_controller_load hook.

<b>You do know there's a pre_controller hook, right?</b>

Yes, I am aware. But as it turns out, that hook name is kind of a misnomer. The pre_controller hook happens before your controller is <i>instantiated</i>, not before it <i>loads</i>. This was an issue for me because the idea is to have your controllers extend the Page class, which has to extend the MY_Controller class. The Page class must then be loaded prior to loading the controller for the page you're looking for, but it has to load after MY_controller. If your controller extends the Page class, but the Page class hasn't loaded, an error will be thrown. If Page is loaded before the MY_Controller class, an error will also be thrown. So, I created my own hook, and I put it right in that sweet spot.

<b>Still sounds dubious</b>

Fair enough.