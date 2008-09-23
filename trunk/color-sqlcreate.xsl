<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="text" omit-xml-declaration="yes"/>

	<xsl:template match="/">
		DROP TABLE IF EXISTS `vtcalendar`.`vtcal_colors`;
		CREATE TABLE  `vtcalendar`.`vtcal_colors` (
		`calendarid` varchar(50) NOT NULL,
		
		<xsl:for-each select="/Colors/Section/*[@Variable]">
			`<xsl:value-of select="@Variable"/>` char(7) NOT NULL,
		</xsl:for-each>
		
		PRIMARY KEY  (`calendarid`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
    </xsl:template>
</xsl:stylesheet>
