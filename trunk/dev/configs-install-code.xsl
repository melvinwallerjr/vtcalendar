<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes"/>
	
	<xsl:include href="common-escape-string.xsl" />
	
	<xsl:template match="/">
		<xsl:apply-templates select="//Config" mode="ReadFormData"/>
		<xsl:text>&#13;&#10;</xsl:text>
		<xsl:apply-templates select="//Config" mode="BuildString"/>
	</xsl:template>
	
	<xsl:template match="Config" mode="ReadFormData">
		<xsl:choose>
			<xsl:when test="@Type='boolean'">
				<xsl:text>&#9;if (isset($_POST['</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text>']) &amp;&amp; strtolower($_POST['</xsl:text>
					<xsl:value-of select="@Variable"/>
					<xsl:text>']) == 'true') { $Form_</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text> = 'true'; } else { $Form_</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text> = 'false'; }&#13;&#10;</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>&#9;if (isset($_POST['</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text>'])) { $Form_</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text> = $_POST['</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text>']; } else { $Form_</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text> = '</xsl:text>
				
				<xsl:call-template name="escape-string">
					<xsl:with-param name="text" select="Default/text()"/>
					<xsl:with-param name="characters">\'</xsl:with-param>
					<xsl:with-param name="escape-character">\</xsl:with-param>
				</xsl:call-template>
				
				<xsl:text>'; }&#13;&#10;</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	
	<xsl:template match="Config" mode="BuildString">
		<xsl:text>&#9;// Output </xsl:text><xsl:value-of select="@Label"/><xsl:text>&#13;&#10;</xsl:text>
		
		
		<xsl:text>&#9;$ConfigOutput .= '// Config: </xsl:text>
		
		<xsl:call-template name="escape-string">
			<xsl:with-param name="text" select="@Label"/>
			<xsl:with-param name="characters">\'</xsl:with-param>
			<xsl:with-param name="escape-character">\</xsl:with-param>
		</xsl:call-template>
		
		<xsl:text>'."\n";&#13;&#10;</xsl:text>
		<xsl:if test="Example">
			<xsl:text>&#9;$ConfigOutput .= '// Example: </xsl:text>
			
			<xsl:call-template name="escape-string">
				<xsl:with-param name="text" select="Example/text()"/>
				<xsl:with-param name="characters">\'</xsl:with-param>
				<xsl:with-param name="escape-character">\</xsl:with-param>
			</xsl:call-template>
			
			<xsl:text>'."\n";&#13;&#10;</xsl:text>
		</xsl:if>
		
		<xsl:for-each select="Comment/Line">
			<xsl:text>&#9;$ConfigOutput .= '// </xsl:text>
			
			<xsl:call-template name="escape-string">
				<xsl:with-param name="text" select="text()"/>
				<xsl:with-param name="characters">\'</xsl:with-param>
				<xsl:with-param name="escape-character">\</xsl:with-param>
			</xsl:call-template>
			
			<xsl:text>'."\n";&#13;&#10;</xsl:text>
		</xsl:for-each>
		
		
		<xsl:text>&#9;$ConfigOutput .= 'define("</xsl:text><xsl:value-of select="@Variable"/><xsl:text>", </xsl:text>
		
		<xsl:choose>
			<xsl:when test="@Type='boolean'">' . $Form_<xsl:value-of select="@Variable"/> .'</xsl:when>
			<xsl:otherwise>\''. escapephpstring($Form_<xsl:value-of select="@Variable"/>) .'\'</xsl:otherwise>
		</xsl:choose>
		
		<xsl:text>);'."\n\n";&#13;&#10;&#13;&#10;</xsl:text>
	</xsl:template>
</xsl:stylesheet>
