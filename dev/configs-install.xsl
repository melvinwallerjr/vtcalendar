<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" omit-xml-declaration="yes" indent="yes"/>

	<xsl:template match="/">
		<xsl:apply-templates select="/Configs/Section"/>
	</xsl:template>

	<xsl:template match="Section">
		<h2><xsl:value-of select="@Label"/>:</h2>
		<blockquote>
			<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
				<xsl:apply-templates select="Config"/>
			</table>
		</blockquote>
	</xsl:template>

	<xsl:template match="Config">
		<xsl:variable name="CheckboxJS">
			<xsl:if test="count(Dependants/Config) &gt; 0">ToggleDependant('<xsl:value-of select="@Variable"/>');</xsl:if>
		</xsl:variable>

		<tr>
			<td class="VariableName" nowrap="nowrap" valign="top">
				<b><xsl:value-of select="@Label"/>:</b>
			</td>
			<td class="VariableBody">
				<table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
					<tr>
						<td class="DataField">
							<xsl:choose>
								<xsl:when test="@Type='boolean'">
									<xsl:text disable-output-escaping="yes"><![CDATA[<input type="checkbox" id="CheckBox_]]></xsl:text><xsl:value-of select="@Variable"/><![CDATA[" name="]]><xsl:value-of select="@Variable"/><![CDATA[" value="true"]]>
									<xsl:if test="string-length($CheckboxJS) &gt; 0">onclick="<xsl:value-of select="$CheckboxJS"/>" onchange="<xsl:value-of select="$CheckboxJS"/>"</xsl:if>
									<xsl:if test="Default/text() = 'true'"> checked="checked"</xsl:if>
									<xsl:text disable-output-escaping="yes"><![CDATA[/>]]></xsl:text>
									<label for="CheckBox_{@Variable}"> Yes</label>
								</xsl:when>
								<xsl:otherwise>
									<input type="text" name="{@Variable}" value="{Default/text()}" size="60"/>
								</xsl:otherwise>
							</xsl:choose>
							<xsl:if test="Example">
								<br/><i>Example: <xsl:value-of select="Example/text()"/></i>
							</xsl:if>
						</td>
					</tr>
					<tr>
						<td class="Comment">
							<xsl:for-each select="Comment/Line">
								<xsl:if test="position() &gt; 1"><br/></xsl:if>
								<xsl:value-of select="text()"/>
							</xsl:for-each>
						</td>
					</tr>
					<xsl:if test="count(Dependants/Config) &gt; 0">
						<tr id="Dependants_{@Variable}">
							<td>
								<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
									<xsl:apply-templates select="Dependants/Config"/>
								</table>
								<script type="text/javascript">
									<xsl:value-of select="$CheckboxJS"/>
								</script>
							</td>
						</tr>
					</xsl:if>
				</table>
			</td>
		</tr>
	</xsl:template>
</xsl:stylesheet>
