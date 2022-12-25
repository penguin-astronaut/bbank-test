<?xml version="1.0" encoding="utf-8" ?>

<xsl:stylesheet version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="payments">
        <html>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">Дата</th>
                        <th scope="col">Процент</th>
                        <th scope="col">Платёж</th>
                        <th scope="col">Остаток</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="payment">
                        <tr>
                            <td><xsl:value-of select="date"/></td>
                            <td><xsl:value-of select="percent"/></td>
                            <td><xsl:value-of select="pay"/></td>
                            <td><xsl:value-of select="sum"/></td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>
        </html>
    </xsl:template>
</xsl:stylesheet>