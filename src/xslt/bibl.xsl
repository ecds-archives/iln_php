<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

  <xsl:output method="xml"/>

  <!-- brief listing of link records (in Dublin Core format) -->

  <xsl:template match="/">
    <xsl:apply-templates select="//biblRecord"/>
  </xsl:template>
  
  <xsl:template match="biblRecord">
    <xsl:element name="p">
        <xsl:value-of select="dc:creator"/><xsl:text>,
	</xsl:text><xsl:value-of
	select="dc:title"/><xsl:text>. </xsl:text>
	<xsl:value-of select="dc:publisher"/>

      
      <xsl:element name="br"/>
      <xsl:element name="font">
        <xsl:attribute name="size">-1</xsl:attribute>
        (<xsl:value-of select="dc:identifier"/>)
      </xsl:element> <!-- font -->
      
      <xsl:element name="br"/>
      
      <xsl:value-of select="dc:description"/>
    </xsl:element> <!-- p -->
  </xsl:template>  <!-- end record -->
  
</xsl:stylesheet>
