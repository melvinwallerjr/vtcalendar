<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes"/>
	
	<!-- Set to 'mysql' or 'postgresql' -->
	<xsl:param name="DB">mysql</xsl:param>
	
	<xsl:template match="/">
		<xsl:apply-templates select="DBSchema/Table"/>
	</xsl:template>
	
	<xsl:template match="Table">
		<xsl:text>CREATE TABLE `</xsl:text><xsl:value-of select="@Name"/><xsl:text>` (</xsl:text>
		<xsl:apply-templates select="*"/>
		<xsl:text>&#10;)&#10;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="Field">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>&#10;&#9;`</xsl:text><xsl:value-of select="@Name"/>` <xsl:value-of select="@Type"/><xsl:if test="@NotNull='true'"> NOT NULL</xsl:if>
		<xsl:if test="@AutoIncrement='true'">
			<xsl:choose>
				<xsl:when test="$DB = 'mysql'"> auto_increment</xsl:when>
				<xsl:when test="$DB = 'postresql'"> SERIAL</xsl:when>
			</xsl:choose>
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="PrimaryKey">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>&#10;&#9;PRIMARY KEY (</xsl:text>
		<xsl:apply-templates select="KeyField"/>
		<xsl:text>)</xsl:text>
	</xsl:template>
	
	<xsl:template match="Key">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>&#10;&#9;</xsl:text><xsl:if test="@Unique='true'">UNIQUE </xsl:if>KEY `<xsl:value-of select="@Name"/><xsl:text>` (</xsl:text>
		<xsl:apply-templates select="KeyField"/>
		<xsl:text>)</xsl:text>
	</xsl:template>
	
	<xsl:template match="KeyField">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>`</xsl:text><xsl:value-of select="@Name"/><xsl:text>`</xsl:text>
		<xsl:if test="not(@SubPart = '')">(<xsl:value-of select="@SubPart"/>)</xsl:if>
	</xsl:template>
</xsl:stylesheet>
