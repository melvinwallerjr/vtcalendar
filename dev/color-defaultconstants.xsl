<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="text" omit-xml-declaration="yes"/>
    
    <xsl:variable name="Lower">abcdefghijklmnopqrstuvwxyz</xsl:variable>
    <xsl:variable name="Upper">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>

    <xsl:template match="/">
        <xsl:text disable-output-escaping="yes">&lt;?php&#13;&#10;&#13;&#10;</xsl:text>
    	<xsl:text>/* ##############################################
WARNING: If you want to override the defaults below, define them in config.inc.php.
Any changes to this file may be overwritten when you upgrade to a newer version of VTCalendar.
############################################## */

</xsl:text>
    	
    	<xsl:apply-templates select="/Colors/Section"/>
        <xsl:text disable-output-escaping="yes">?&gt;</xsl:text>
    </xsl:template>

    <xsl:template match="Section">
    	<xsl:text>/* ==============================================&#13;&#10;</xsl:text>
        <xsl:value-of select="@Title"/>
    	<xsl:text>&#13;&#10;============================================== */&#13;&#10;&#13;&#10;</xsl:text>
        
        <xsl:apply-templates select="Color|Background"/>
    </xsl:template>

    <xsl:template match="/Colors/Section/*">
        <xsl:text>// </xsl:text>
        <xsl:value-of select="text()"/>
        <xsl:text>&#13;&#10;</xsl:text>
        
    	<xsl:text>if (!defined("DEFAULTCOLOR_</xsl:text>
    	<xsl:value-of select="translate(@Variable, $Lower, $Upper)"/>
    	<xsl:text>")) define("DEFAULTCOLOR_</xsl:text>
    	<xsl:value-of select="translate(@Variable, $Lower, $Upper)"/>
    	<xsl:text>", "</xsl:text>
        <xsl:value-of select="@Default"/>
        <xsl:text>");</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>&#13;&#10;</xsl:text>
    </xsl:template>
</xsl:stylesheet>
