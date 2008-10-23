<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="text" omit-xml-declaration="yes"/>
    
    <xsl:variable name="NL"><xsl:text>&#10;</xsl:text></xsl:variable>
    
    <xsl:template match="/">
        <xsl:apply-templates select="/Items/*"/>
    </xsl:template>
    
    <xsl:template match="Section">
        <xsl:param name="Tabs"></xsl:param>
        
        <xsl:if test="name(preceding-sibling::*) = 'Item'">
            <xsl:value-of select="$NL"/>
        </xsl:if>
        
        <xsl:value-of select="$Tabs"/><xsl:text># Start Section: </xsl:text><xsl:value-of select="@Name"/><xsl:value-of select="$NL"/>
        <xsl:value-of select="$Tabs"/><xsl:value-of select="$NL"/>
        
        <xsl:apply-templates select="*">
            <xsl:with-param name="Tabs"><xsl:value-of select="$Tabs"/><xsl:text>&#9;</xsl:text></xsl:with-param>
        </xsl:apply-templates>
        
        <xsl:value-of select="$Tabs"/><xsl:text># End Section: </xsl:text><xsl:value-of select="@Name"/><xsl:value-of select="$NL"/>
        <xsl:value-of select="$Tabs"/><xsl:value-of select="$NL"/>
    </xsl:template>
    
    <xsl:template match="Item">
        <xsl:param name="Tabs"></xsl:param>
        
        <xsl:if test="@Comment"> // <xsl:value-of select="@Comment"/><xsl:value-of select="$NL"/></xsl:if>
        <xsl:value-of select="$Tabs"/>$lang['<xsl:value-of select="@Name"/>'] = <xsl:value-of select="text()"/>;<xsl:value-of select="$NL"/>
        
        <xsl:if test="position() = last() or name(preceding-sibling::*) = 'Section'">
            <xsl:value-of select="$NL"/>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>
