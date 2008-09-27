<?xml version="1.0"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

<!--
Search for each character in the 'characters' string,
and insert the 'escape-character' string before each one found.
-->
<xsl:template name="escape-string">
	<xsl:param name="text"/>
	<xsl:param name="characters"/>
	<xsl:param name="escape-character"/>
	
	<xsl:choose>
		<!-- If there are still characters to escape... -->
		<xsl:when test="string-length($characters) &gt; 0">
			
			<!-- Escape the next 'character' by doing a search and replace. -->
			<xsl:variable name="ReplacedString">
				<xsl:call-template name="replace-string">
					<xsl:with-param name="text" select="$text"/>
					<xsl:with-param name="search" select="substring($characters, 1, 1)"/>
					<xsl:with-param name="replace" select="concat($escape-character, substring($characters, 1, 1))"/>
				</xsl:call-template>
			</xsl:variable>
			
			<!-- Have this template call itself to handle the remaining characters to escape. -->
			<xsl:call-template name="escape-string">
				<xsl:with-param name="text" select="$ReplacedString"/>
				<xsl:with-param name="characters" select="substring($characters, 2)" />
				<xsl:with-param name="escape-character" select="$escape-character" />
			</xsl:call-template>
		</xsl:when>
		
		<!-- If there are no more characters to escape, then output the final text. -->
		<xsl:otherwise>
			<xsl:value-of select="$text"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>
	
<xsl:template name="xml-escape-string">
	<xsl:param name="text"/>
	
	<xsl:call-template name="replace-string">
		<xsl:with-param name="text">
			<xsl:call-template name="replace-string">
				<xsl:with-param name="text">
					<xsl:call-template name="replace-string">
						<xsl:with-param name="text">
							<xsl:call-template name="replace-string">
								<xsl:with-param name="text" select="$text"/>
								<xsl:with-param name="search"><xsl:text>&amp;</xsl:text></xsl:with-param>
								<xsl:with-param name="replace"><xsl:text>&amp;amp;</xsl:text></xsl:with-param>
							</xsl:call-template>
						</xsl:with-param>
						<xsl:with-param name="search"><xsl:text>&quot;</xsl:text></xsl:with-param>
						<xsl:with-param name="replace"><xsl:text>&amp;quot;</xsl:text></xsl:with-param>
					</xsl:call-template>
				</xsl:with-param>
				<xsl:with-param name="search"><xsl:text>&lt;</xsl:text></xsl:with-param>
				<xsl:with-param name="replace"><xsl:text>&amp;lt;</xsl:text></xsl:with-param>
			</xsl:call-template>
		</xsl:with-param>
		<xsl:with-param name="search"><xsl:text>&gt;</xsl:text></xsl:with-param>
		<xsl:with-param name="replace"><xsl:text>&amp;gt;</xsl:text></xsl:with-param>
	</xsl:call-template>
</xsl:template>

<!-- Include the search and replace named template. -->
<xsl:include href="common-replace-string.xsl" />

</xsl:stylesheet>