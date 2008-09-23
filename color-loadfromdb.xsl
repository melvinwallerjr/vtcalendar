<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" omit-xml-declaration="yes" indent="yes"/>
    
    <xsl:variable name="Lower">abcdefghijklmnopqrstuvwxyz</xsl:variable>
    <xsl:variable name="Upper">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>

    <xsl:template match="/">
    	
    	<xsl:for-each select="/Colors/Section/*[@Variable]">
    		<xsl:text disable-output-escaping="yes">&#9;if (isset($record['</xsl:text>
    		<xsl:value-of select="@Variable"/>
    		<xsl:text disable-output-escaping="yes">'])) { setVar($_SESSION['COLOR_</xsl:text>
    		<xsl:value-of select="translate(@Variable, $Lower, $Upper)"/>
    		<xsl:text disable-output-escaping="yes">'], $record['</xsl:text>
    		<xsl:value-of select="@Variable"/>
    		<xsl:text disable-output-escaping="yes">'], 'color'); }&#13;&#10;</xsl:text>
    	</xsl:for-each>
    </xsl:template></xsl:stylesheet>
