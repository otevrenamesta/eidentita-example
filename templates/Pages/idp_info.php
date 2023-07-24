<?php
/**
 * @var $this AppView
 * @var $title string
 */

use App\View\AppView; ?>
<h1><?= $title ?></h1>

<p>NIA (poskytována organizací SZRČR) je ve smyslu SAML služeb IdP, tedy poskytovatel identit.

<p>Pro integraci lze využít následující standardy komunikace

<ol>
    <li>
        <a target="_blank" href="https://cs.wikipedia.org/wiki/Security_Assertion_Markup_Language"
           title="Security Assertion Markup Language - Wikipedia">SAML2 Core</a> /
        <a target="_blank" title="electronic IDentification, Authentication and trust Services - Wikipedia"
           href="https://cs.wikipedia.org/wiki/EIDAS">eIDAS</a>
    </li>
    <li>
        <a title="Web Services Federation Language - Wikipedia" target="_blank"
           href="https://en.wikipedia.org/wiki/WS-Federation">WS-Federation</a>
    </li>
</ol>

<p>Abychom se mohli integrovat s IdP, je třeba pochopit poskytované služby a rozhraní, k tomu slouží IdP metadata.
<p>Dle <a href="https://info.identitaobcana.cz/download/SeP_PriruckaKvalifikovanehoPoskytovatele.pdf">příručky
        SeP</a> jsou metadata na těchto adresách

<ol>
    <li>Testovací prostředí: <a target="_blank"
                                href="https://tnia.identitaobcana.cz/fpsts/FederationMetadata/2007-06/FederationMetadata.xml">https://tnia.identitaobcana.cz/fpsts/FederationMetadata/2007-06/FederationMetadata.xml</a>
    </li>
    <li>Produkční prostředí: <a target="_blank"
                                href="https://nia.identitaobcana.cz/fpsts/FederationMetadata/2007-06/FederationMetadata.xml">https://nia.identitaobcana.cz/fpsts/FederationMetadata/2007-06/FederationMetadata.xml</a>
    </li>
</ol>

<h2>Ukázka XML metadat (testovací prostředí)</h2>
<pre><code class="xml">&lt;?xml version="1.0"?>
&lt;!-- Sekce s podpisem a kontrolním součtem obsahu dokumentu (rsa-sha256) dle specifikace xmldsig --&gt;

&lt;EntityDescriptor xmlns="urn:oasis:names:tc:SAML:2.0:metadata" ID="_b931baf7-9318-49cc-be37-d347ecf24a44" entityID="urn:microsoft:cgg2010:fpsts">
  &lt;Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
    &lt;SignedInfo>
      &lt;CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/>
      &lt;SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"/>
      &lt;Reference URI="#_b931baf7-9318-49cc-be37-d347ecf24a44">
        &lt;Transforms>
          &lt;Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
          &lt;Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/>
        &lt;/Transforms>
        &lt;DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"/>
        &lt;DigestValue>C3CAUoTaZ59+kAthzBU2Puz65hrvzwcINxHxrBOuhwk=&lt;/DigestValue>
      &lt;/Reference>
    &lt;/SignedInfo>
    &lt;SignatureValue>ElTkmNlB0ybN4LRT33Vf/FO57WxuQHLA8tPg0tuMUcx3NkTUGQ2IkcQS+8raGkp2ExTXeywUAolerK5h9cbKclyjRB6d01zE5QbynRP1kVVsIapRDO2G22jljFwTXyJrQs1jtgoZPN/6flhVlG77JnBNjy/EZKY8swHfwTpniqqfwinfd6vvoyMLxUkKg4b8Aif6wHIjaYyanEQAvNZeWfqAB2yIo15gJmdK3y5jdZCoODm5lfeHnVx3dRgZQZo6M+zVS5UmPJAPX7W8cAZSso6JGu2YX3pC/TpcOnk6PXYVW9XXtpecmnIqTpSriDM8wnyw9EEkDQPMdMl7exygag==&lt;/SignatureValue>
    &lt;KeyInfo>
      &lt;X509Data>
        &lt;X509Certificate>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&lt;/X509Certificate>
      &lt;/X509Data>
    &lt;/KeyInfo>
  &lt;/Signature>

 &lt;!-- Metadata pro kofiguraci protistrany komunikující protokolem WS-Federation --&gt;

  &lt;RoleDescriptor xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:fed="http://docs.oasis-open.org/wsfed/federation/200706" xsi:type="fed:SecurityTokenServiceType" protocolSupportEnumeration="http://docs.oasis-open.org/wsfed/federation/200706">
    &lt;KeyDescriptor use="signing">
      &lt;KeyInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
        &lt;X509Data>
          &lt;X509Certificate>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&lt;/X509Certificate>
        &lt;/X509Data>
      &lt;/KeyInfo>
    &lt;/KeyDescriptor>
    &lt;fed:TokenTypesOffered>
      &lt;fed:TokenType Uri="http://schemas.microsoft.com/ws/2006/05/identitymodel/tokens/Saml"/>
    &lt;/fed:TokenTypesOffered>
    &lt;fed:ClaimTypesOffered>
      &lt;auth:ClaimType xmlns:auth="http://docs.oasis-open.org/wsfed/authorization/200706" Uri="http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress">
        &lt;auth:DisplayName>Email address&lt;/auth:DisplayName>
        &lt;auth:Description>The email of the subject.&lt;/auth:Description>
      &lt;/auth:ClaimType>
    &lt;/fed:ClaimTypesOffered>
    &lt;fed:SecurityTokenServiceEndpoint>
      &lt;wsa:EndpointReference xmlns:wsa="http://www.w3.org/2005/08/addressing">
        &lt;wsa:Address>https://tnia.identitaobcana.cz/FPSTS/issue.svc&lt;/wsa:Address>
      &lt;/wsa:EndpointReference>
    &lt;/fed:SecurityTokenServiceEndpoint>
    &lt;fed:PassiveRequestorEndpoint>
      &lt;wsa:EndpointReference xmlns:wsa="http://www.w3.org/2005/08/addressing">
        &lt;wsa:Address>https://tnia.identitaobcana.cz/FPSTS/default.aspx&lt;/wsa:Address>
      &lt;/wsa:EndpointReference>
    &lt;/fed:PassiveRequestorEndpoint>
  &lt;/RoleDescriptor>

 &lt;!-- Metadata pro konfiguraci protistrany komunikující protokolem SAML2.0 dle eIDAS --&gt;

  &lt;IDPSSODescriptor protocolSupportEnumeration="urn:oasis:names:tc:SAML:2.0:protocol">
    &lt;KeyDescriptor use="signing">
      &lt;KeyInfo xmlns="http://www.w3.org/2000/09/xmldsig#">
        &lt;X509Data>
          &lt;X509Certificate>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&lt;/X509Certificate>
        &lt;/X509Data>
      &lt;/KeyInfo>
    &lt;/KeyDescriptor>
    &lt;SingleLogoutService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect" Location="https://tnia.identitaobcana.cz/FPSTS/saml2/basic"/>
    &lt;SingleSignOnService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect" Location="https://tnia.identitaobcana.cz/FPSTS/saml2/basic"/>
    &lt;SingleSignOnService Binding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" Location="https://tnia.identitaobcana.cz/FPSTS/saml2/basic"/>
  &lt;/IDPSSODescriptor>
&lt;/EntityDescriptor>

</code></pre>

<h2>Popis metadat</h2>
<ul>
    <li>Metadata obsahují konfiguraci jak pro klienta podporujícího specifikaci SAML2 Core, tak pro WS-Federation</li>
    <li><code style="background-color: #eee">/RoleDescriptor</code> je popisem služeb pro WS-Federation</li>
    <li><code style="background-color: #eee">/IDPSSODescriptor</code> je popisem služeb pro SAML2</li>
    <li><code style="background-color: #eee">/Signature</code> obsahuje SHA256 hash a podpis, příslušným certifikátem,
        celého dokumentu (dle <code style="background-color: #eee">/Signature/SignedInfo/Reference@URI</code>)
    </li>
    <li><code style="background-color: #eee">/Signature/KeyInfo/X509Data/X509Certificate</code> obsahuje Base64
        enkódovanou DER formu X509 certifikátu (v tomto případě certifikát pro elektronickou pečeť od CA PostSignum)
    </li>
</ul>

<aside>
    <p>
        Pro účely vysvětlení budeme používat SAML, tedy nás zajímá, že v metadatech jsou poskytnuty služby "Logout"
        (režim HTTP-Redirect) a "SignOn" (HTTP-Redirect i HTTP-POST) a URL adresy, na které máme uživatele přesměrovat
        nebo kam máme odeslat data
    </p>
</aside>

<h2>Dekódovaný certifikát z metadat</h2>
<pre><code class="x509">
Certificate:
    Data:
        Version: 3 (0x2)
        Serial Number: 22878349 (0x15d188d)
        Signature Algorithm: sha256WithRSAEncryption
        Issuer: C = CZ, organizationIdentifier = NTRCZ-47114983, O = "\C4\8Cesk\C3\A1 po\C5\A1ta, s.p.", CN = PostSignum Qualified CA 4
        Validity
            Not Before: Mar 28 12:03:24 2023 GMT
            Not After : Apr 16 12:03:24 2024 GMT
        Subject: C = CZ, organizationIdentifier = NTRCZ-72054506, O = Spr\C3\A1va z\C3\A1kladn\C3\ADch registr\C5\AF, CN = GG_FPSTS_TEST, serialNumber = S275730
        Subject Public Key Info:
            Public Key Algorithm: rsaEncryption
                Public-Key: (2048 bit)
                Modulus:
                    00:c1:e3:f0:a8:ad:11:7d:8a:b6:08:22:44:eb:39:
                    45:23:e1:d1:2a:d7:32:dd:8c:3f:ff:0f:b0:cd:bb:
                    13:e6:69:1b:58:b1:d0:07:a9:d2:6a:9e:c0:eb:a7:
                    d2:45:3b:d1:f7:f2:24:7c:4b:87:2f:94:c7:9f:00:
                    d8:dc:c8:17:c3:4f:58:cd:13:de:f3:d5:cc:3c:44:
                    fd:a5:25:47:51:ca:46:85:99:73:4a:fb:1b:9f:f7:
                    77:dc:a3:3b:74:98:85:db:56:60:1f:d0:b3:ed:dd:
                    da:09:84:b0:9c:f8:90:70:be:a7:84:78:e2:60:90:
                    0c:33:3f:b4:30:fe:9a:0e:1b:a8:83:fb:84:0c:82:
                    21:27:43:9a:b5:a0:79:d0:78:b6:ee:07:55:34:24:
                    aa:06:25:11:9f:ea:48:e0:0d:62:0f:3c:4d:c1:f6:
                    2b:76:ad:2b:86:30:9e:ab:95:2e:43:92:a2:00:3b:
                    fc:86:3b:95:2b:04:e5:0b:4a:56:0c:43:1c:15:ff:
                    a2:ae:3b:f6:97:93:ed:67:0c:86:d3:aa:dc:a4:82:
                    98:5b:a9:eb:c2:fd:18:5f:b7:c5:4b:b8:8d:44:bc:
                    68:2b:6c:04:69:ed:38:b6:34:a8:2e:10:fd:e9:bc:
                    27:1c:4c:5f:2d:87:05:e2:da:cd:3a:1b:60:e0:e7:
                    58:21
                Exponent: 65537 (0x10001)
        X509v3 extensions:
            X509v3 Certificate Policies:
                Policy: 2.23.134.1.4.1.18.200
                  User Notice:
                    Explicit Text: Tento kvalifikovany certifikat pro elektronickou pecet byl vydan v souladu s narizenim EU c. 910/2014.This is a qualified certificate for electronic seal according to Regulation (EU) No 910/2014.
                  CPS: http://www.postsignum.cz
                Policy: 0.4.0.194112.1.1
            qcStatements:
                0..0......F..0j.....F..0`0..(https://www.postsignum.cz/pds/pds_en.pdf..en0..(https://www.postsignum.cz/pds/pds_cs.pdf..cs0......F..0......F...
            Authority Information Access:
                CA Issuers - URI:http://crt.postsignum.cz/crt/psqualifiedca4.crt
                OCSP - URI:http://ocsp.postsignum.cz/OCSP/QCA4/
            X509v3 Key Usage: critical
                Digital Signature, Non Repudiation, Key Encipherment
            X509v3 Extended Key Usage:
                E-mail Protection, 1.3.6.1.4.1.311.10.3.12
            X509v3 Authority Key Identifier:
                0F:28:7C:3E:36:00:38:10:50:AE:3D:B8:21:97:8B:F7:60:5C:61:78
            X509v3 CRL Distribution Points:
                Full Name:
                  URI:http://crl.postsignum.cz/crl/psqualifiedca4.crl
                Full Name:
                  URI:http://crl2.postsignum.cz/crl/psqualifiedca4.crl
                Full Name:
                  URI:http://crl.postsignum.eu/crl/psqualifiedca4.crl
            X509v3 Subject Key Identifier:
                33:5C:0F:62:28:A9:CC:C3:57:06:77:E6:77:7D:E7:E6:EA:C9:3F:B0
    Signature Algorithm: sha256WithRSAEncryption
    Signature Value:
        55:24:50:81:26:cb:e4:d8:5a:07:1a:24:02:5f:e6:23:2d:8f:
        71:91:5f:51:53:af:0f:30:6b:a9:26:6b:76:6f:a8:ad:c1:09:
        ce:96:86:51:bf:04:ed:6f:1c:8c:bd:24:d9:77:2b:a8:01:a6:
        4f:db:59:03:b1:fa:02:24:ba:3a:d0:cf:d0:95:f0:87:27:de:
        36:fa:86:55:ee:a9:eb:e0:46:94:a4:40:c8:aa:94:ce:36:31:
        dd:b6:39:54:71:31:79:ff:c7:2f:93:03:ec:f0:ec:cb:2f:16:
        7c:9c:34:e4:d7:59:1e:e4:91:06:96:f1:90:19:6b:06:52:7b:
        a4:c3:39:f0:95:6e:d4:61:9d:0c:25:b1:3c:80:cf:1c:3a:21:
        77:9b:9a:7f:79:c2:64:a0:8e:9d:01:91:06:bf:54:59:92:ac:
        01:8f:67:fb:df:74:0b:fd:2f:09:6f:85:b5:6e:bd:4c:0e:1e:
        66:05:b6:a8:69:e4:41:60:6a:d4:81:b3:eb:6f:c8:8b:ad:55:
        96:a1:6f:15:41:60:c8:b2:42:a5:3e:f3:ef:db:cd:58:09:6c:
        ee:ad:fe:2c:d7:85:d0:07:70:ca:a3:aa:70:f8:c9:63:74:12:
        eb:2a:6b:ca:74:1b:c0:bc:7a:3f:60:d3:44:0b:a9:12:bd:82:
        43:81:44:6d:92:08:02:31:a7:e9:b5:de:20:46:cb:11:65:f2:
        f0:83:0e:17:00:56:53:39:07:a5:7a:a9:00:d1:22:46:aa:61:
        54:b8:14:9d:1c:63:74:08:d4:19:8a:be:65:74:08:e9:58:aa:
        8c:ff:54:a6:55:ee:15:05:c3:27:5f:b6:33:77:99:18:4e:32:
        28:77:9b:12:74:51:b8:0f:48:5e:f9:fa:e4:ab:ea:58:9a:22:
        66:4f:b6:bc:bb:d5:a8:07:a5:0d:8a:56:a6:ca:5e:13:25:1a:
        f3:c2:9a:c1:b1:f7:45:24:63:d0:10:72:3e:78:a3:1f:e9:1c:
        c5:9d:fc:85:df:ec:f1:7e:9e:2b:01:a2:c3:bf:b9:2e:96:83:
        b4:bb:17:ed:9f:64:96:e5:54:22:29:13:f7:4e:36:5f:e7:50:
        0a:5c:41:fb:e7:7b:e7:50:19:b2:a6:95:60:01:af:c9:24:b7:
        c8:b8:c5:e2:64:7f:77:a7:22:9b:8d:22:fa:6b:53:b7:09:ce:
        b7:a3:2a:a7:c6:78:bc:e9:16:c0:47:63:c0:2d:68:14:f0:6a:
        ee:78:0d:6b:2c:9c:b3:36:7d:b5:bc:a5:57:a0:3e:b6:57:ef:
        f3:e6:6b:96:ea:13:ce:da:df:8c:be:bb:80:3b:be:6e:83:e2:
        c3:5f:0e:d1:86:25:98:31
-----BEGIN CERTIFICATE-----
MIIH0jCCBbqgAwIBAgIEAV0YjTANBgkqhkiG9w0BAQsFADBpMQswCQYDVQQGEwJD
WjEXMBUGA1UEYRMOTlRSQ1otNDcxMTQ5ODMxHTAbBgNVBAoMFMSMZXNrw6EgcG/F
oXRhLCBzLnAuMSIwIAYDVQQDExlQb3N0U2lnbnVtIFF1YWxpZmllZCBDQSA0MB4X
DTIzMDMyODEyMDMyNFoXDTI0MDQxNjEyMDMyNFoweTELMAkGA1UEBhMCQ1oxFzAV
BgNVBGETDk5UUkNaLTcyMDU0NTA2MScwJQYDVQQKDB5TcHLDoXZhIHrDoWtsYWRu
w61jaCByZWdpc3Ryxa8xFjAUBgNVBAMMDUdHX0ZQU1RTX1RFU1QxEDAOBgNVBAUT
B1MyNzU3MzAwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQDB4/CorRF9
irYIIkTrOUUj4dEq1zLdjD//D7DNuxPmaRtYsdAHqdJqnsDrp9JFO9H38iR8S4cv
lMefANjcyBfDT1jNE97z1cw8RP2lJUdRykaFmXNK+xuf93fcozt0mIXbVmAf0LPt
3doJhLCc+JBwvqeEeOJgkAwzP7Qw/poOG6iD+4QMgiEnQ5q1oHnQeLbuB1U0JKoG
JRGf6kjgDWIPPE3B9it2rSuGMJ6rlS5DkqIAO/yGO5UrBOULSlYMQxwV/6KuO/aX
k+1nDIbTqtykgphbqevC/Rhft8VLuI1EvGgrbARp7Ti2NKguEP3pvCccTF8thwXi
2s06G2Dg51ghAgMBAAGjggNwMIIDbDCCASYGA1UdIASCAR0wggEZMIIBCgYJZ4EG
AQQBEoFIMIH8MIHTBggrBgEFBQcCAjCBxhqBw1RlbnRvIGt2YWxpZmlrb3Zhbnkg
Y2VydGlmaWthdCBwcm8gZWxla3Ryb25pY2tvdSBwZWNldCBieWwgdnlkYW4gdiBz
b3VsYWR1IHMgbmFyaXplbmltIEVVIGMuIDkxMC8yMDE0LlRoaXMgaXMgYSBxdWFs
aWZpZWQgY2VydGlmaWNhdGUgZm9yIGVsZWN0cm9uaWMgc2VhbCBhY2NvcmRpbmcg
dG8gUmVndWxhdGlvbiAoRVUpIE5vIDkxMC8yMDE0LjAkBggrBgEFBQcCARYYaHR0
cDovL3d3dy5wb3N0c2lnbnVtLmN6MAkGBwQAi+xAAQEwgZsGCCsGAQUFBwEDBIGO
MIGLMAgGBgQAjkYBATBqBgYEAI5GAQUwYDAuFihodHRwczovL3d3dy5wb3N0c2ln
bnVtLmN6L3Bkcy9wZHNfZW4ucGRmEwJlbjAuFihodHRwczovL3d3dy5wb3N0c2ln
bnVtLmN6L3Bkcy9wZHNfY3MucGRmEwJjczATBgYEAI5GAQYwCQYHBACORgEGAjB9
BggrBgEFBQcBAQRxMG8wOwYIKwYBBQUHMAKGL2h0dHA6Ly9jcnQucG9zdHNpZ251
bS5jei9jcnQvcHNxdWFsaWZpZWRjYTQuY3J0MDAGCCsGAQUFBzABhiRodHRwOi8v
b2NzcC5wb3N0c2lnbnVtLmN6L09DU1AvUUNBNC8wDgYDVR0PAQH/BAQDAgXgMB8G
A1UdJQQYMBYGCCsGAQUFBwMEBgorBgEEAYI3CgMMMB8GA1UdIwQYMBaAFA8ofD42
ADgQUK49uCGXi/dgXGF4MIGxBgNVHR8EgakwgaYwNaAzoDGGL2h0dHA6Ly9jcmwu
cG9zdHNpZ251bS5jei9jcmwvcHNxdWFsaWZpZWRjYTQuY3JsMDagNKAyhjBodHRw
Oi8vY3JsMi5wb3N0c2lnbnVtLmN6L2NybC9wc3F1YWxpZmllZGNhNC5jcmwwNaAz
oDGGL2h0dHA6Ly9jcmwucG9zdHNpZ251bS5ldS9jcmwvcHNxdWFsaWZpZWRjYTQu
Y3JsMB0GA1UdDgQWBBQzXA9iKKnMw1cGd+Z3fefm6sk/sDANBgkqhkiG9w0BAQsF
AAOCAgEAVSRQgSbL5NhaBxokAl/mIy2PcZFfUVOvDzBrqSZrdm+orcEJzpaGUb8E
7W8cjL0k2XcrqAGmT9tZA7H6AiS6OtDP0JXwhyfeNvqGVe6p6+BGlKRAyKqUzjYx
3bY5VHExef/HL5MD7PDsyy8WfJw05NdZHuSRBpbxkBlrBlJ7pMM58JVu1GGdDCWx
PIDPHDohd5uaf3nCZKCOnQGRBr9UWZKsAY9n+990C/0vCW+FtW69TA4eZgW2qGnk
QWBq1IGz62/Ii61VlqFvFUFgyLJCpT7z79vNWAls7q3+LNeF0AdwyqOqcPjJY3QS
6yprynQbwLx6P2DTRAupEr2CQ4FEbZIIAjGn6bXeIEbLEWXy8IMOFwBWUzkHpXqp
ANEiRqphVLgUnRxjdAjUGYq+ZXQI6ViqjP9UplXuFQXDJ1+2M3eZGE4yKHebEnRR
uA9IXvn65KvqWJoiZk+2vLvVqAelDYpWpspeEyUa88KawbH3RSRj0BByPnijH+kc
xZ38hd/s8X6eKwGiw7+5LpaDtLsX7Z9kluVUIikT9042X+dQClxB++d751AZsqaV
YAGvySS3yLjF4mR/d6cim40i+mtTtwnOt6Mqp8Z4vOkWwEdjwC1oFPBq7ngNayyc
szZ9tbylV6A+tlfv8+ZrluoTztrfjL67gDu+boPiw18O0YYlmDE=
-----END CERTIFICATE-----
</code></pre>
