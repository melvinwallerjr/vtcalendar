<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes"/>
	
	<xsl:template match="/">
		<xsl:apply-templates select="DBSchema/Table/*"/>
	</xsl:template>
	
	<xsl:template match="Field">
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../@Name"/>']['Fields']['<xsl:value-of select="@Name"/>']['Type'] = "<xsl:value-of select="@Type"/>"<xsl:text>;&#10;</xsl:text>
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../@Name"/>']['Fields']['<xsl:value-of select="@Name"/>']['NotNull'] = <xsl:value-of select="@NotNull"/><xsl:text>;&#10;</xsl:text>
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../@Name"/>']['Fields']['<xsl:value-of select="@Name"/>']['AutoIncrement'] = <xsl:value-of select="@AutoIncrement"/><xsl:text>;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="PrimaryKey">
		<xsl:apply-templates select="KeyField">
			<xsl:with-param name="IndexName">PRIMARY</xsl:with-param>
		</xsl:apply-templates>
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../@Name"/>']['Keys']['PRIMARY']['Unique'] = true<xsl:text>;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="Key">
		<xsl:apply-templates select="KeyField">
			<xsl:with-param name="IndexName" select="@Name"/>
		</xsl:apply-templates>
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../@Name"/>']['Keys']['<xsl:value-of select="@Name"/>']['Unique'] = <xsl:value-of select="@Unique"/><xsl:text>;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="KeyField">
		<xsl:param name="IndexName"/>
		<xsl:text>$FinalTables</xsl:text>['<xsl:value-of select="../../@Name"/>']['Keys']['<xsl:value-of select="$IndexName"/>']['Fields']['<xsl:value-of select="@Name"/>'] = "<xsl:value-of select="@SubPart"/>"<xsl:text>;&#10;</xsl:text>
	</xsl:template>
	<!-- 
		$FinalTables['vtcal_auth']['Fields']['calendarid']['Type'] = "varchar(150)";
		$FinalTables['vtcal_auth']['Fields']['calendarid']['NotNull'] = true;
		$FinalTables['vtcal_auth']['Fields']['calendarid']['AutoIncrement'] = false;
		$FinalTables['vtcal_auth']['Fields']['userid']['Type'] = "varchar(150)";
		$FinalTables['vtcal_auth']['Fields']['userid']['NotNull'] = true;
		$FinalTables['vtcal_auth']['Fields']['userid']['AutoIncrement'] = false;
		$FinalTables['vtcal_auth']['Fields']['sponsoridx']['Type'] = "int(11)";
		$FinalTables['vtcal_auth']['Fields']['sponsoridx']['NotNull'] = true;
		$FinalTables['vtcal_auth']['Fields']['sponsoridx']['AutoIncrement'] = false;
		$FinalTables['vtcal_auth']['Keys']['PRIMARY']['Fields']['calendarid'] = "";
		$FinalTables['vtcal_auth']['Keys']['PRIMARY']['Fields']['userid'] = "";
		$FinalTables['vtcal_auth']['Keys']['PRIMARY']['Fields']['sponsoridx'] = "";
		$FinalTables['vtcal_auth']['Keys']['PRIMARY']['Unique'] = true;
		$FinalTables['vtcal_auth']['Keys']['a']['Fields']['calendarid'] = "";
		$FinalTables['vtcal_auth']['Keys']['a']['Fields']['userid'] = "";
		$FinalTables['vtcal_auth']['Keys']['a']['Fields']['sponsoridx'] = "";
		$FinalTables['vtcal_auth']['Keys']['a']['Unique'] = true;
	-->
</xsl:stylesheet>
