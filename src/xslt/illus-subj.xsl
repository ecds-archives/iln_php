<?xml version="1.0" encoding="ISO-8859-1"?>  
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0"
	xmlns:html="http://www.w3.org/TR/REC-html40" 
	xmlns:ino="http://namespaces.softwareag.com/tamino/response2" 
	xmlns:xql="http://metalab.unc.edu/xql/">

<xsl:include href="ilnshared.xsl"/>
<xsl:include href="teihtml-tables.xsl"/>

 <xsl:output method="xml"/>  

<xsl:template match="/">
	      <xsl:apply-templates select="interpGrp"/>
</xsl:template>

<xsl:template match="interGrp">
<xsl:element name="ul">
<xsl:element name="li">
<xsl:apply-templates select="@type"/>
<xsl:element name="ul">
<xsl:element name="li">
<xsl:apply-templates select="interp/@value"/>
</xsl:element>
</xsl:element>
</xsl:element>
</xsl:element>
</xsl:template>
</xsl:stylesheet>