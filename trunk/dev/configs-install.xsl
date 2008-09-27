<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:output method="xml" omit-xml-declaration="yes" indent="yes"/>
	
	<!-- Include the search and replace named template. -->
	<xsl:include href="common-escape-string.xsl" />

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
							
							<div class="DataFieldInput">
								<xsl:choose>
									<xsl:when test="@Type='boolean'">
										<xsl:text disable-output-escaping="yes"><![CDATA[<input type="checkbox" id="CheckBox_]]></xsl:text><xsl:value-of select="@Variable"/><![CDATA[" name="]]><xsl:value-of select="@Variable"/><![CDATA[" value="true"]]>
										<xsl:if test="string-length($CheckboxJS) &gt; 0">onclick="<xsl:value-of select="$CheckboxJS"/>" onchange="<xsl:value-of select="$CheckboxJS"/>"</xsl:if>
										<xsl:if test="Default/text() = 'true'"> checked="checked"</xsl:if>
										<xsl:text disable-output-escaping="yes"><![CDATA[/>]]></xsl:text>
										<label for="CheckBox_{@Variable}"> Yes</label>
									</xsl:when>
									<xsl:when test="count(Choices/Choice) &gt; 0">
										<select name="{@Variable}" id="Input_{@Variable}">
											<xsl:for-each select="Choices/Choice">
												<xsl:variable name="ChoiceValue">
													<xsl:choose>
														<xsl:when test="@Value"><xsl:value-of select="@Value"/></xsl:when>
														<xsl:otherwise><xsl:value-of select="text()"/></xsl:otherwise>
													</xsl:choose>
												</xsl:variable>
												<xsl:choose>
													<xsl:when test="$ChoiceValue = ../../Default/text()">
														<option value="{$ChoiceValue}" selected="selected"><xsl:value-of select="text()"/></option>
													</xsl:when>
													<xsl:otherwise>
														<option value="{$ChoiceValue}"><xsl:value-of select="text()"/></option>
													</xsl:otherwise>
												</xsl:choose>
											</xsl:for-each>
										</select>
									</xsl:when>
									<xsl:otherwise>
										<!--<input type="text" id="Input_{@Variable}" name="{@Variable}" value="{Default/text()}" size="60"/>-->
										
										<xsl:text disable-output-escaping="yes"><![CDATA[<input type="text" id="Input_]]></xsl:text>
										<xsl:value-of select="@Variable"/>
										<xsl:text disable-output-escaping="yes"><![CDATA[" name="]]></xsl:text>
										<xsl:value-of select="@Variable"/>
										<xsl:text disable-output-escaping="yes"><![CDATA[" value="]]></xsl:text>
										
										<!--<xsl:call-template name="xml-escape-string">
											<xsl:with-param name="text" select="Default/text()"/>
										</xsl:call-template>-->
										
										<xsl:text disable-output-escaping="yes">&lt;?php </xsl:text>echo htmlentities($Form_<xsl:value-of select="@Variable"/><xsl:text disable-output-escaping="yes">); ?&gt;</xsl:text>
										
										<xsl:text disable-output-escaping="yes"><![CDATA[" size="60"/> ]]></xsl:text>
									</xsl:otherwise>
								</xsl:choose>
								<span id="DataFieldInputExtra_{@Variable}"></span>
							</div>
							
							<xsl:if test="Example">
								<div class="Example"><i>Example: <xsl:value-of select="Example/text()"/></i></div>
							</xsl:if>
						</td>
					</tr>
					<tr>
						<td class="Comment">
							<xsl:for-each select="Comment/Line[not(@Hidden = 'true')]">
								<div class="CommentLine">
									<xsl:value-of select="text()"/>
								</div>
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
