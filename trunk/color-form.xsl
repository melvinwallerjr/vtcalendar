<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" omit-xml-declaration="yes" indent="yes"/>
    
    <xsl:variable name="Lower">abcdefghijklmnopqrstuvwxyz</xsl:variable>
    <xsl:variable name="Upper">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>
    <xsl:variable name="InvalidColor">invalid_color</xsl:variable>
    <xsl:variable name="InvalidBackground">invalid_background</xsl:variable>

    <xsl:template match="/">
        <xsl:text disable-output-escaping="yes">&lt;?php</xsl:text>
        
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        
        <xsl:text>$lang['invalid_color'] = " is not a valid color. It must be in #XXXXXX format.";&#13;&#10;</xsl:text>
        <xsl:text>$lang['invalid_background'] = "";&#13;&#10;</xsl:text>
        
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:apply-templates select="/Colors/Section" mode="Lang"/>
        
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:apply-templates select="/Colors/Section/Color|/Colors/Section/Background" mode="Lang"/>
        
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>function LoadVariables() {</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>&#9;global $VariableErrors;&#13;&#10;</xsl:text>
        <xsl:apply-templates select="/Colors/Section/Color|/Colors/Section/Background" mode="Variables"/>
    	<xsl:text>}</xsl:text>
    	
    	<xsl:text>&#13;&#10;</xsl:text>
    	<xsl:text>&#13;&#10;</xsl:text>
    	<xsl:call-template name="SQL"/>
        
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text disable-output-escaping="yes">function ShowForm() {</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text disable-output-escaping="yes">&#9;global $VariableErrors; ?&gt;</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:apply-templates select="/Colors/Section"/>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text disable-output-escaping="yes">&lt;?php } ?&gt;</xsl:text>
    </xsl:template>
    
    <xsl:template match="/Colors/Section" mode="Lang">
        <xsl:text disable-output-escaping="yes">$lang['color_section_title_</xsl:text>
        <xsl:value-of select="translate(@Name, $Upper, $Lower)"/>
        <xsl:text disable-output-escaping="yes">'] = "</xsl:text>
        <xsl:value-of select="@Title"/>
        <xsl:text disable-output-escaping="yes">";</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        
        <xsl:if test="string-length(Description/text()) &gt; 0">
            <xsl:text disable-output-escaping="yes">$lang['color_section_description_</xsl:text>
            <xsl:value-of select="translate(@Name, $Upper, $Lower)"/>
            <xsl:text disable-output-escaping="yes">'] = "</xsl:text>
            <xsl:value-of select="Description/text()"/>
            <xsl:text disable-output-escaping="yes">";</xsl:text>
            <xsl:text>&#13;&#10;</xsl:text>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="/Colors/Section/*" mode="Lang">
        <xsl:text disable-output-escaping="yes">$lang['color_label_</xsl:text>
        <xsl:value-of select="translate(@Variable, $Upper, $Lower)"/>
        <xsl:text disable-output-escaping="yes">'] = "</xsl:text>
        <xsl:value-of select="@Label"/>
        <xsl:text disable-output-escaping="yes">";</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        
        <xsl:text disable-output-escaping="yes">$lang['color_description_</xsl:text>
        <xsl:value-of select="translate(@Variable, $Upper, $Lower)"/>
        <xsl:text disable-output-escaping="yes">'] = "</xsl:text>
        <xsl:value-of select="text()"/>
        <xsl:text disable-output-escaping="yes">";</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
    </xsl:template>
    
    <xsl:template match="/Colors/Section/*" mode="Variables">
        <xsl:text>&#9;</xsl:text>
        <xsl:text disable-output-escaping="yes">if (!isset($_POST['</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">']) || !setVar($GLOBALS['Color_</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">'], $_POST['</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">'],'</xsl:text>
        <xsl:value-of select="translate(name(), $Upper, $Lower)"/>
        <xsl:text disable-output-escaping="yes">')) { if (isset($_POST['</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">'])) $VariableErrors['</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">'] = $_POST['</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">']; $GLOBALS['Color_</xsl:text>
        <xsl:value-of select="@Variable"/>
        <xsl:text disable-output-escaping="yes">'] = $_SESSION['COLOR_</xsl:text>
        <xsl:value-of select="translate(@Variable, $Lower, $Upper)"/>
        <xsl:text disable-output-escaping="yes">']; };</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
    </xsl:template>

    <xsl:template match="Section">
        <div class="FormSectionHeader">
            <h3 style="margin: 0; padding: 0;">
                <xsl:text disable-output-escaping="yes">&lt;?php echo htmlentities(lang('color_section_title_</xsl:text>
                <xsl:value-of select="translate(@Name, $Upper, $Lower)"/>
                <xsl:text disable-output-escaping="yes">')); ?&gt;:</xsl:text>
            </h3>

            <xsl:if test="string-length(Description/text()) &gt; 0">
                <div style="padding: 2px; padding-left: 15px;">
                    <xsl:text disable-output-escaping="yes">&lt;?php echo htmlentities(lang('color_section_description_</xsl:text>
                    <xsl:value-of select="translate(@Name, $Upper, $Lower)"/>
                    <xsl:text disable-output-escaping="yes">')); ?&gt;</xsl:text>
                </div>
            </xsl:if>
        </div>

        <div style="padding-left: 18px;">
            <table border="0" cellpadding="2" cellspacing="0">
                <xsl:apply-templates select="Color|Background" mode="Form"/>
            </table>
        </div>
    </xsl:template>

    <xsl:template match="/Colors/Section/*" mode="Form">
        <tr>
            <td>
                <b>
                    <xsl:text disable-output-escaping="yes">&lt;?php echo htmlentities(lang('color_label_</xsl:text>
                    <xsl:value-of select="translate(@Variable, $Upper, $Lower)"/>
                    <xsl:text disable-output-escaping="yes">')); ?&gt;:</xsl:text>
                </b>
            </td>
            <td>
                <xsl:if test="self::Color">
                    <xsl:text disable-output-escaping="yes"><![CDATA[<span id="Swap_]]></xsl:text>
                    <xsl:value-of select="@Variable"/>
                    <xsl:text disable-output-escaping="yes"><![CDATA[" onClick="SetupColorPicker(']]></xsl:text>
                    <xsl:value-of select="@Variable"/>
                    <xsl:text disable-output-escaping="yes"><![CDATA[')" title="<?php echo lang('click_for_color_picker'); ?>" style="cursor: pointer; border: 1px solid <?php echo $GLOBALS['Color_Border']; ?>; padding: 2px; background-color: <?php echo $GLOBALS['Color_]]></xsl:text>
                    <xsl:value-of select="@Variable"/>
                	<xsl:text disable-output-escaping="yes"><![CDATA[']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;</span> ]]></xsl:text>
                </xsl:if>
                <xsl:text disable-output-escaping="yes"><![CDATA[<input type="text" id="Color_]]></xsl:text>
                <xsl:value-of select="@Variable"/>
                <xsl:text disable-output-escaping="yes"><![CDATA[" name="]]></xsl:text>
                <xsl:value-of select="@Variable"/>
                <xsl:text disable-output-escaping="yes"><![CDATA[" value="<?php echo $GLOBALS['Color_]]></xsl:text>
                <xsl:value-of select="@Variable"/>
            	<xsl:text disable-output-escaping="yes"><![CDATA[']; ?>" onKeyUp="ColorChanged(']]></xsl:text>
            	<xsl:value-of select="@Variable"/>
            	<xsl:text disable-output-escaping="yes"><![CDATA[')">]]></xsl:text>
                <xsl:if test="string-length(text()) &gt; 0">
                    <xsl:text disable-output-escaping="yes"> &lt;?php echo htmlentities(lang('color_description_</xsl:text>
                    <xsl:value-of select="translate(@Variable, $Upper, $Lower)"/>
                    <xsl:text disable-output-escaping="yes">')); ?&gt;</xsl:text>
                </xsl:if>
                <xsl:text disable-output-escaping="yes">&lt;?php if (isset($VariableErrors['</xsl:text>
                <xsl:value-of select="@Variable"/>
                <xsl:text disable-output-escaping="yes">'])) { ?&gt;</xsl:text>
                <span class="WarningText">
                <xsl:text disable-output-escaping="yes">&lt;br&gt; &lt;?php echo htmlentities('"'.$VariableErrors['</xsl:text>
                <xsl:value-of select="@Variable"/>
                <xsl:text disable-output-escaping="yes">'] .'" '. lang('</xsl:text>
                <xsl:value-of select="$InvalidColor"/>
                <xsl:text disable-output-escaping="yes">')); ?&gt;</xsl:text>
                </span>
                <xsl:text disable-output-escaping="yes">&lt;?php } ?&gt;</xsl:text>
            </td>
        </tr>
    </xsl:template>
	
	<xsl:template name="SQL">
		<xsl:text>function MakeColorUpdateSQL($calendarid) {&#13;&#10;</xsl:text>
		<xsl:text>&#9;$sql = "INSERT INTO vtcal_colors (calendarid";&#13;&#10;</xsl:text>
		<xsl:text>&#9;$sql .= "</xsl:text>
		<xsl:for-each select="/Colors/Section/*[@Variable]">
			<xsl:text>, </xsl:text>
			<xsl:value-of select="@Variable"/>
		</xsl:for-each>
		<xsl:text>";&#13;&#10;</xsl:text>
		<xsl:text>&#9;$sql .= ") VALUES ('" . sqlescape($calendarid) . "'";&#13;&#10;</xsl:text>
		<xsl:for-each select="/Colors/Section/*[@Variable]">
			<xsl:text>&#9;&#9;$sql .= ",'" . sqlescape($GLOBALS['Color_</xsl:text>
			<xsl:value-of select="@Variable"/>
			<xsl:text>']) . "'";&#13;&#10;</xsl:text>	
		</xsl:for-each>
		<xsl:text>&#9;$sql .= ") ON DUPLICATE KEY UPDATE ";&#13;&#10;</xsl:text>
		<xsl:for-each select="/Colors/Section/*[@Variable]">
			<xsl:text>&#9;&#9;$sql .= "</xsl:text>
			<xsl:if test="position() &gt; 1">
				<xsl:text>,</xsl:text>
			</xsl:if>
			<xsl:value-of select="@Variable"/>
			<xsl:text> = '" . sqlescape($GLOBALS['Color_</xsl:text>
			<xsl:value-of select="@Variable"/>
			<xsl:text>']) . "'";&#13;&#10;</xsl:text>	
		</xsl:for-each>
		
		<xsl:text>&#9;return $sql;&#13;&#10;</xsl:text>
		<xsl:text>}&#13;&#10;</xsl:text>
	</xsl:template>
</xsl:stylesheet>
