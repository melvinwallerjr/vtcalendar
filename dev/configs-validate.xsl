<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes" indent="yes"/>
	
	<!-- Include the search and replace named template. -->
	<xsl:include href="common-escape-string.xsl" />

	<xsl:template match="/">
		<xsl:apply-templates select="/Configs/Section/Config"/>
	</xsl:template>

	<xsl:template match="Config">
		<xsl:param name="Tab"/>
		
		<xsl:choose>
			<xsl:when test="@IsDefinition='false'">
				<xsl:apply-templates select="Dependants/Config">
					<xsl:with-param name="Tab" select="$Tab"/>
				</xsl:apply-templates>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$Tab"/>
				<xsl:choose>
					<xsl:when test="@Type='string'">
						<xsl:text>if (!is_string(</xsl:text>
						<xsl:value-of select="@Variable"/>
						<xsl:text>)) exit('</xsl:text><xsl:value-of select="@Variable"/><xsl:text> must be a string.');&#13;&#10;</xsl:text>
						
						<xsl:if test="@Required='true'">
							<xsl:value-of select="$Tab"/>
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
						
						<xsl:if test="count(Dependants/Config) &gt; 0">
							<xsl:value-of select="$Tab"/>
							<xsl:text>if (</xsl:text>
							<xsl:value-of select="@Variable"/>
							<xsl:text>) {&#13;&#10;</xsl:text>
							<xsl:apply-templates select="Dependants/Config">
								<xsl:with-param name="Tab"><xsl:value-of select="$Tab"/><xsl:text>&#9;</xsl:text></xsl:with-param>
							</xsl:apply-templates>
							<xsl:text>}&#13;&#10;</xsl:text>
						</xsl:if>
					</xsl:when>
				</xsl:choose>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
