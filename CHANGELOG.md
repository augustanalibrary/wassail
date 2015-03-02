[v3.2]
March 18, 2014
	- The system WASSAIL is developed on has been upgraded to Debian, and PHP version 5.4.4.  If possible, you should upgrade your PHP installation, though WASSAIL *should* still work on older versions
	- Renamed "include/config.inc" > "include/config.php" and "setup.inc" > "setup.php".  *.inc files can be loaded directly if their URL is known.  While no credentials were stored in these files, that is still a security risk.
		- New version will reference these new *.php files, not the old *.inc files, so if you have done any modification, you should rename your old *.inc files to *.php
	- When making a new online questionnaire, the "Template" pulldown now only shows the template ID once, and the "Course" pulldown now shows the course ID
	- When making a new online questionnaire, the "Year" defaults to the current academic year until April 30th.  On May 1st it defaults to the next academic year.
	- When making a new online questionnaire, the confirmation message can now be partially customized. The phrase about closing the browser window remains.
	- When filling out an online questionnaire with a file upload with a file that is too large, the error now gets displayed before the response gets submitted, to allow the respondent to change the file they're uploading.
	- When filling out an online questionnaire, the respondents responses now appear on the confirmation screen.
	- Users can now upload 1 to 5 files with one response.  This value can be set when creating a new online questionnaire.
	- Reports now have the template id and course id appear in their respective parameter boxes, when generating a report
	- When editing a template, question ids now appear in the list.
	- Reports now have the questions ordered by question id ascending
	- When creating a question, the "Tags" summary section now displays "NONE" when no tags have been entered
	- Questions page now has a "Templates" column that can toggle visibility of the templates in which a question is included (only visible to users with unconditional write permissions)
	- Questions page now has a "Stats" column that can toggle visibility of the years, terms, and combinitions thereof that the questions was asked (only visible to users with unconditional write permissions).  The values in this table are the number of responders in each category.
	- A "Feedback" button now appears at the top of every page, beside the Logout button.  This button is an email link for users to provide feedback or ask questions about WASSAIL.  The button can be enabled/disabled by a setting in config.php, as well as the address the link points to.
	- Each response set can now be printed.  A new window will appear that looks similar to the "Edit Response" window, except this window will contain multiple responses that you can print.
	- Editing response properties (ie: The template, course, term, etc associated with a response) is now possible for users with unconditional write permissions.  These users can edit the properties of a single response, or of an entire grouping of responses.
	- The username of the currently logged in user, and the name of the instance name now appear in the top right corner of the main window.
	- When generating reports, the templates are now listed by ID number from greatest to least (previously they were sorted alphabetically from a-z)
	- When creating/editing a question, tags now appear lowercased in the Summary section.  They were always lowercased when the question was saved, but the Summary preview now shows this.
	- When creating/editing a question, answers are now ordered 'a','b','c',etc. rather than 1,2,3,etc.
	- When creating/editing a question, the box containing the question text in the summary section now wraps when the text gets too wide.



[DB changes]
- Added `web_form`.`file_count` int NOT NULL DEFAULT 1 after `file_request`
- Renamed `response_id`.`filename` to `response_id`.`filenames` and changed to TEXT type
- Added `web_form`.`confirmation` text after `name`;




[v3.1]
September 11, 2012
	- WASSAIL now properly runs in a subdirectory
	- When printing, the footer now appears at the bottom of the last printed page
	- Gains Analysis parameter sets now display ID numbers for templates and courses
	- Online questionnaires / web forms can now be edited after being generated.  Only accounts with the "Write Unconditionally" right have this ability.
	- Responses to qualitative questions now have ids associated with answers
	- Modified styling of reports so quantitative and qualitative reports now look more similar
	
	
[v3.0]
November 10, 2010
	Reports/Gains Analysis:
		- Answer percentages are now calculated based on # of responses, not # of responders
March 25, 2010
	Questions:
		- Qualitative questions can now specify "opt out" text - the text that accompanies the checkbox. Leaving the text blank will remove the checkbox, effectively making the question required.
March 22, 2010
	Reports:
		- Responses now appear in the order they appear in the question, rather than numerically ordered by ID
		- When reporting on a single template, questions now appear in the order they appear in the template
		- Only qualitative answers that are part of a response that satisfies the required conditions are shown.  Previously, all qualitative answers in the requested templates would be shown.
	Responses & web forms:
		- A notice now appears informing the user that a course needs to be entered before responses or webforms can be created.
	Questions:
		- The RTE (Rich Text Editor) now has paragraph justification buttons	
March 15, 2010
	Web forms / Responses:
		- Provide option to allow user to upload a file with their response.
			- Provide a link to that file from the "Edit Response" window.
		- Long qualitative answers are now Rich Text capable.
			- Use HTMLPurifier (http://htmlpurifier.org) to clean incoming HTML.  When installing, you need to set include/HTMLPurifier/standalone/HTMLPurifier/DefinitionSchema to 0777
		
March 9, 2010
	Help:
		- Uploading & working with images is fixed.
		
	Reporting:
		- When reporting on a single template, Responses and Questions are now sorted in the order they appear in the template
		- Required answers are now joined with a Boolean AND, instead of OR.  The result is that any responses that appear must satisfy ALL required answers, not ANY.

March 5, 2010:
	Web form:
		- The URL for created web forms now displays the URL relative to the current installation, not hardcoded "https://wassail.augustana.ualberta.ca"...

March 3, 2010
	Web forms:
		- Forms can now be named, and the name will be used in the web form url instead of the form ID.  URL has changed to use /web/ rather than /form/.  /form/ still works.
		- Database structure has been updated to store the 'name' of a form.
	Config.inc:
		- Changed some constants.  Now have INSTALL_DIR to specify where on the server WASSAIL is stored, and WEB_PATH to define the web based root for WASSAIL.