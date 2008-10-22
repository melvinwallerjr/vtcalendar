<?php
$lang['encoding'] = 'ISO-8859-1';

// ================================== public interface =====================================

$lang['yes'] = 'Yes';
$lang['no'] = 'No';

$lang['upcoming'] = 'Upcoming';
$lang['day'] = 'Day';
$lang['week'] = 'Week';
$lang['month'] = 'Month';
$lang['search'] = 'Search';
$lang['update'] = 'Update';

// Little Calendar
$lang['lit_cal_sun'] = 'S';
$lang['lit_cal_mon'] = 'M';
$lang['lit_cal_tue'] = 'T';
$lang['lit_cal_wed'] = 'W';
$lang['lit_cal_thu'] = 'T';
$lang['lit_cal_fri'] = 'F';
$lang['lit_cal_sat'] = 'S';
$lang['lit_cal_week'] = 'Wk';

// Date Picker
$lang['jump_to'] = 'Jump to...';
$lang['today_is'] = 'Today is: ';

// Column Links
$lang['subscribe_download'] = 'Subscribe &amp; Download';
$lang['filter_events'] = 'Filter Events';

// Filter
$lang['showing_filtered_events'] = 'Showing only filtered events';

$lang['AM'] = 'AM';
$lang['am'] = 'am';
$lang['PM'] = 'PM';
$lang['pm'] = 'pm';

$lang['monday'] = 'Monday';
$lang['tuesday'] = 'Tuesday';
$lang['wednesday'] = 'Wednesday';
$lang['thursday'] = 'Thursday';
$lang['friday'] = 'Friday';
$lang['saturday'] = 'Saturday';
$lang['sunday'] = 'Sunday';

$lang['mon'] = 'Mon';
$lang['tue'] = 'Tue';
$lang['wed'] = 'Wed';
$lang['thu'] = 'Thu';
$lang['fri'] = 'Fri';
$lang['sat'] = 'Sat';
$lang['sun'] = 'Sun';

$lang['january'] = 'January';
$lang['february'] = 'February';
$lang['march'] = 'March';
$lang['april'] = 'April';
$lang['may'] = 'May';
$lang['june'] = 'June';
$lang['july'] = 'July';
$lang['august'] = 'August';
$lang['september'] = 'September';
$lang['october'] = 'October';
$lang['november'] = 'November';
$lang['december'] = 'December';

$lang['jan'] = 'Jan';
$lang['feb'] = 'Feb';
$lang['mar'] = 'Mar';
$lang['apr'] = 'Apr';
$lang['may_short'] = 'May';
$lang['jun'] = 'Jun';
$lang['jul'] = 'Jul';
$lang['aug'] = 'Aug';
$lang['sep'] = 'Sep';
$lang['oct'] = 'Oct';
$lang['nov'] = 'Nov';
$lang['dec'] = 'Dec';

// Next/Previous Links in All Views
$lang['previous_day'] = 'Previous Day';
$lang['next_day'] = 'Next Day';
$lang['previous_week'] = 'Previous Week';
$lang['next_week'] = 'Next Week';
$lang['previous_month'] = 'Previous Month';
$lang['next_month'] = 'Next Month';

// Day View
$lang['upcoming_page_header'] = 'Upcoming Events';
$lang['day_page_header'] = 'Day';
$lang['no_events'] = 'No events were found for this day.';
$lang['no_upcoming_events'] = 'No upcoming events were found.';
$lang['all_day'] = 'All Day';

//week view
$lang['week_page_header'] = 'Week';

//month view
$lang['month_page_header'] = 'Month';

//event view
$lang['event_page_header'] = 'Event';
$lang['to'] = 'to'; //3:00 pm to 4:00 pm
$lang['more_information'] = 'More information';
$lang['location'] = 'Location';
$lang['price'] = 'Price';
$lang['sponsor'] = 'Sponsor';
$lang['contact'] = 'Contact';

//search view
$lang['search_page_header'] = 'Search';
$lang['keyword'] = 'Keyword';
$lang['case_insensit'] = '(case-insensitive; e.g. reading day)';
$lang['starting_from'] = 'Starting from:';

//searchresults view
$lang['searchresults_page_header'] = 'Search Results';
$lang['search_results'] = 'Search Results';
$lang['back_to_prev_page'] = 'Back to previous page';
$lang['no_events_found'] = 'No events found';

//subscribe view
$lang['subscribe_page_header'] = 'Subscribe';

//filter view
$lang['filter_page_header'] = 'Filter';
$lang['select_categories'] = 'Select the event categories you would like events displayed for:';
$lang['select_unselect'] = 'Select/Unselect All';
$lang['apply_filter'] = 'Apply Filter';

// Subscribe & Download View
$lang['upcoming_events'] = 'Upcoming<br/>Events';
$lang['ways_to_subscribe'] = 'Ways to Subscribe &amp; Download';
$lang['rss_feed'] = 'RSS Feed';
$lang['subscribe'] = 'iCal Subscribe';
$lang['download'] = 'iCal Download';
$lang['copy_event_to_pda'] = 'copy this event into your personal desktop calendar';
$lang['subscribe_message'] = 'If you have a desktop calendar or PDA compatible with the iCalendar standard you
can subscribe to a calendar or download events. Currently the iCalendar standard
is fully supported by <a href="http://www.apple.com/ical/">Apple\'s iCal</a>, and the 
<a href="http://www.mozilla.org/projects/calendar/">Mozilla Calendar</a>.<br>
<br>
If your calendar software cannot subscribe to a whole category of events, you should
still be able to download individual events by clicking on the link 
&quot;'.$lang['copy_event_to_pda'].'&quot; which you will find
on each page that lists event details.';
$lang['whole_calendar'] = 'Entire calendar';

// Export View
$lang['rss_feed_title'] = 'Next 25 Upcoming Events';

// ================================== Login-protected interface =====================================

$lang['dberror_generic'] = 'A database error was encountered';
$lang['dberror_nosponsor'] = 'Error: The calendar does not seem to have any sponsors.';
$lang['sponsor_twin_asterisk_note'] = 'Note: The sponsor marked with a ** is the administrative sponsor of this calendar';

// Login Screen
$lang['update_page_header'] = 'Login';
$lang['login'] = 'Login';
$lang['user_id'] = 'User-ID';
$lang['password']='Password:';
$lang['new_user'] = 'Create New User';

// Update main menu
$lang['event_options_header'] = 'Event Options';
$lang['add_event_description'] = 'Add a new event to the calendar.';
$lang['manage_event_description'] = 'View events that have been submitted, and see if they have been approved.';
$lang['manage_template_description'] = 'Create templates to easily add new events with similar information.';

$lang['backup_header'] = 'Backup &amp; Restore';
$lang['export_events_description'] = 'Export events to a file you can save on your computer as a backup, or to transfer to another calendar.';
$lang['import_events_description'] = 'Import an XML file that contains events as a batch.';
$lang['change_homepage_description'] = 'Change the default homepage address that appears when adding new events.';
$lang['change_email_description'] = 'Change the default e-mail that appears when adding new events.';
$lang['options_for'] = 'Options for';
$lang['change_password_of_user_description'] = 'Change the password you use when logging in to the calendar.';

$lang['calendar_options'] = 'Calendar Options';
$lang['approve_reject_event_updates_description'] = 'Approve, edit or deny events that have been submitted by sponsors for this calendar.';
$lang['manage_sponsors_description'] = 'Sponsors are groups of users who submit under a common name, such as &quot;Chess Club&quot;.';
$lang['delete_inactive_sponsors_description'] = 'Automatically remove sponsors who have not submitted events in a specific amount of time.';
$lang['change_header_footer_auth_description'] = 'Change the header and footer HTML, as well as basic colors in the calendar. You can also change whether or not the calendar requires authentication for viewing the events.';
$lang['change_colors_description'] = 'Change the calendar colors to match your web site\'s design.';
$lang['manage_event_categories_description'] = 'Categories are used when a person wants to filter events on the calendar. All events must be assigned to one category.';
$lang['manage_search_keywords_description'] = 'Add, edit and remove keyword synonyms.';
$lang['manage_featured_search_keywords_description'] = 'When a &quot;Featured keyword&quot; is used in a search, a message automatically appears at the top of the search results.';
$lang['view_search_log_description'] = 'You can view a log of all the keywords searched here, which can be useful when you want to create keyword synonyms or featured keywords.';
$lang['manage_users_description'] = 'Add, edit and remove user accounts from the database.';
$lang['manage_calendars_description'] = 'Add, edit and remove calendars as well as set who has \'administrative\' access to the calendar.';
$lang['manage_main_admins_description'] = 'Add, edit and remove users who have full access to the entire calendar system.';
$lang['external_resources'] = 'The following are external links to various VTCalendar resources';
$lang['external_resources_docs'] = 'Documentation';
$lang['external_resources_announce'] = 'New Release Mailing List';
$lang['external_resources_forums'] = 'Forums';
$lang['external_resources_bugs'] = 'Report Bugs';
$lang['community'] = 'VTCalendar Community';
$lang['version_check'] = 'Version Check';

// Update interface
$lang['choose_template'] = 'Choose template';
$lang['blank'] = 'blank';
$lang['ok_button_text'] = '&nbsp;&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;&nbsp;';
$lang['cancel_button_text'] = 'Cancel';

$lang['edit_user'] = 'Edit user';
$lang['add_new_user'] = 'Add new user';
$lang['choose_user_id'] = 'Please choose a user-id.';
$lang['already_main_admin'] = 'This user is already a main admin.';
$lang['user_not_exists'] = 'This user does not exist.';
$lang['user_id_example'] = '(e.g. jsmith)';

$lang['add_new_event_category'] = 'Add new event category';
$lang['category_name_cannot_be_empty'] = 'The name cannot be empty.';
$lang['category_name_already_exists'] = 'This name already exist. Please choose a different one.';
$lang['category_name'] = 'Category name';

$lang['add_new_keyword_pair'] = 'Add new keyword pair';
$lang['add_new_keyword_pair_instructions'] = 'Do NOT add multiple words.<br> A keyword (or alternative keyword) cannot contain spaces.';
$lang['keyword_cannot_be_empty'] = 'The keyword cannot be empty.';
$lang['alternative_keyword'] = 'Alternative keyword:';

$lang['add_new_template'] = 'Add new template';

$lang['email_submitted_event_rejected'] = 'submitted event was rejected';
$lang['email_admin_rejected_event'] = 'The calendar administrator rejected the event:';
$lang['email_reason_for_rejection'] = 'Reason for the rejection:';
$lang['email_login_edit_resubmit'] = 'Please login to the calendar, edit and re-submit your event.';
$lang['approve_reject_event_updates'] = 'Approve/reject event updates';
$lang['back_to_menu'] = 'Back to Menu';
$lang['refresh_display'] = 'Refresh display';
$lang['approve_all_events'] = 'Approve ALL events';
$lang['date'] = 'Date';
$lang['time'] = 'Time';
$lang['category'] = 'Category';
$lang['categories'] = 'Categories';
$lang['title'] = 'Title';
$lang['description'] = 'Description';
$lang['approve'] = 'Approve';
$lang['reject'] = 'Reject';
$lang['edit'] = 'Edit';
$lang['user_ids_invalid'] = 'The following user-IDs are invalid:';
$lang['user_id_invalid'] = 'The following user-ID is invalid:';
$lang['change_header_footer_auth'] = 'Change header, footer, authorization settings';
$lang['change_colors'] = 'Change calendar colors';
$lang['calendar_title'] = 'Calendar Title';
$lang['empty_or_any_text'] = '(empty or any text)';
$lang['empty_or_any_html'] = '(empty or any HTML)';
$lang['header_html'] = 'Header HTML';
$lang['footer_html'] = 'Footer HTML';
$lang['forward_event_default'] = 'By default also display events on: ';
$lang['forward_event_default'] = 'By default also display events on: ';
$lang['forward_event_default_disable'] = '(Sponsors can still disable this on a per-event basis)';
$lang['separate_user_ids'] = '(put each user-id on a separate line)';
$lang['no_login_required'] = 'no login required; everyone can view the calendar';
$lang['login_required_user_ids'] = 'login required; only the following user-IDs can view the calendar';
$lang['login_required_any_login'] = 'login required; any successfully authenticated user can view';
$lang['login_required_for_viewing'] = 'Login required for viewing the calendar?';

$lang['save_changes'] = 'Save changes';
$lang['preview_event'] = 'Preview event';
$lang['go_back_to_make_changes'] = 'Go back to make changes';
$lang['warning_ending_time_before_starting_time'] = 'Warning! Ending time is not greater than starting time.';
$lang['warning_no_ending_time'] = 'Warning! The ending time is not specified.';
$lang['recurring_event'] = 'recurring event';
$lang['no_recurrences_defined'] = 'No recurrences defined.';
$lang['copy_event'] = 'Copy event';
$lang['update_event'] = 'Update event';
$lang['add_new_event'] = 'Add new event';
$lang['input_event_information'] = 'Input event information';

$lang['change_email'] = 'Change email address';
$lang['change_email_label'] = 'The email address you enter below will be used by the calendar administrator to send messages to you:';
$lang['email_invalid'] = 'The email address is invalid.';

$lang['change_homepage'] = 'Change homepage address';
$lang['change_homepage_label'] = 'Please enter the address of your organization\'s homepage:';
$lang['change_homepage_example'] = '(Make sure to enter the full URL including &quot;http://&quot;.)';
$lang['url_invalid'] = '"The URL is invalid. Please make sure that you enter: &quot;http://&quot; in front."';

$lang['email_account_updated_subject'] = 'calendar account information updated';
$lang['email_account_updated_body'] = "The calendar administrator updated the information for your user account.\n\nThe current settings are:\n";
$lang['email'] = 'E-Mail';

$lang['user_id_already_exists'] = 'A user with this Login ID already exists. Please choose a different one.';
$lang['choose_password'] = 'Please choose a password.';
$lang['email_example'] = '(e.g. jsmith@hotmail.com)';

$lang['change_password'] = 'Change password';
$lang['old_password'] = 'Old password:';
$lang['new_password'] = 'New password:';
$lang['password_repeated'] = '(repeated)';
$lang['old_password_wrong'] = 'The password you entered as the old one is wrong. Please try again.';
$lang['case_sensitive'] = '(case sensitive)';
$lang['two_passwords_dont_match'] = 'The two values you entered for the new password do not agree. Please try again.';
$lang['new_password_invalid'] = 'The new password is invalid.';

$lang['delete_calendar'] = 'Delete calendar';
$lang['warning_calendar_delete'] = 'Warning! The following calendar will be deleted:';

$lang['delete_event_category'] = 'Delete event category';
$lang['warning_event_category_delete'] = 'Warning! The following event category will be deleted:';
$lang['delete_all_events_in_category'] = 'delete all events in this category';
$lang['reassign_all_events_to_category'] = 're-assign all events in this category to:';

$lang['delete_event'] = 'Delete event';
$lang['delete_event_confirm'] = 'Do you really want to delete this event?';
$lang['button_delete_this_event'] = 'Delete this event';
$lang['button_delete_all_recurrences'] = 'Delete ALL recurrences of this event';

$lang['delete_inactive_sponsors'] = 'Delete inactive sponsors';
$lang['delete_inactive_sponsors_message'] = 'Delete all sponsors who do NOT had an event during the last';
$lang['delete_inactive_sponsors_year'] = 'year';
$lang['delete_inactive_sponsors_2years'] = '2 years';
$lang['delete_inactive_sponsors_3years'] = '3 years';

$lang['delete_main_admin'] = 'Delete main admin';
$lang['delete_main_admin_confirm'] = 'The following main admin will be deleted:';

$lang['clear_search_log'] = 'Clear search log';
$lang['clear_search_log_confirm'] = 'Do you want to delete the entire search log?';

$lang['delete_sponsor'] = 'Delete sponsor';
$lang['delete_sponsor_confirm'] = 'Warning! The following sponsor will be deleted:';
$lang['delete_all_events_of_sponsor'] = 'delete all events belonging to this sponsor';
$lang['reassign_all_events_to_sponsor'] = 're-assign all events belonging to this sponsor to:';

$lang['delete_user'] = 'Delete user';
$lang['delete_user_confirm'] = 'The following user will be deleted:';

$lang['calendar'] = 'Calendar';
$lang['default_sponsor_name'] = 'Administration';
$lang['category1'] = 'Category 1';
$lang['category2'] = 'Category 2';
$lang['category3'] = 'Category 3';

$lang['edit_calendar'] = 'Edit calendar';
$lang['add_new_calendar'] = 'Add new calendar';
$lang['calendar_id'] = 'Calendar-ID';
$lang['choose_valid_calendar_id'] = 'Please choose a valid calendar-ID:';
$lang['calendar_already_exists'] = 'A calendar with this ID already exists. Please choose a different one.';
$lang['calendar_id_example'] = '(e.g. mikadoclub)';
$lang['calendar_name'] = 'Calendar name';
$lang['calendar_name_example'] = '(e.g. Mikado Club)';
$lang['choose_valid_calendar_name'] = 'Please choose a valid name:';
$lang['administrators'] = 'Administrators:';
$lang['administrators_example'] = '(separate user-id\'s with a comma)';
$lang['also_display_on_calendar_message'] = 'By default also display events on the';
$lang['also_display_on_calendar_notice'] = '(Sponsors can still disable this on a per-event basis)';

$lang['edit_featured_keyword'] = 'Edit featured keyword';
$lang['add_new_featured_keyword'] = 'Add new featured keyword';
$lang['featured_keyword_message'] = 'Do NOT add multiple words. A keyword must not contain spaces.';
$lang['keyword_already_exists'] = 'This keyword already exists.';
$lang['featured_text'] = 'Featured Text (or HTML):';
$lang['featured_text_cannot_be_empty'] = 'The featured text cannot be empty.';

$lang['homepage'] = 'Homepage';
$lang['email_add_event_instructions'] = 'Short instructions for adding an event:
- Login using your personal user-ID and password
- Click on "Add new event"
- Fill in the fields
- Press the "Preview event" button
- If the preview looks ok, press the "Save changes" button

Your event is submitted to the calendar administrator
for review and will be publicized shortly.
';

$lang['edit_sponsor'] = 'Edit sponsor';
$lang['add_new_sponsor'] = 'Add new sponsor';
$lang['sponsor_name'] = 'Sponsor name:';
$lang['choose_sponsor_name'] = 'Please choose a name.';
$lang['sponsor_already_exists'] = 'A sponsor with this name already exists. Please choose a different one.';
$lang['sponsor_name_example'] = '(e.g. Mikado Club)';
$lang['choose_email'] = 'Please choose an email address.';
$lang['url_example'] = '(e.g. http://www.vtmc.vt.edu/)';
$lang['sponsor_members'] = 'Sponsor members:';
$lang['administrative_members'] = 'Administrative members:';
$lang['administrative_members_example'] = '(separate user-id\'s with a comma)';

// this is for VoiceXML output in export.php
$lang['vxml_welcome'] = 'Welcome to the VT Calendar!';
$lang['vxml_there_are'] = 'There are';
$lang['vxml_events_for_today'] = 'events for today';
$lang['vxml_no_more_events'] = 'There are no more events today';
$lang['vxml_goodbye'] = 'Have a nice day!';

$lang['export_events'] = 'Export events';
$lang['how_to_export_events'] = 'How do I export events?';
$lang['output_format'] = 'Output format:';
$lang['all'] = 'all';
$lang['specific_sponsor'] = 'specific sponsor';
$lang['specific_sponsor_example'] = '(case-insensitive substring search, e.g. school of the arts)';
$lang['from'] = 'from'; // from Feb 17, 2005...
$lang['export_message'] = 'Depending on your browser you might see an <b>empty screen</b> after pressing &quot;Start Export&quot;.<br> 
Use the &quot;<b>View Source</b>&quot; option of your browser to view the exported data.';

$lang['choose_sponsor_role'] = 'Choose your sponsor role';
$lang['error_not_authorized'] = 'Error! Not authorized.';
$lang['error_not_authorized_message'] = 'You are currently not authorized to update the calendar because you have not been assigned to an event sponsor.';
$lang['error_bad_sponsorid'] = 'You do not belong to the sponsor that you selected. Please select a sponsor from the list below.';
$lang['help_signup_link'] = 'Sign up with the calendar';
$lang['login_failed'] = 'Your login failed. Please try again.';
$lang['help'] = 'Help';
$lang['recurring'] = 'recurring';
$lang['on_the'] = 'on the';
$lang['last'] = 'last';
$lang['first'] = 'first';
$lang['second'] = 'second';
$lang['third'] = 'third';
$lang['fourth'] = 'fourth';
$lang['of_the_month_every'] = 'of the month every';
$lang['other_month'] = 'other month'; // meaning: every second month
$lang['months'] = 'months';
$lang['year'] = 'Year';
$lang['every'] = 'every';
$lang['every_other'] = 'every other';// meaning: every second ...
$lang['every_third'] = 'every third';
$lang['every_fourth'] = 'every fourth';
$lang['no_recurrences_defined'] = 'no recurrences defined.';
$lang['starting'] = 'starting:';
$lang['ending'] = 'ending:';
$lang['recurrence_produces_no_dates'] = '(The recurrence you have defined produces no dates!)';
$lang['resulting_dates_are'] = 'The resulting dates are:';
$lang['calendar_administration'] = 'Calendar administration';

$lang['phone'] = 'Phone';
$lang['for_more_info_visit'] = 'for more info visit the web at';

$lang['import_error_displayedsponsor'] = 'Error!: &lt;displayedsponsor&gt; is too long.';
$lang['import_error_displayedsponsorurl'] = 'Error!: &lt;displayedsponsorurl&gt; is invalid.';
$lang['import_error_timebegin'] = 'Error!: &lt;date&gt; and/or &lt;timebegin&gt; is invalid.';
$lang['import_error_timeend'] = 'Error!: &lt;date&gt; and/or &lt;timeend&gt; is invalid.';
$lang['import_error_categoryid'] = 'Error!: &lt;categoryid&gt; is invalid.';
$lang['import_error_title'] = 'Error!: &lt;title&gt; is invalid.';
$lang['import_error_description'] = 'Error!: &lt;description&gt; is invalid.';
$lang['import_error_location'] = 'Error!: &lt;location&gt; is invalid.';
$lang['import_error_price'] = 'Error!: &lt;price&gt; is invalid.';
$lang['import_error_contact_name'] = 'Error!: &lt;contact_name&gt; is invalid.';
$lang['import_error_contact_phone'] = 'Error!: &lt;contact_phone&gt; is invalid.';
$lang['import_error_contact_email'] = 'Error!: &lt;contact_email&gt; is invalid.';
$lang['import_error_contact_url'] = 'Error!: &lt;url&gt; is invalid.';
$lang['import_error_events'] = 'Error!: &lt;events&gt; must be the first element.';
$lang['import_events'] = 'Import events';
$lang['import_error_open_url'] = 'Error: Cannot open import file. Please check the URL.';
$lang['no_events_imported'] = 'No events were imported.';
$lang['import_file_contains_no_events'] = 'The import file does not contain any events.';
$lang['events_successfully_imported'] = 'events were successfully imported.'; // e.g. "34 events were successfully imported."
$lang['how_to_import'] = 'How do I import events?';
$lang['enter_import_url_message'] = 'Please enter the full URL of the XML file containing the events you want to add.';
$lang['enter_import_url_example'] = '(e.g. &quot;http://www.vtmc.vt.edu/rec/newevents.xml&quot;)';

$lang['repeat'] = 'repeat';
$lang['repeat_on_the'] = 'repeat on the';
$lang['specify_valid_ending_date'] = 'Please specify a valid ending date.';
$lang['specify_valid_dates'] = 'Please specify valid dates.';
$lang['specify_valid_starting_date'] = 'Please specify a valid starting date.';
$lang['ending_date_after_starting_date'] = 'The ending date must be equal or greater than the starting date.';
$lang['date_invalid'] = 'Date is invalid. Please change.';
$lang['one_time_event'] = 'one-time event';
$lang['specify_all_day_or_starting_time'] = 'Please specify &quot;All day event&quot; or a starting time.';
$lang['all_day_event'] = 'All day event';
$lang['timed_event'] = 'Timed event';
$lang['ending_time_not_required'] = '(ending time is NOT required)';
$lang['choose_category'] = 'Please choose a category.';
$lang['choose_title'] = 'Please choose a title.';
$lang['title_example'] = '(Please use a name meaningful to the general audience)';
$lang['description_example'] = '(e.g. Prof. XXX from YYY gives a presentation about ZZZ...)';
$lang['location_example'] = '(e.g. Squires Colonial Hall)';
$lang['price_example'] = '(e.g. students: free, public: $5)';
$lang['contact_name'] = 'Contact name';
$lang['contact_name_example'] = '(e.g. Lisa Roberts)';
$lang['contact_phone'] = 'Contact phone';
$lang['contact_phone_example'] = '(e.g. (540) 992-4892)';
$lang['contact_email'] = 'Contact e-mail';
$lang['contact_email_example'] = '(e.g. icinfo@hotmail.com)';
$lang['event_page_web_address'] = 'Event page<br> web address';
$lang['event_page_url_example'] = '(e.g. http://www.ic.vt.edu/talks/future.html)';
$lang['button_restore_all_sponsor_defaults'] = 'Restore all sponsor defaults';
$lang['displayed_sponsor_name'] = 'Displayed Name';
$lang['sponsor_page_web_address'] = 'Sponsor\'s Website';
$lang['button_restore_default'] = 'Restore default';
$lang['also_display_on'] = 'Also display this event on the'; // ... Calendar ...
$lang['assign_to_category'] = 'and assign it to this category';

$lang['template_name'] = 'Template name';
$lang['choose_template_name'] = 'Please choose a template name.';
$lang['template_name_example'] = '(e.g. Guest speaker)';

$lang['manage_calendars'] = 'Manage calendars';
$lang['or_modify_existing_calendar'] = 'or modify existing calendar:';
$lang['delete'] = 'Delete';
$lang['calendars'] = 'Calendars';

$lang['manage_event_categories'] = 'Manage event categories';
$lang['or_modify_existing_category'] = 'or modify existing category:';
$lang['rename'] = 'Rename';

$lang['manage_events'] = 'My submitted events';
$lang['or_manage_existing_events'] = 'or manage existing events:';
$lang['status'] = 'Status';
$lang['submitted_for_approval'] = 'awaiting approval';
$lang['approved'] = 'approved';
$lang['copy'] = 'Copy';
$lang['status_info_message'] = 'The status information has the following meaning:';
$lang['rejected'] = 'rejected';
$lang['rejected_explanation'] = '...event was not approved for publication';
$lang['submitted_for_approval_explanation'] = '...event has yet to be reviewed and approved';
$lang['approved_explanation'] = '...event is displayed in the calendar';

$lang['manage_featured_search_keywords'] = 'Manage featured search keywords';
$lang['featured_search_keywords_message'] = 'Below you can associate certain search keywords with custom<br>
text messages or HTML. This can be used to answer to keywords<br>
which are frequently used but rarely have a match within the<br>
calendar.';
$lang['or_manage_existing_keywords'] = 'or manage existing keywords:';

$lang['manage_main_admins'] = 'Manage main admins';
$lang['add_new_main_admin'] = 'Add new main admin';
$lang['or_delete_existing'] = 'or delete existing:';
$lang['main_admins_total'] = 'Main admins total';

$lang['manage_search_keywords'] = 'Manage search keywords';
$lang['manage_search_keywords_message'] = 'The following list contains keywords which are tried by the calendar search engine<br>
in addition to the keyword provided by the user. You can improve the search engine\'s<br>
power by building a list of common synonyms (or alternative keywords) for <br>
frequently-used keywords.';
$lang['or_manage_existing_pairs'] = 'or manage existing pairs:';

$lang['manage_sponsors'] = 'Manage Sponsors';
$lang['or_modify_existing_sponsor'] = 'or modify existing sponsor:';
$lang['sponsors_total'] = 'Sponsors total';

$lang['manage_templates'] = 'Manage Event Templates';
$lang['or_modify_existing_template'] = 'or modify existing template:';

$lang['manage_users'] = 'Manage users';
$lang['button_edit'] = '&nbsp;&nbsp;Edit&nbsp;&nbsp;';
$lang['button_delete'] = 'Delete';
$lang['or_modify_existing_user'] = 'or modify existing user:';

$lang['reject_event_update'] = 'Reject event update';
$lang['reason_for_rejection'] = 'Reason for rejecting this update (send as a notification to the sponsor):';

$lang['rename_event_category'] = 'Rename event category';

$lang['is_logged_on'] = 'is logged on...';
$lang['logout'] = 'Logout';

$lang['update_calendar'] = 'Update calendar';
$lang['sponsors_options'] = 'Sponsor\'s options';
$lang['administrators_options'] = 'Administrator\'s options';
$lang['main_administrators_options'] = 'Main administrator\'s options';
$lang['new_event_submitted_notice'] = 'The new event has been submitted for approval:';
$lang['updated_event_submitted_notice'] = 'The update for the event has been submitted for approval:';
$lang['hompage_changed_notice'] = 'The address of your homepage was successfully changed to:';
$lang['email_changed_notice'] = 'Your email address was successfully changed to:';

$lang['change_password_of_user'] = 'Change password of user';
$lang['view_search_log'] = 'View search log';
$lang['search_log_is_empty'] = 'Search log is empty.';

$lang['edit_template'] = 'Edit template';

$lang['help_export_xmlformat_example'] = 'This is an example of the custom XML format:';
$lang['help_export_data_format'] = '@FILE:languages/en/help_export_data_format.html';
$lang['help_export_categoryid_intro'] = 'The value for &quot;categoryid&quot; is one of the following index numbers:';

$lang['help_categoryid_index'] = 'Index';
$lang['help_categoryid_name'] = 'Name';

$lang['help_import'] = 'Importing events';
$lang['help_import_intro'] = '@FILE:languages/en/help_import_intro.html';
$lang['help_import_data_format_intro'] = '@FILE:languages/en/help_import_data_format_intro.html';
$lang['help_import_data_format'] = '@FILE:languages/en/help_import_data_format.html';

$lang['help_signup'] = 'How to request a login';
$lang['help_signup_authorization'] = '<p>Authorization to add events can be obtained by contacting the calendar administrator at ';
$lang['help_signup_contents'] = '<p>All event submissions will be reviewed by the calendar coordinator before they are posted. Consequently, it is important to submit items at least two days in advance of the event. During the review process, submissions will be checked to see if they are appropriate for posting and edited for clarity and conciseness.</p>';

?>