<?PHP
# Copyright 2009, University of Alberta
#
# This file is part of WASSAIL
#
# WASSAIL is free software: you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free 
# Software Foundation, either version 2 of the License, or (at your option) 
# any later version.

# WASSAIL is distributed in the hope that it will be useful, but WITHOUT ANY 
# WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
# FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more 
# details.

# You should have received a copy of the GNU General Public License along 
# with WASSAIL.  If not, see <http://www.gnu.org/licenses/>.

/** Note **
 * Database credentials are stored in the dbi.php object to remove them 
 * from any global namespace
 *********/


/****
 * Installation config
 * Defines where on your server WASSAIL is installed.
 * By default, WASSAIL assumes it is installed at the document root of the 
 * current domain.  For example, if the document root is
 * /srv/www/htdocs/, WASSAIL will automatically use that. If you have 
 * installed WASSAIL in a subdirectory, describe that below.  
 *
 * For example, if you have installed WASSAIL to run in the /wassail/ 
 * subdirectory, and therefore is accessible through 
 * https://yourdomain.com/wassail/, then change the $subdir = '/' line below 
 * to read:
 * 
 * $subdir = '/wassail/';
 *
 * IMPORTANT: This must end in a slash or all sorts of problems will happen
 *
 * IMPORTANT: If this changes, you will need to uncomment and modify the RewriteBase directive
 * at the top of the .htaccess file.  Notice that this value does NOT have a trailing slash
 * ie: RewriteBase /wassail
 *
 * You will also need to update the ErrorDocument directive to reflect the changed path to the 404 document
 */

$subdir = '/';

$doc_root = rtrim($_SERVER['DOCUMENT_ROOT'],'/');
define('INSTALL_DIR',$doc_root.$subdir);
define('WEB_PATH',$subdir);



/*****
 * Email
 * Note: This didn't get as integrated as I'd planned - 
 * only used in a couple places
 */
define('SYSADMIN_EMAIL','root@localhost');
define('EMAIL_INFO',1);
define('EMAIL_ERROR',2);

/*****
 * Feedback
 */
define('FEEDBACK_ENABLED',TRUE);
/* To make the feedback URL a mail link, replace the url below with
 * mailto:youremail@yoursite.com
 */
define('FEEDBACK_URL','https://docs.google.com/a/ualberta.ca/forms/d/1Nq06kOZCUJxRaeEM9cX7T9oBa3cmn4E3dkzdoK7Vs6Q/viewform');

/*****
 * Date
 */
define('DATE_FORMAT_LONG','l M jS, Y');
define('DATE_FORMAT_SHORT','d/m/y');


/* The default delimiter between question tags */
define('TAG_DELIMITER',',');

/* Help images */
define('WEB_HELP_IMAGE_DIR',WEB_PATH.'include/helpimages/');
define('HELP_IMAGE_DIR',$_SERVER['DOCUMENT_ROOT'].WEB_HELP_IMAGE_DIR);
define('MAX_THUMB_WIDTH',100);
define('MAX_THUMB_HEIGHT',100);

/* Respondent password properties */
define('RESPONDENT_PASSWORD_LENGTH',8);
define('RESPONDENT_PASSWORD_CHARACTERS','abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789');


/*****
 * Responses
 * Note: The keys for these arrays are important as they are the IDs of the 
 * terms & types.  The order of elements can be changed, but the keys must 
 * move with the values.
 * -1 is a reserved key - don't use it.
 */

/*****
 * Importing 
 */

/* Must end in a slash '/' */
define('UPLOAD_DIR',realpath(INSTALL_DIR.'../uploads/').'/');

/* Uploaded import files longer than EXPIRY_TIME seconds ago, will be deleted 
 * when new files are imported 
*/
define('UPLOAD_EXPIRY_TIME',86400);


// Whenever these are displayed, this array isn't used, as the order of display
// has changed from this order, so the terms need to be manually output
global $QUESTIONNAIRE_TERMS;
$QUESTIONNAIRE_TERMS = array(0=>'Spring',
						     1=>'Summer',
						     2=>'Fall',
						     3=>'Winter');
global $QUESTIONNAIRE_TYPES;
$QUESTIONNAIRE_TYPES = array(0=>'Pre-test',
			     1=>'Post-test',
			     2=>'One shot',
			     3=>'Survey');

/*****
 * Editing
 */
//note: This is only for the web form intro & question text.  Qualitative responses are run through HTMLPurifier because
//we need to be a lot more careful.  If you need to update which tags are allowed in qualitative responses, look in
//include/classes/responsequestion.php
define('ALLOWED_TAGS','<strong><u><em><sup><sub><strike><p><font><br><span><blockquote><a><div><img>');
global $LIKERT;
$LIKERT = array(0=>array('title'=>'Agree-disagree',
			 'values'=>array('Strongly disagree',
					 'Disagree',
					 'Agree',
					 'Strongly agree')),
		1=>array('title'=>'Frequency (Never, Often, etc)',
			 'values'=>array('Never',
					 'Seldom',
					 'Sometimes',
					 'Often')),
		2=>array('title'=>'Evaluation (Poor, Good, etc)',
			 'values'=>array('Poor',
					 'Fair',
					 'Good',
					 'Outstanding')),
		3=>array('title'=>'True/False',
			 'values'=>array('True',
					 'False')));

global $COMMON_ANSWERS;
$COMMON_ANSWERS = array('I am not sure',
			'I do not know',
			'I prefer not to answer',
			'Not applicable');
?>