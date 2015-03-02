===================================================
 Plugin Name: nbspFix
 Author: Richard Davies (richard@richarddavies.us)
 Version: 1.0.2
===================================================

-------------
 DESCRIPTION
-------------

Due to the way Firefox treats &nbsp; entities inside textareas, when TinyMCE is loaded all
non-breaking spaces get converted to normal spaces. This plugin intercepts changes to the 
editor and modifies the editor's HTML so that the non-breaking spaces remain intact.

--------------
 INSTALLATION
--------------

1. Copy the nbspfix folder to your tinyMCE plugins directory.
2. Add the plugin "nbspfix" to the list of plugins in your tinyMCE init code:
		<script type="text/javascript">
			tinyMCE.init({
				mode : "textareas",
				theme : "advanced",
				plugins : "nbspfix"
			});
		</script>


-----------------
 VERSION HISTORY
-----------------

1.0.2
	* Bug fix: TinyMCE_nbspFixPlugin object missing semicolon causing error in editor_plugin.js.

1.0.1
	* Improvement: Now only 'fixes' &nbsp; entities once when editor is first loaded.
	* Bug fix: Editor reverts back to original contents when TinyMCE's 'cleanup' button is clicked.
	
1.0
	* Initial version.