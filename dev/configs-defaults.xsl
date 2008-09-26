<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="text" omit-xml-declaration="yes" indent="no"/>
    
    <xsl:include href="common-escape-string.xsl" />
    
    <xsl:template match="/">
        <xsl:apply-templates select="/Configs/Section"/>
    </xsl:template>
    
    <xsl:template match="Section">
        <xsl:text>// =====================================&#13;&#10;</xsl:text>
        <xsl:text>// </xsl:text><xsl:value-of select="@Label"/><xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>// =====================================&#13;&#10;&#13;&#10;</xsl:text>
        
        <xsl:apply-templates select="Config[not(@IsDefinition = 'false')]"/>
    </xsl:template>
    
    <xsl:template match="Config">
        <xsl:text>// Config: </xsl:text><xsl:value-of select="@Label"/><xsl:text>&#13;&#10;</xsl:text>
        <xsl:if test="Example">
            <xsl:text>// Example: </xsl:text><xsl:value-of select="Example/text()"/><xsl:text>&#13;&#10;</xsl:text>
        </xsl:if>
        
        <xsl:for-each select="Comment/Line">
            <xsl:text>// </xsl:text>
            <xsl:value-of select="text()"/>
            <xsl:text>&#13;&#10;</xsl:text>
        </xsl:for-each>
        
        <xsl:text>if (!defined("</xsl:text><xsl:value-of select="@Variable"/><xsl:text>")) define("</xsl:text><xsl:value-of select="@Variable"/><xsl:text>", </xsl:text>
        <xsl:choose>
        	<xsl:when test="not(Default)">""</xsl:when>
        	<xsl:when test="Default/@Internal"><xsl:value-of select="Default/@Internal"/></xsl:when>
        	<xsl:when test="@Type='string'">
        	    <xsl:text>'</xsl:text>
        	    <xsl:call-template name="escape-string">
        	        <xsl:with-param name="text" select="Default/text()"/>
        	        <xsl:with-param name="characters">\'</xsl:with-param>
        	        <xsl:with-param name="escape-character">\</xsl:with-param>
        	    </xsl:call-template>
        	    <xsl:text>'</xsl:text>
        	</xsl:when>
        	<xsl:otherwise><xsl:value-of select="Default/text()"/></xsl:otherwise>
        </xsl:choose>
        <xsl:text>);&#13;&#10;&#13;&#10;</xsl:text>
        
        <xsl:apply-templates select="Dependants/Config[not(@IsDefinition = 'false')]"/>
    </xsl:template>
</xsl:stylesheet>
