<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

  <xsl:output method="html"/>

  <xsl:template match="/">
    <xsl:apply-templates select="//subject_list"/>
  </xsl:template>

<!-- generate a list of options for subject selection in addlink form -->
  <xsl:template match="dc:subject">
    <xsl:element name="option">
      <xsl:attribute name="value">
        <xsl:value-of select="."/>
      </xsl:attribute>
      <xsl:value-of select="."/>
    </xsl:element>
  </xsl:template>

</xsl:stylesheet>
