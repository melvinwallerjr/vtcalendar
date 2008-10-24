<?php
$lang['vtcalendar_xml'] = 'VTCalendar XML Guide';

require_once('application.inc.php');
pageheader(lang('vtcalendar_xml'), "Update");
contentsection_begin(lang('vtcalendar_xml'),false);
?>

<p>The VTCalendar XML format is used for importing and exporting events between instances of VTCalendar.</p>

<h3>Example 1:</h3>
<blockquote>
<p>In the example below note the following:</p>
<ul>
	<li>As of version 2.3.0, the URL field is still supported for importing, but will always be blank in export XML.</li>
</ul>

<div class="CodeBox-Outer"><pre id="Example" class="CodeBox">&lt;?xml version=&quot;1.0&quot;?&gt;
&lt;events&gt;
    &lt;event&gt;
        ...
    &lt;/event&gt;
    &lt;event&gt;
        ...
    &lt;/event&gt;
&lt;/events&gt;</pre></div>
</blockquote>

<h3>Example 2:</h3>
<blockquote>
<div class="CodeBox-Outer"><pre id="Example" class="CodeBox">&lt;?xml version=&quot;1.0&quot;?&gt;
&lt;events&gt;
    &lt;event&gt;
        &lt;eventid&gt;1219171341079&lt;/eventid&gt;
        &lt;sponsorid&gt;1&lt;/sponsorid&gt;
        &lt;inputsponsor&gt;Univ. Communications&lt;/inputsponsor&gt;
        &lt;displayedsponsor&gt;Howard University School of Law Law Journal and Sidley Austin LLP&lt;/displayedsponsor&gt;
        &lt;displayedsponsorurl/&gt;
        &lt;date&gt;2008-10-24&lt;/date&gt;
        &lt;timebegin&gt;08:30&lt;/timebegin&gt;
        &lt;timeend&gt;16:00&lt;/timeend&gt;
        &lt;repeat_vcaldef/&gt;
        &lt;repeat_startdate/&gt;
        &lt;repeat_enddate/&gt;
        &lt;categoryid&gt;2&lt;/categoryid&gt;
        &lt;category&gt;Seminar/Conference&lt;/category&gt;
        &lt;title&gt;5th Annual Wiley A. Branton Howard Law Journal &amp;amp; Sidley Austin LLP Symposium&lt;/title&gt;
        &lt;description&gt;The symposium theme this year is &amp;quot;Thurgood Marshall.&lt;/description&gt;
        &lt;location&gt;Law School (West Campus), Moot Court Room&lt;/location&gt;
        &lt;price&gt;open to the public&lt;/price&gt;
        &lt;contact_name&gt;Jackie Young&lt;/contact_name&gt;
        &lt;contact_phone&gt;202-806-8084&lt;/contact_phone&gt;
        &lt;contact_email&gt;jyoung@law.howard.edu&lt;/contact_email&gt;
        &lt;url&gt;http://example.edu/eventdetails.htm&lt;/url&gt;
        &lt;recordchangedtime&gt;2008-08-19 14:42:21&lt;/recordchangedtime&gt;
        &lt;recordchangeduser&gt;bsmith&lt;/recordchangeduser&gt;
    &lt;/event&gt;
&lt;/events&gt;</pre></div>
</blockquote>

<h3>Example 3:</h3>
<blockquote>
<div class="CodeBox-Outer"><pre id="Example" class="CodeBox">&lt;?xml version=&quot;1.0&quot;?&gt;
&lt;events&gt;
    &lt;event&gt;
        &lt;eventid&gt;1219179596898-0008&lt;/eventid&gt;
        &lt;sponsorid&gt;200&lt;/sponsorid&gt;
        &lt;inputsponsor&gt;Univ. Communications&lt;/inputsponsor&gt;
        &lt;displayedsponsor/&gt;
        &lt;displayedsponsorurl/&gt;
        &lt;date&gt;2008-10-26&lt;/date&gt;
        &lt;timebegin&gt;11:00&lt;/timebegin&gt;
        &lt;timeend&gt;13:00&lt;/timeend&gt;
        &lt;repeat_vcaldef&gt;W1 SU 20081207T235900&lt;/repeat_vcaldef&gt;
        &lt;repeat_startdate&gt;2008-08-31&lt;/repeat_startdate&gt;
        &lt;repeat_enddate&gt;2008-12-07&lt;/repeat_enddate&gt;
        &lt;categoryid&gt;50&lt;/categoryid&gt;
        &lt;category&gt;Spirituality&lt;/category&gt;
        &lt;title&gt;Call to Chapel&lt;/title&gt;
        &lt;description&gt;Speaker Schedule forthcoming at: http://chapel.howard.edu/Worship/ChapelServices/SpeakerSchedule&lt;/description&gt;
        &lt;location/&gt;
        &lt;price/&gt;
        &lt;contact_name/&gt;
        &lt;contact_phone/&gt;
        &lt;contact_email/&gt;
        &lt;url/&gt;
        &lt;recordchangedtime&gt;2008-08-19 16:59:57&lt;/recordchangedtime&gt;
        &lt;recordchangeduser&gt;bsmith&lt;/recordchangeduser&gt;
    &lt;/event&gt;
&lt;/events&gt;</pre></div>
</blockquote>


<script type="text/javascript" src="scripts/colorcode.js"></script>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript"><!-- // <![CDATA[
var colorer = new SourceCodeColorer();
colorer.UseBRTags = true;
colorer.UseNBSP = true;
var elements = document.getElementsByClassName('CodeBox');
for (var i = 0; i < elements.length; i++) {
	elements[i].innerHTML = colorer.ColorXML(elements[i].innerHTML.unescapeHTML());
}
// ]]> --></script>
<?php
contentsection_end();
pagefooter();
DBclose();
?>