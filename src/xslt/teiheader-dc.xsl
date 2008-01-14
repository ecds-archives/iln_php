<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:dcterms="http://purl.org/dc/terms"
                version="1.0">

  <xsl:output method="xml" omit-xml-declaration="yes"/>
  <xsl:variable name="baseurl">http://beck.library.emory.edu/</xsl:variable>
  <xsl:variable name="siteurl">iln</xsl:variable>

  <xsl:param name="qualified">true</xsl:param>



  <xsl:template match="/">
    <dc>
      <xsl:call-template name="article-info"/>
      <xsl:call-template name="issue-info"/>
      <xsl:call-template name="common-fields"/>
    </dc>
  </xsl:template>


 	
  <!-- static fields for all records-->
  <xsl:template name="common-fields">
    <dc:language>English</dc:language>
    <dc:subject>
      <xsl:if test="$qualified='true'">
        <xsl:attribute name="scheme">LSCH</xsl:attribute>
      </xsl:if>
      <xsl:text>United States--History--Civil War, 1861-1865--Sources.</xsl:text>
    </dc:subject>
    <dc:subject>
      <xsl:if test="$qualified = 'true'">
        <xsl:attribute name="scheme">LSCH</xsl:attribute>
      </xsl:if>
      <xsl:text>United States--History--Civil War, 1861-1865--Foreign public opinion.</xsl:text>
    </dc:subject>
    <dc:subject>
      <xsl:if test="$qualified = 'true'">
        <xsl:attribute name="scheme">LSCH</xsl:attribute>
      </xsl:if>
      <xsl:text>United States--Politics and government--1861-1865.</xsl:text>
    </dc:subject>

    <dc:type>Text</dc:type>
    <dc:format>text/xml</dc:format>
  </xsl:template>
  

  <xsl:template name="article-info">
    <xsl:element name="dc:title">
      <xsl:apply-templates select=".//div2/head"/>
    </xsl:element>
    <xsl:element name="dc:source">
      <!-- process all elements, in this order. -->
      <xsl:apply-templates select=".//div2/bibl/title"/>
      <xsl:apply-templates select=".//div2/bibl/biblScope[@type='volume']"/>
      <xsl:apply-templates select=".//div2/bibl/biblScope[@type='issue']"/>
      <xsl:apply-templates select=".//div2/bibl/biblScope[@type='pages']"/>
      <xsl:apply-templates select=".//div2/bibl/date"/>
    </xsl:element>
     <xsl:element name="dc:identifier">
      <xsl:apply-templates select=".//div2/bibl/idno[@type='ark']"/>
    </xsl:element>
  </xsl:template>

  <!-- format bibl elements -->
  <xsl:template match="bibl">
    <xsl:value-of select="title"/><xsl:text>, </xsl:text>
    <xsl:value-of select="biblScope[@type='volume']"/><xsl:text>, </xsl:text>
    <xsl:value-of select="biblScope[@type='issue']"/><xsl:text>, </xsl:text>
    <xsl:value-of
      select="biblScope[@type='pages']"/><xsl:text>, </xsl:text>
    <xsl:value-of select="date"/><xsl:text>. </xsl:text>
  </xsl:template>

<xsl:template name="issue-info">
  <!-- <xsl:apply-templates select="TEI/teiHeader"/> -->
  <!-- specific to ILN : Sandra Still's name should show up -->
    <xsl:element name="dc:contributor">
      <xsl:apply-templates select=".//titleStmt/respStmt/resp"/><xsl:text> </xsl:text><xsl:apply-templates select=".//titleStmt/respStmt/name"/>
    </xsl:element>
  <!-- publisher -->
    <xsl:element name="dc:publisher">  <xsl:apply-templates select=".//publicationStmt/publisher"/>, <xsl:value-of select=".//publicationStmt/pubPlace"/>. <xsl:apply-templates select=".//publicationStmt/date"/>: <xsl:apply-templates select=".//publicationStmt/address/addrLine"/>.</xsl:element> 
    <!-- pick up rights statement --> 
    <xsl:apply-templates select=".//availability"/>

    <xsl:choose>
      <xsl:when test="$qualified = 'true'">
        <xsl:element name="dcterms:issued">
          <xsl:apply-templates select=".//publicationStmt/date"/>
        </xsl:element>
      </xsl:when>
      <xsl:otherwise>
        <xsl:element name="dc:date">
          <xsl:apply-templates select=".//publicationStmt/date"/>
        </xsl:element>
      </xsl:otherwise>
    </xsl:choose>
  
  <xsl:choose>
    <xsl:when test="$qualified = 'true'">
      <xsl:element name="dcterms:isPartOf"><xsl:apply-templates select=".//seriesStmt/title"/></xsl:element>
      
      <xsl:element name="dcterms:isPartOf">
        <xsl:attribute name="scheme">URI</xsl:attribute>
        <xsl:text>http://beck.library.emory.edu/iln/</xsl:text>
      </xsl:element>
    </xsl:when>
    <xsl:otherwise>
      <!-- FIXME: should both be included for unqualified dublin core? -->
      <xsl:element name="dc:relation"><xsl:value-of select=".//seriesStmt/title"/></xsl:element>
      <xsl:element name="dc:relation">http://beck.library.emory.edu/iln/</xsl:element>
    </xsl:otherwise>
  </xsl:choose>
  
  </xsl:template>

  <!-- ignore for now; do these fit anywhere? -->
  <xsl:template match="publicationStmt/address"/>
  <xsl:template match="publicationStmt/pubPlace|imprint/pubPlace|pubPlace"/>
  <xsl:template match="respStmt"/>

  <xsl:template match="availability">
    <xsl:element name="dc:rights">
      <xsl:apply-templates/>
    </xsl:element>
  </xsl:template>

<!--  <xsl:template match="seriesStmt/title">

 </xsl:template>-->
<!--
  <xsl:template match="sourceDesc/bibl">
    <xsl:element name="dc:source"> -->
      <!-- process all elements, in this order. -->
<!--      <xsl:apply-templates select="title"/>
      <xsl:apply-templates select="biblScope"/>
      <xsl:apply-templates select="date"/> -->
      <!-- in case source is in plain text, without tags -->
<!--      <xsl:apply-templates select="text()"/>
    </xsl:element>
  </xsl:template>
-->
  <!-- formatting for bibl elements, to generate a nice citation. -->
  <xsl:template match="bibl/author"><xsl:apply-templates/>. </xsl:template>
  <xsl:template match="bibl/title">
    <xsl:apply-templates/>
    <xsl:if test="not(contains(., '.'))"><xsl:text>.</xsl:text></xsl:if>	<!-- hack; add period? -->
    <xsl:text> </xsl:text>
  </xsl:template>  

   <xsl:template match="bibl/editor">
    <xsl:text>Ed. </xsl:text><xsl:apply-templates/><xsl:text>. </xsl:text> 
  </xsl:template> 
  <xsl:template match="bibl/pubPlace">
    <xsl:if test=". != ''">
      <xsl:apply-templates/>
      <xsl:text>: </xsl:text>
    </xsl:if>
  </xsl:template> 
  <xsl:template match="bibl/biblScope"> 
    <xsl:if test=". != ''"><xsl:apply-templates/>, </xsl:if>
  </xsl:template> 
  <xsl:template match="bibl/date"><xsl:apply-templates/>.</xsl:template>


  <!-- generic description, same on all records - don't include -->
  <xsl:template match="encodingDesc/projectDesc"/>

  <!-- ark identifier -->
<!--  <xsl:template match="idno[@type='ark']">
    <xsl:element name="dc:identifier">
      <xsl:value-of select="."/>
    </xsl:element>
  </xsl:template> -->

  <!-- ignore other rs types for now -->
  <xsl:template match="profileDesc/creation/rs[@type!='geography']"/>

  <!-- ignore these: encoding specific information -->
  <xsl:template match="encodingDesc/tagsDecl"/>
  <xsl:template match="encodingDesc/refsDecl"/>
  <xsl:template match="encodingDesc/editorialDecl"/>
  <xsl:template match="revisionDesc"/>

  <!-- ignore header title -->
  <xsl:template match="titleStmt/title"/>
  <!-- ignore div2 elements outside of template -->
  <!--<xsl:template match="div2/head"/>-->
  <xsl:template match="div2/bibl"/>

  <!-- do nothing with these -->
   <xsl:template match="div2/p"/>
    <xsl:template match="issueid"/>
     <xsl:template match="siblings"/>
  <!-- ignore bibls within the text for now -->
  <xsl:template match="text//bibl"/>

  <!-- normalize space for all text nodes -->
  <xsl:template match="text()">
    <xsl:value-of select="normalize-space(.)"/>
  </xsl:template>


</xsl:stylesheet>
