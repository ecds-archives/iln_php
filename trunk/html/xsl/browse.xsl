<?xml version="1.0" encoding="ISO-8859-1"?>  

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
	xmlns:html="http://www.w3.org/TR/REC-html40" 
	xmlns:ino="http://namespaces.softwareag.com/tamino/response2" 
	xmlns:xql="http://metalab.unc.edu/xql/">

<xsl:include href="ilnshared.xsl"/>
<xsl:include href="teihtml-tables.xsl"/>

<<<<<<< browse.xsl

<!-- copied from search.xsl; unnecessary at this point, but used ilnshared -->
<xsl:param name="term">0</xsl:param>
<xsl:param name="term2">0</xsl:param>
<xsl:param name="term3">0</xsl:param>

<!-- construct string to pass search term values to browse via url -->
<xsl:variable name="term_string"><xsl:if test="$term != 0">&amp;term=<xsl:value-of select="$term"/></xsl:if><xsl:if test="$term2 != 0">&amp;term2=<xsl:value-of select="$term2"/></xsl:if><xsl:if test="$term3 != 0">&amp;term3=<xsl:value-of select="$term3"/></xsl:if></xsl:variable>

=======
<xsl:param name="term">0</xsl:param>
<xsl:param name="term2">0</xsl:param>
<xsl:param name="term3">0</xsl:param>

<!-- construct string to pass search term values to browse via url -->
<xsl:variable name="term_string"><xsl:if test="$term != 0">&amp;term=<xsl:value-of select="$term"/></xsl:if><xsl:if test="$term2 != 0">&amp;term2=<xsl:value-of select="$term2"/></xsl:if><xsl:if test="$term3 != 0">&amp;term3=<xsl:value-of select="$term3"/></xsl:if></xsl:variable>



<xsl:param name="pos">0</xsl:param>
<xsl:param name="xql">0</xsl:param>
<xsl:param name="rmode">0</xsl:param>
<xsl:param name="range">0</xsl:param>

<!-- not actually used in browse mode -->
<xsl:variable name="max">0</xsl:variable>
<xsl:variable name="start">0</xsl:variable>

<xsl:variable name="match"><xsl:call-template name="get-match"/></xsl:variable> 
<xsl:variable name="mode_name">Browse</xsl:variable> 
<xsl:variable name="begin_idxql">?_xql=TEI.2//div2[@id='</xsl:variable>
<xsl:variable name="end_idxql">']</xsl:variable>
<xsl:variable name="begin_posxql">?_xql=TEI.2<xsl:choose>
<xsl:when test="contains($xql, 'sortby')">
<xsl:value-of select="substring-before($xql, 'sortby')"/>
</xsl:when>
<xsl:otherwise>
<xsl:value-of select="$xql"/>
</xsl:otherwise>
</xsl:choose>[</xsl:variable>
<xsl:variable name="end_posxql">]<xsl:if test="contains($xql, 'sortby')">sortby<xsl:value-of select="substring-after($xql, 'sortby')"/></xsl:if></xsl:variable>
<xsl:variable name="curxsl" select="$xsl_browse"/>

>>>>>>> 1.2
 <xsl:output method="html"/>  

<xsl:template match="/"> 
  <xsl:apply-templates select="//div1/div2" />

<<<<<<< browse.xsl
   <!-- links to next & previous titles (if present) -->
=======
      <xsl:apply-templates select="//div1/div2" />
   <!-- links to next & previous matches (if specified) -->
>>>>>>> 1.2
  <xsl:call-template name="next-prev" />

</xsl:template> 


<!-- print out the content-->
<xsl:template match="div2">
<!-- get everything under this node -->
  <xsl:apply-templates/> 
</xsl:template>

<!-- display the title -->
<xsl:template match="head">
  <xsl:element name="h1">
   <xsl:apply-templates />
  </xsl:element>
</xsl:template>

<xsl:template match="bibl">
  <xsl:element name="i">
    <xsl:value-of select="title"/>,
  </xsl:element>
  <xsl:value-of select="biblScope[@type='volume']"/>,
  <xsl:value-of select="biblScope[@type='issue']"/>,
  <xsl:value-of select="biblScope[@type='pages']"/>.<br/>
  <p><xsl:value-of select="date"/></p>
</xsl:template>

<xsl:template match="p/title">
  <xsl:element name="i">
    <xsl:apply-templates />
  </xsl:element>
</xsl:template>  

<xsl:template match="p">
  <xsl:element name="p">
    <xsl:apply-templates /> 
  </xsl:element>
</xsl:template>

<xsl:template match="q">
  <xsl:element name="blockquote">
    <xsl:apply-templates /> 
  </xsl:element>
</xsl:template>


<!-- convert rend tags to their html equivalents 
     so far, converts: center, italic,smallcaps   -->
<xsl:template match="//*[@rend]">
  <xsl:choose>
    <xsl:when test="@rend='center'">
      <xsl:element name="center">
        <xsl:apply-templates/>
      </xsl:element>
    </xsl:when>
    <xsl:when test="@rend='italic'">
      <xsl:element name="i">
        <xsl:apply-templates/>
      </xsl:element>
    </xsl:when>
    <xsl:when test="@rend='smallcaps'">
      <xsl:element name="span">
        <xsl:attribute name="class">smallcaps</xsl:attribute>
        <xsl:apply-templates/>
      </xsl:element>
    </xsl:when>
  </xsl:choose>
</xsl:template>

<xsl:template match="lb">
  <xsl:element name="br" />
</xsl:template>


<!-- generate next & previous links (if present) -->
<!-- note: all div2s, with id, head, and bibl are retrieved in a <siblings> node -->
<xsl:template name="next-prev">
<xsl:variable name="main_id"><xsl:value-of select="//div1/div2/@id"/></xsl:variable>
<!-- get the position of the current document in the siblings list -->
<xsl:variable name="position">
  <xsl:for-each select="//siblings/div2">
    <xsl:if test="@id = $main_id">
      <xsl:value-of select="position()"/>
    </xsl:if>
  </xsl:for-each>
</xsl:variable>

<xsl:element name="table">
  <xsl:attribute name="width">100%</xsl:attribute>

<!-- display articles relative to position of current article -->

  <xsl:apply-templates select="//siblings/div2[$position - 1]">
    <xsl:with-param name="mode">Previous</xsl:with-param>
  </xsl:apply-templates>

  <xsl:apply-templates select="//siblings/div2[$position + 1]">
    <xsl:with-param name="mode">Next</xsl:with-param>
  </xsl:apply-templates>

</xsl:element> <!-- table -->
=======
<xsl:variable name="main_id"><xsl:value-of select="//div1/div2/@id"/></xsl:variable>
<xsl:variable name="position">
  <xsl:for-each select="//siblings/div2">
    <xsl:if test="@id = $main_id">
      <xsl:value-of select="position()"/>
    </xsl:if>
  </xsl:for-each>
</xsl:variable>

<xsl:element name="table">
  <xsl:attribute name="width">100%</xsl:attribute>

  <xsl:apply-templates select="//siblings/div2[$position - 1]">
    <xsl:with-param name="mode">Previous</xsl:with-param>
  </xsl:apply-templates>

  <xsl:apply-templates select="//siblings/div2[$position + 1]">
    <xsl:with-param name="mode">Next</xsl:with-param>
  </xsl:apply-templates>

</xsl:element> <!-- table -->
>>>>>>> 1.2

</xsl:template>

<<<<<<< browse.xsl
<!-- print next/previous link with title & summary information -->
<xsl:template match="siblings/div2">
<xsl:param name="mode"/>

<xsl:element name="tr">
<!--   <xsl:element name="td">
 <xsl:attribute name="align">
 <xsl:choose>
  <xsl:when test="$mode = 'Previous'">left</xsl:when>
  <xsl:when test="$mode = 'Next'">right</xsl:when>
 </xsl:choose>
 </xsl:attribute>  -->

 <xsl:element name="th">
  <xsl:attribute name="valign">top</xsl:attribute>
   <xsl:attribute name="align">left</xsl:attribute>
<!--    <xsl:choose>
     <xsl:when test="$mode = 'Previous'">&lt;- </xsl:when>
     <xsl:when test="$mode = 'Next'">-&gt; </xsl:when>
   </xsl:choose> -->
   <xsl:value-of select="concat($mode, ': ')"/>
 </xsl:element> <!-- th -->
=======
<xsl:template match="siblings/div2">
<xsl:param name="mode"/>

<xsl:element name="tr">
<!--   <xsl:element name="td">
 <xsl:attribute name="align">
 <xsl:choose>
  <xsl:when test="$mode = 'Previous'">left</xsl:when>
  <xsl:when test="$mode = 'Next'">right</xsl:when>
 </xsl:choose>
 </xsl:attribute>  -->

 <xsl:element name="th">
  <xsl:attribute name="valign">top</xsl:attribute>
   <xsl:attribute name="align">left</xsl:attribute>
<!--    <xsl:choose>
     <xsl:when test="$mode = 'Previous'">&lt;- </xsl:when>
     <xsl:when test="$mode = 'Next'">-&gt; </xsl:when>
   </xsl:choose> -->
   <xsl:value-of select="concat($mode, ': ')"/>
 </xsl:element> <!-- th -->
>>>>>>> 1.2

 <xsl:element name="td">
  <xsl:attribute name="valign">top</xsl:attribute>
  <xsl:element name="a">
   <xsl:attribute name="href">browse.php?id=<xsl:value-of
		select="@id"/></xsl:attribute>
    <xsl:value-of select="./head"/>
  </xsl:element> <!-- a -->   
  </xsl:element> <!-- td -->
 
  <xsl:element name="td">
  <xsl:attribute name="valign">top</xsl:attribute>
    <xsl:value-of select="./@type"/>
  </xsl:element> <!-- td -->
  
  <xsl:element name="td">
  <xsl:attribute name="valign">top</xsl:attribute>
  <xsl:element name="font">
   <xsl:attribute name="size">-1</xsl:attribute> 
  <xsl:value-of select="bibl/biblScope[@type='volume']"/>,
  <xsl:value-of select="bibl/biblScope[@type='issue']"/>,
  <xsl:value-of select="bibl/biblScope[@type='pages']"/>.
  (<xsl:value-of select="bibl/extent"/>) 
  </xsl:element> <!-- font -->

 </xsl:element> <!-- td -->
</xsl:element> <!-- tr -->

</xsl:template>


</xsl:stylesheet>