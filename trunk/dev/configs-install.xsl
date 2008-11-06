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
										<xsl:text disable-output-escaping="yes">&lt;?php </xsl:text>if ($GLOBALS['Form_<xsl:value-of select="@Variable"/>']<xsl:text disable-output-escaping="yes"> == 'true') echo ' checked="checked"'; ?&gt;</xsl:text>
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
												<xsl:text disable-output-escaping="yes">&#13;&#10;&lt;option value="</xsl:text>
												<xsl:call-template name="xml-escape-string">
													<xsl:with-param name="text" select="$ChoiceValue"/>
												</xsl:call-template>
												<xsl:text disable-output-escaping="yes">" &lt;?php</xsl:text> if ($GLOBALS['Form_<xsl:value-of select="../../@Variable"/>'] == '<xsl:call-template name="escape-string">
													<xsl:with-param name="text" select="$ChoiceValue"/>
													<xsl:with-param name="characters">\'</xsl:with-param>
													<xsl:with-param name="escape-character">\</xsl:with-param>
												</xsl:call-template>') echo 'selected="selected"'; <xsl:text disable-output-escaping="yes">?&gt;&gt;</xsl:text>
												<xsl:call-template name="xml-escape-string">
													<xsl:with-param name="text" select="text()"/>
												</xsl:call-template>
												<xsl:text disable-output-escaping="yes">&lt;/option&gt;</xsl:text>
											</xsl:for-each>
										</select>
									</xsl:when>
									<xsl:when test="@Type='multiline'">
										<textarea id="Input_{@Variable}" name="{@Variable}" rows="15" cols="60"><xsl:text disable-output-escaping="yes">&lt;?php echo htmlentities($GLOBALS['Form_</xsl:text><xsl:value-of select="@Variable"/><xsl:text disable-output-escaping="yes">']); ?&gt;</xsl:text></textarea>
									</xsl:when>
									<xsl:otherwise>
										<!--<input type="text" id="Input_{@Variable}" name="{@Variable}" value="{Default/text()}" size="60"/>-->
										
										<xsl:text disable-output-escaping="yes"><![CDATA[<input type="text" id="Input_]]></xsl:text>
										<xsl:value-of select="@Variable"/>
										<xsl:text disable-output-escaping="yes"><![CDATA[" name="]]></xsl:text>
										<xsl:value-of select="@Variable"/>
										<xsl:text disable-output-escaping="yes"><![CDATA[" value="]]></xsl:text>
										
										<xsl:text disable-output-escaping="yes">&lt;?php echo htmlentities($GLOBALS['Form_</xsl:text><xsl:value-of select="@Variable"/><xsl:text disable-output-escaping="yes">']); ?&gt;</xsl:text>
										
										<xsl:text disable-output-escaping="yes"><![CDATA[" size="60"/> ]]></xsl:text>
									</xsl:otherwise>
								</xsl:choose>
								<span id="DataFieldInputExtra_{@Variable}"><xsl:text> </xsl:text></span>
							</div>
							
							<xsl:if test="Example">
								<div class="Example"><i>Example: <xsl:value-of select="Example/text()"/></i></div>
							</xsl:if>
						</td>
					</tr>
					<xsl:if test="count(Comment/*[not(@Hidden = 'true')]) &gt; 0">
						<tr>
							<td class="Comment">
								<xsl:apply-templates select="Comment/*[not(@Hidden = 'true')]"/>
							</td>
						</tr>
					</xsl:if>
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
	
	<xsl:template match="Paragraph">
		<p class="CommentParagraph">
			<xsl:apply-templates select="Line"/>
		</p>
	</xsl:template>
	
	<xsl:template match="Line">
		<span class="CommentLine">
			<xsl:if test="@ForceBreak = 'true'">
				<br/>
			</xsl:if>
			<xsl:value-of select="text()"/>
		</span>
	</xsl:template>
	
	<xsl:template match="List">
		<xsl:if test="@Type = 'Bulleted'">
			<ul>
				<xsl:for-each select="Item">
					<li><xsl:value-of select="text()"/></li>
				</xsl:for-each>
			</ul>
		</xsl:if>
		<xsl:if test="@Type = 'Numbered'">
			<ol>
				<xsl:for-each select="Item">
					<li><xsl:value-of select="text()"/></li>
				</xsl:for-each>
			</ol>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
