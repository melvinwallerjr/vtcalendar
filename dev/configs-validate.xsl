<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes" indent="yes"/>
	
	<!-- Include the search and replace named template. -->
	<xsl:include href="common-escape-string.xsl" />

	<xsl:template match="/">
		<xsl:apply-templates select="descendant::Config"/>
	</xsl:template>

	<xsl:template match="Config">
		<xsl:if test="not(@IsDefinition='false')">
			<xsl:choose>
				<xsl:when test="@Type='string'">
					<xsl:text>if (!is_string(</xsl:text>
					<xsl:value-of select="@Variable"/>
					<xsl:text>)) exit('</xsl:text><xsl:value-of select="@Variable"/><xsl:text> must be a string.');&#13;&#10;</xsl:text>
					
					<xsl:if test="@Required='true'">
						<xsl:text>if (</xsl:text>
						<xsl:value-of select="@Variable"/>
						<xsl:text> == '') exit('</xsl:text><xsl:value-of select="@Variable"/><xsl:text> cannot be an empty string.');&#13;&#10;</xsl:text>
					</xsl:if>
				</xsl:when>
				<xsl:when test="@Type='number'">
					<xsl:text>if (!is_numeric(</xsl:text>
					<xsl:value-of select="@Variable"/>
					<xsl:text>)) exit('</xsl:text><xsl:value-of select="@Variable"/><xsl:text> must be an numeric.');&#13;&#10;</xsl:text>
				</xsl:when>
				<xsl:when test="@Type='boolean'">
					<xsl:text>if (!is_bool(</xsl:text>
					<xsl:value-of select="@Variable"/>
					<xsl:text>)) exit('</xsl:text><xsl:value-of select="@Variable"/><xsl:text> must be a boolean true or false. Make sure it is not enclosed in quotes.');&#13;&#10;</xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
