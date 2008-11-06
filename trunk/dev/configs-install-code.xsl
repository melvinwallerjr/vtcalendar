<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="text" omit-xml-declaration="yes"/>
	
	<xsl:include href="common-escape-string.xsl" />
	
	<xsl:template match="/">
		<xsl:text>// Default Form Values&#13;&#10;</xsl:text>
		<xsl:apply-templates select="//Config" mode="FormDefaults"/>
		<xsl:text>&#13;&#10;</xsl:text>
		
		<xsl:text>// Load Submitted Form Values&#13;&#10;</xsl:text>
		<xsl:text>if (isset($_POST['SaveConfig'])) {&#13;&#10;</xsl:text>
		<xsl:apply-templates select="/Configs/Section/Config" mode="ReadFormData"/>
		<xsl:text>}&#13;&#10;&#13;&#10;</xsl:text>
		
		<xsl:text>// Build Code for config.inc.php&#13;&#10;</xsl:text>
		<xsl:text disable-output-escaping="yes">function BuildOutput(&amp;$ConfigOutput) {&#13;&#10;</xsl:text>
		<xsl:apply-templates select="/Configs/Section/Config" mode="BuildString"/>
		<xsl:text>}</xsl:text>
	</xsl:template>
	
	<xsl:template match="Config" mode="FormDefaults">
		<xsl:text>$Form_</xsl:text>
		<xsl:value-of select="@Variable"/>
		<xsl:text> = </xsl:text>
		
		<xsl:choose>
			<xsl:when test="@Type='boolean'">
				<xsl:value-of select="Default/text()"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>'</xsl:text>
				
				<xsl:call-template name="escape-string">
					<xsl:with-param name="text" select="Default/text()"/>
					<xsl:with-param name="characters">\'</xsl:with-param>
					<xsl:with-param name="escape-character">\</xsl:with-param>
				</xsl:call-template>
				
				<xsl:text>'</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
		
		<xsl:text>;&#13;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="Config" mode="ReadFormData">
		<xsl:param name="Tab"><xsl:text>&#9;</xsl:text></xsl:param>
		
		<xsl:value-of select="$Tab"/><xsl:text>$Form_</xsl:text>
		<xsl:value-of select="@Variable"/>
		<xsl:text> = </xsl:text>
		<xsl:choose>
			<xsl:when test="@Type='boolean'">
				<xsl:text>isset($_POST['</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text>'])</xsl:text>
			</xsl:when>
			<xsl:otherwise>
				<xsl:text>$_POST['</xsl:text>
				<xsl:value-of select="@Variable"/>
				<xsl:text>']</xsl:text>
			</xsl:otherwise>
		</xsl:choose>
		<xsl:text>;&#13;&#10;</xsl:text>
		
		<xsl:if test="count(Dependants/Config) &gt; 0">
			<xsl:value-of select="$Tab"/><xsl:text>if ($Form_</xsl:text><xsl:value-of select="@Variable"/><xsl:text>) {&#13;&#10;</xsl:text>
			
			<xsl:apply-templates select="Dependants/Config" mode="ReadFormData">
				<xsl:with-param name="Tab"><xsl:value-of select="$Tab"/><xsl:text>&#9;</xsl:text></xsl:with-param>
			</xsl:apply-templates>
			
			<xsl:value-of select="$Tab"/><xsl:text>}&#13;&#10;</xsl:text>
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="Config" mode="BuildString">
		<xsl:param name="Tab"><xsl:text>&#9;</xsl:text></xsl:param>
		
		<xsl:if test="not(@IsDefinition = 'false')">
			<xsl:value-of select="$Tab"/><xsl:text>// Output </xsl:text><xsl:value-of select="@Label"/><xsl:text>&#13;&#10;</xsl:text>
			
			<xsl:value-of select="$Tab"/><xsl:text>$ConfigOutput .= '// Config: </xsl:text>
			
			<xsl:call-template name="escape-string">
				<xsl:with-param name="text" select="@Label"/>
				<xsl:with-param name="characters">\'</xsl:with-param>
				<xsl:with-param name="escape-character">\</xsl:with-param>
			</xsl:call-template>
			
			<xsl:text>'."\n";&#13;&#10;</xsl:text>
			
			<xsl:if test="Example">
				<xsl:value-of select="$Tab"/><xsl:text>$ConfigOutput .= '// Example: </xsl:text>
				
				<xsl:call-template name="escape-string">
					<xsl:with-param name="text" select="Example/text()"/>
					<xsl:with-param name="characters">\'</xsl:with-param>
					<xsl:with-param name="escape-character">\</xsl:with-param>
				</xsl:call-template>
				
				<xsl:text>'."\n";&#13;&#10;</xsl:text>
			</xsl:if>
			
			<xsl:if test="Default">
				<xsl:value-of select="$Tab"/><xsl:text>$ConfigOutput .= '// Default: </xsl:text>
				
				<xsl:call-template name="escape-string">
					<xsl:with-param name="text" select="Default/text()"/>
					<xsl:with-param name="characters">\'</xsl:with-param>
					<xsl:with-param name="escape-character">\</xsl:with-param>
				</xsl:call-template>
				
				<xsl:text>'."\n";&#13;&#10;</xsl:text>
			</xsl:if>
			
			<xsl:apply-templates select="Comment/*">
				<xsl:with-param name="Tab" select="$Tab"/>
			</xsl:apply-templates>
			
			<xsl:value-of select="$Tab"/><xsl:text>$ConfigOutput .= 'define("</xsl:text><xsl:value-of select="@Variable"/><xsl:text>", </xsl:text>
			
			<xsl:choose>
				<xsl:when test="@Type='boolean'">' . ($GLOBALS['Form_<xsl:value-of select="@Variable"/>'] ? 'true' : 'false') .'</xsl:when>
				<xsl:otherwise>\''. escapephpstring($GLOBALS['Form_<xsl:value-of select="@Variable"/>']) .'\'</xsl:otherwise>
			</xsl:choose>
			
			<xsl:text>);'."\n\n";&#13;&#10;&#13;&#10;</xsl:text>
		</xsl:if>
		
		<xsl:if test="count(Dependants/Config) &gt; 0">
			<!--<xsl:value-of select="$Tab"/><xsl:text>//if ($GLOBALS['Form_</xsl:text><xsl:value-of select="@Variable"/><xsl:text>']) {&#13;&#10;&#13;&#10;</xsl:text>-->
			
			<xsl:apply-templates select="Dependants/Config" mode="BuildString">
				<!--<xsl:with-param name="Tab"><xsl:value-of select="$Tab"/><xsl:text>&#9;</xsl:text></xsl:with-param>-->
			</xsl:apply-templates>
			
			<!--<xsl:value-of select="$Tab"/><xsl:text>//}&#13;&#10;&#13;&#10;</xsl:text>-->
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="Paragraph">
		<xsl:param name="Tab"/>
		<xsl:apply-templates select="Line">
			<xsl:with-param name="Tab" select="$Tab"/>
		</xsl:apply-templates>
	</xsl:template>
	
	<xsl:template match="Line">
		<xsl:param name="Tab"/>
		
		<xsl:value-of select="$Tab"/>
		<xsl:text>$ConfigOutput .= '// </xsl:text>
		
		<xsl:call-template name="escape-string">
			<xsl:with-param name="text" select="text()"/>
			<xsl:with-param name="characters">\'</xsl:with-param>
			<xsl:with-param name="escape-character">\</xsl:with-param>
		</xsl:call-template>
		
		<xsl:text>'."\n";&#13;&#10;</xsl:text>
	</xsl:template>
	
	<xsl:template match="List">
		<xsl:param name="Tab"/>
		
		<xsl:for-each select="Item">
			<xsl:value-of select="$Tab"/>
			<xsl:text>$ConfigOutput .= '// </xsl:text>
			
			<xsl:if test="../@Type = 'Bulleted'">
				<xsl:text>* </xsl:text>
			</xsl:if>
			<xsl:if test="../@Type = 'Numbered'">
				<xsl:value-of select="position()"/><xsl:text>. </xsl:text>
			</xsl:if>
			
			<xsl:call-template name="escape-string">
				<xsl:with-param name="text" select="text()"/>
				<xsl:with-param name="characters">\'</xsl:with-param>
				<xsl:with-param name="escape-character">\</xsl:with-param>
			</xsl:call-template>
			
			<xsl:text>'."\n";&#13;&#10;</xsl:text>
			
		</xsl:for-each>
		
	</xsl:template>
</xsl:stylesheet>
