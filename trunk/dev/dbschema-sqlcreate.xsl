<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes"/>
	
	<!-- Set to 'mysql' or 'postgresql' -->
	<xsl:param name="DB">postgresql</xsl:param>
	<xsl:param name="TablePrefix"></xsl:param>
	<xsl:param name="DropTables">true</xsl:param>
	<xsl:variable name="IdentifierQuote">
		<xsl:choose>
			<xsl:when test="$DB='mysql'">`</xsl:when>
			<xsl:otherwise>"</xsl:otherwise>
		</xsl:choose>
		
	</xsl:variable>
	
	<xsl:template match="/">
		<xsl:if test="$DropTables = 'true'">
			<xsl:for-each select="DBSchema/Table">
				<xsl:text>DROP TABLE </xsl:text><xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="$TablePrefix"/><xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/><xsl:text>;&#10;&#10;</xsl:text>
			</xsl:for-each>
		</xsl:if>
		
		<xsl:apply-templates select="DBSchema/Table"/>
	</xsl:template>
	
	<xsl:template match="Table">
		<xsl:text>CREATE TABLE </xsl:text><xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="$TablePrefix"/><xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/><xsl:text> (</xsl:text>
		<xsl:choose>
			<xsl:when test="$DB = 'mysql'">
				<xsl:apply-templates select="*"/>
				<xsl:text>&#10;);&#10;&#10;</xsl:text>
			</xsl:when>
			<xsl:when test="$DB = 'postgresql'">
				<xsl:apply-templates select="Field|PrimaryKey"/>
				<xsl:text>&#10;);&#10;&#10;</xsl:text>
				<xsl:apply-templates select="Key"/>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="Field">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>&#10;&#9;</xsl:text><xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/>
		
		<xsl:choose>
			<xsl:when test="@AutoIncrement='true' and $DB = 'postgresql'"> SERIAL</xsl:when>
			<xsl:otherwise>
				<xsl:text> </xsl:text><xsl:value-of select="@Type"/><xsl:if test="@NotNull='true'"> NOT NULL</xsl:if>
				<xsl:if test="@AutoIncrement='true'"> auto_increment</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="PrimaryKey">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:text>&#10;&#9;PRIMARY KEY (</xsl:text>
		<xsl:apply-templates select="KeyField"/>
		<xsl:text>)</xsl:text>
	</xsl:template>
	
	<xsl:template match="Key">
		<xsl:choose>
			<xsl:when test="$DB = 'mysql'">
				<xsl:if test="position() &gt; 1">,</xsl:if>
				<xsl:text>&#10;&#9;</xsl:text><xsl:if test="@Unique='true'">UNIQUE </xsl:if>KEY <xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/><xsl:text> (</xsl:text>
				<xsl:apply-templates select="KeyField"/>
				<xsl:text>)</xsl:text>
			</xsl:when>
			<xsl:when test="$DB = 'postgresql'">
				<xsl:text>CREATE </xsl:text><xsl:if test="@Unique='true'">UNIQUE </xsl:if>INDEX <xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="../@Name"/>_<xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/> ON <xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="$TablePrefix"/><xsl:value-of select="../@Name"/><xsl:value-of select="$IdentifierQuote"/> (<xsl:apply-templates select="KeyField"/>);<xsl:text>&#10;&#10;</xsl:text>
			</xsl:when>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="KeyField">
		<xsl:if test="position() &gt; 1">,</xsl:if>
		<xsl:value-of select="$IdentifierQuote"/><xsl:value-of select="@Name"/><xsl:value-of select="$IdentifierQuote"/>
		<xsl:if test="$DB='mysql' and not(@SubPart = '')">(<xsl:value-of select="@SubPart"/>)</xsl:if>
	</xsl:template>
</xsl:stylesheet>
