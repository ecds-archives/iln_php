<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:dc="http://purl.org/dc/elements/1.1/" version="1.0">

  <xsl:output method="html"/>

  <!-- brief listing of link records (in Dublin Core format) -->

  <xsl:template match="/">
    <xsl:apply-templates select="//link_record"/>
  </xsl:template>
  
  <xsl:template match="link_record">
   <xsl:element name="p">
     
     <xsl:element name="table">
       <xsl:element name="tr"><xsl:element name="td">
     
    <xsl:element name="table">
      <xsl:attribute name="border">1</xsl:attribute>
      <xsl:attribute name="width">475</xsl:attribute>
      <xsl:apply-templates />
    </xsl:element> <!-- link_record table -->

   </xsl:element>  <!-- td -->
    
   <xsl:element name="td">
     
   <xsl:element name="p">
     <xsl:element name="a">
      <xsl:attribute name="href">delete_link.php?url=<xsl:value-of select="./dc:identifier"/></xsl:attribute>Delete</xsl:element> <!-- a -->
   </xsl:element> <!-- p -->
    
  <xsl:element name="p">
    <xsl:element name="a">
      <xsl:attribute name="href">modify_link.php?url=<xsl:value-of select="./dc:identifier"/></xsl:attribute>Modify</xsl:element> <!-- a -->
  </xsl:element> <!-- p -->

    </xsl:element> <!-- td -->
   </xsl:element> <!-- tr -->

 </xsl:element> <!-- outer table -->

   </xsl:element> <!-- p -->
  </xsl:template>  <!-- end record -->

  <xsl:template match="dc:title">
    <tr><th>Title:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:subject">
    <tr><th>Subject:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:description">
    <tr><th>Description:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:identifier">
    <tr><th>URL:</th><td>
    <!-- make url clickable, so it's easier for user to check -->
    <xsl:element name="a">
      <xsl:attribute name="href"><xsl:value-of select="."/></xsl:attribute>
      <xsl:value-of select="."/>
    </xsl:element>
  </td></tr>
  </xsl:template>

  <xsl:template match="dc:date">
    <tr><th>Date Submitted:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:contributor">
    <tr><th>Submitted by:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <!-- these fields we most likely will not be using -->
  <xsl:template match="dc:creator">
    <tr><th>Author:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:publisher">
    <tr><th>Publisher:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:type">
    <tr><th>Type:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:format">
    <tr><th>Format:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:source">
    <tr><th>Source:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:language">
    <tr><th>Language:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:relation">
    <tr><th>Relation:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>


  <xsl:template match="dc:coverage">
    <tr><th>Coverage:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

  <xsl:template match="dc:rights">
    <tr><th>Rights:</th><td><xsl:value-of select="."/></td></tr>
  </xsl:template>

</xsl:stylesheet>
