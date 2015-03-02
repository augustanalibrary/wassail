/**
 * $Id: editor_plugin_src.js $
 *
 * @author Richard Davies
 */

var TinyMCE_nbspFixPlugin = {
	
	/**
	 * Flag to track if content has already been 'fixed'. The cleanup function will get called many
	 * times, but it only needs to fix the nbsp entities on the first run.
	 */
	fixed : false,
	
	/**
	 * Returns information about the plugin as a name/value array.
	 * The current keys are longname, author, authorurl, infourl and version.
	 *
	 * @returns Name/value array containing information about the plugin.
	 * @type Array 
	 */
	getInfo : function() {
		return {
			longname : '&nbsp fix',
			author : 'Richard Davies',
			authorurl : 'http://www.richarddavies.us',
			infourl : 'http://www.richarddavies.us',
			version : "1.0.2"
		};
	},

	/**
	 * Gets called when HTML contents is inserted or retrived from a TinyMCE editor instance.
	 * The type parameter contains what type of event that was performed and what format the content is in.
	 * Possible valuses for type is get_from_editor, insert_to_editor, get_from_editor_dom, insert_to_editor_dom.
	 *
	 * @param {string} type Cleanup event type.
	 * @param {mixed} content Editor contents that gets inserted/extracted can be a string or DOM element.
	 * @param {TinyMCE_Control} inst TinyMCE editor instance control that performes the cleanup.
	 * @return New content or the input content depending on action.
	 * @type string
	 */
	cleanup : function(type, content, inst) {
		/**
		 * Due to the way Firefox treats &nbsp; entities inside textareas, when TinyMCE is loaded all
		 * non-breaking spaces get converted to normal spaces. This function intercepts changes to the 
		 * editor and modifies the editor's HTML so that the non-breaking spaces remain intact.
		 */
		if (!this.fixed && type == "insert_to_editor") {
			if (tinyMCE.isGecko && !tinyMCE.isSafari) {
				this.fixed = true;
				inst.formElement.innerHTML = inst.formElement.innerHTML.replace(/&nbsp;/gi, "&amp;nbsp;");
				return inst.formElement.defaultValue;
			}
			this.fixed = true;
		}
		return content;
	}
};


// Adds the plugin class to the list of available TinyMCE plugins
tinyMCE.addPlugin("nbspfix", TinyMCE_nbspFixPlugin);