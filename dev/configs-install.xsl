<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" omit-xml-declaration="yes"/>
    
    <xsl:template match="/">
        <xsl:apply-templates select="/Configs/Section"/>
    </xsl:template>
    
    <xsl:template match="Section">
        <h2>General</h2>
        <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
            <xsl:apply-templates select="Config"/>
        </table>
    </xsl:template>
    
    <xsl:template match="Config">
        <tr>
            <td class="VariableName" nowrap="nowrap" valign="top"><b><xsl:value-of select="@Label"/>:</b></td>
            <td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                <tr>
                    <td class="DataField">
                        <xsl:choose>
                            <xsl:when test="@Type='boolean'"><input type="checkbox" name="XX"/> Yes</xsl:when>
                            <xsl:otherwise><input type="text" name="XX" value="{Default/text()}"/></xsl:otherwise>
                        </xsl:choose>
                        <xsl:if test="Example">
                            <xsl:text> </xsl:text>
                            <i>Example: <xsl:value-of select="Example/text()"/></i>
                        </xsl:if>
                    </td>
                </tr>
                <tr>
                    <td class="Comment">
                        <xsl:for-each select="Comment/Line">
                            <!--<xsl:if test="position() &gt; 1"><br/></xsl:if>-->
                            <xsl:value-of select="text()"/>
                        </xsl:for-each>
                    </td>
                </tr>
                <xsl:if test="count(Dependants/Config) &gt; 0">
                    <tr>
                        <td>
                            <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                                <xsl:apply-templates select="Dependants/Config"/>
                            </table>
                        </td>
                    </tr>
                </xsl:if>
            </table></td>
        </tr>
    </xsl:template>
</xsl:stylesheet>
