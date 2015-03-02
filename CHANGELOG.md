#3.3
* Moved code to Github
* Changed documentation files to Markdown.  Reading them in a Markdown reader, or on Github will provide formatting.

#### General
* Login page adjusted to look better on laptops and smaller screens
* The username and instance you are logged in with/to will now appear in the top right corner.
* A `Feedback` button has been added beside the `Logout` button.  By default the button takes the user to an Augustana Library feedback form.
  * Added configuration value to enable/disable the `Feedback` button.
  * Added configuration value to change the URL the `Feedback` button points to.

#### Reports
* Now have the respective IDs displayed in the `Template(s)` and `Course(s)` boxes.
* Are now sorted by question id.
* The order of terms has been changed to "Fall","Winter","Spring",'Summer

#### Questions
* A new column was added to show in which Templates a question is asked.  This column is only visible to users with `unconditional write` access.
* A new column was added to show how often a question is asked by year and term.  This column is only visible to users with `unconditional write` access
  * _These two new columns require a lot more work to be done by WASSAIL when generating the page.  As a result, users with `unconditional write` access will notice this page takes longer to load than in the past._
* Column headers are now repeated every 10 questions
* When creating/editing a question:
  * The word "NONE" now appears in the "Tags" summary section, if no tags exist for the question.
  * Answers are now listed with _a,b,c,d,etc._ rather than _1,2,3,4,etc._
  * Textfields for entering possible answer text have been widened.
  * Question text now wraps in the summary box. **Note:** The text may or may not wrap at the same place here, in the editor, or when viewing the question in an online questionnaire.
  * Tags now appear lowercase in the summary box.

#### Gains Analysis
* Updated the `Gains Analysis` page to use square brackets around IDs.
* The `Type(s)` checkboxes are now auto-checked.
* The order of terms has been changed to "Fall","Winter","Spring",'Summer

#### Courses
* The `Courses` tab is now renamed `Courses/Events` to reflect the broadened use of WASSAIL.
  * The modal box that appears when creating a new Course/Event has also had its wording updated.

#### Templates
* When editing the questions in a template, the icon / list item number spacing has been fixed in Chrome.
* When editing the questions in a template, the question ID is now displayed.

#### Online questionnaire
* `Template` ID now only displays once
* `Course` ID now displays
* The `Year` dropdown now defaults to the current academic year.  The Academic year in this case is considered to be May 1 - April 30.
* Online questionnaires can now have an optionally customized rich-text confirmation message.
* After a user has submitted their responses, the confirmation screen now displays the questions and user-provided answers that were submitted.
* The order of terms has been changed to "Fall","Winter","Spring",'Summer
* For questionnaires that allow a file upload, the user is informed of the maximum allowed filesize.  This size is retrieved from the configuration of the server WASSAIL is installed from, so it will accurately represent the limitations on the installed server.

#### Responses
* When viewing a list of responses, there is now a Printer icon that, when clicked, will generate a page of all responses, formatted for printing.
* When editing/viewing a response:
  * "correct" answers are now tabulated.  At the bottom of the page, you will now see how many questions were marked as having a correct answer, the number of _those_ questions that were answered correctly, and the corresponding percentage of correct answers.  For example: **Correct:** 6 / 24 (25%)
  * Files can now be uploaded.
  * "Edit" button renamed to "Save and close"
* The `Template`, `Course`, `Term`, `Type` and `Year` of existing responses can now be edited by users with `unconditional write` privileges - but only for questionnaires that have expired.  All responses in a grouping can be edited at once, as well as individual responses.
* When adding new responses, the order of terms has been changed to "Fall","Winter","Spring",'Summer


**Content below this line was historically not entered as Markdown, so formatting may be off**

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