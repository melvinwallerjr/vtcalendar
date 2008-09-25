<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="text" omit-xml-declaration="yes" indent="no"/>
    
    <xsl:template match="/">
        <xsl:apply-templates select="/Configs/Section"/>
    </xsl:template>
    
    <xsl:template match="Section">
        <xsl:text>// =====================================&#13;&#10;</xsl:text>
        <xsl:text>// </xsl:text><xsl:value-of select="@Label"/><xsl:text>&#13;&#10;</xsl:text>
        <xsl:text>// =====================================&#13;&#10;&#13;&#10;</xsl:text>
        
        <xsl:apply-templates select="descendant::Config"/>
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
        <xsl:if test="not(Default)">""</xsl:if>
        <xsl:value-of select="Default/text()"/>
        <xsl:text>);&#13;&#10;&#13;&#10;</xsl:text>
    </xsl:template>
</xsl:stylesheet>
