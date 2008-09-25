<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
<xsl:output omit-xml-declaration="yes"/>

<!--
Search through text for a specific string.
If that search string is found, then replace it with another string.
Return the final string after all searching and replacing is done.
-->
<xsl:template name="replace-string">
	<xsl:param name="text"/>
	<xsl:param name="search"/>
	<xsl:param name="replace"/>
	
	<xsl:choose>
		<!-- If the text contains the 'search' string -->
		<xsl:when test="contains($text, $search)">
			<xsl:variable name="before" select="substring-before($text, $search)"/>
			<xsl:variable name="after" select="substring-after($text, $search)"/>
			<xsl:variable name="prefix" select="concat($before, $replace)"/>
			
			<xsl:value-of select="$before" disable-output-escaping="yes"/>
			<xsl:value-of select="$replace" disable-output-escaping="yes"/>
		
			<xsl:call-template name="replace-string">
				<xsl:with-param name="text" select="$after"/>
				<xsl:with-param name="search" select="$search"/>
				<xsl:with-param name="replace" select="$replace"/>
			</xsl:call-template>
		</xsl:when> 
		<xsl:otherwise>
			<xsl:value-of select="$text" disable-output-escaping="yes"/>
		</xsl:otherwise>
	</xsl:choose>						
</xsl:template>

</xsl:stylesheet>
