<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

  <xsl:output method="html"/>

  <xsl:template match="/">
    <xsl:apply-templates select="//subject_list"/>
  </xsl:template>

  <xsl:template match="subject_list">
    <xsl:element name="ul">
      <xsl:apply-templates/>
    </xsl:element>
  </xsl:template>

<!-- display a list of subjects -->
  <xsl:template match="dc:subject">
    <xsl:element name="li">
      <xsl:value-of select="."/>
    </xsl:element>
  </xsl:template>

</xsl:stylesheet>
