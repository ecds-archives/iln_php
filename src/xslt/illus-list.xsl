<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
  xmlns:exist="http://exist.sourceforge.net/NS/exist"
  version="1.0" exclude-result-prefixes="exist">

  <xsl:output method="xml" omit-xml-declaration="yes"/>

<xsl:variable
    name="image_url">http://beck.library.emory.edu/iln/image-content/</xsl:variable>

<xsl:template match="/">
      <p class="info">Click on the title to view the whole
      article.<br/>
      Click on the thumbnail
      to view the image.</p>
  <xsl:element name="table">  
    <xsl:apply-templates/>
  </xsl:element>
</xsl:template>

<xsl:template match="div2">
  <xsl:element name="tr">
    <xsl:attribute name="class">item</xsl:attribute>
    <xsl:call-template name="thumb"/>
    <xsl:call-template name="biblio"/>
  </xsl:element> <!-- end row -->
</xsl:template>

<xsl:template name="biblio">
  <xsl:element name="td">
    <xsl:attribute name="class">title</xsl:attribute>
    <xsl:element name="a">
	  <xsl:attribute name="href">browse.php?id=<xsl:value-of
	select="@id"/></xsl:attribute>
	      <xsl:if test="@type='Article'">
	      <xsl:apply-templates select="head" mode="table"/>
	      </xsl:if>
	      <xsl:if test="@type='Illustration'">
	  <xsl:apply-templates select="figure/head" mode="table"/>
	      </xsl:if>
    </xsl:element> <!-- end a -->
      
        <xsl:element name="br"/> 
	<xsl:element name="font">
 <xsl:attribute name="size">-1</xsl:attribute>
  <xsl:value-of select="bibl/biblScope[@type='volume']" />,
  <xsl:value-of select="bibl/biblScope[@type='issue']" />,  
  <xsl:value-of select="bibl/biblScope[@type='pages']" />.  
  <xsl:value-of select="bibl/date" /> 
  - <xsl:value-of select="./@type"/>
  <xsl:if test="bibl/extent">
      - (<xsl:value-of select="bibl/extent" />)
  </xsl:if>
        <xsl:element name="br"/> 
	  <xsl:if test="@type='Article'">
	    <xsl:text>Article title: </xsl:text>
	    <xsl:apply-templates select="head"/>
	  </xsl:if>
  </xsl:element> <!-- end font --></xsl:element>
</xsl:template>


<!--display figure & link to image-viewer  (slightly different than ilnshared) -->
<xsl:template name="thumb">
      <!-- <xsl:element name="tr"> -->
        <xsl:element name="td">
          <xsl:attribute name="class">figure</xsl:attribute>

<!-- javascript version of the image & link -->

      <xsl:element name="a">
	<xsl:attribute
name="href">javascript:launchViewer('figure.php?id=<xsl:value-of
select="figure/@entity"/>')</xsl:attribute>

<xsl:element name="img">
  <xsl:attribute name="class">javascript</xsl:attribute>
  <xsl:attribute name="src"><xsl:value-of select="concat($image_url, 'ILN', figure/@entity, '.gif')"/></xsl:attribute>
  <xsl:attribute name="alt">view image</xsl:attribute>
  <xsl:attribute name="title"><xsl:value-of select="normalize-space(head)"/></xsl:attribute>
  </xsl:element> <!-- end img -->
  </xsl:element> <!-- end a --> 


<!-- non-javascript version of image & link -->
<!-- note: if neither javascript nor css works, there will be two
   copies of image (but other things will probably be broken also) -->
  <noscript>
      <xsl:element name="a">
<!--  <xsl:attribute name="href"><xsl:value-of
select="concat($image_url, 'ILN', @entity, '.jpg')"/></xsl:attribute> -->
	<xsl:attribute name="href">figure.php?id=<xsl:value-of select="figure/@entity"/></xsl:attribute>
        <xsl:attribute name="target">web/image_viewer</xsl:attribute>
        <!-- open a new window without javascript -->
  <xsl:element name="img"> 


  <xsl:attribute name="src"><xsl:value-of select="concat($image_url, 'ILN', figure/@entity, '.gif')"/></xsl:attribute>
  <xsl:attribute name="alt">view image</xsl:attribute>
  </xsl:element> <!-- end img -->
  </xsl:element> <!-- end a --> 
 </noscript> 

  </xsl:element> <!-- end td -->
</xsl:template>

</xsl:stylesheet>
