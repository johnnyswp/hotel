<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
   <meta name="format-detection" content="telephone=yes">
   <title>Easy Room Services</title>
   <style type="text/css">
.ReadMsgBody { width: 100%; background-color: #ffffff; }
.ExternalClass { width: 100%; background-color: #ffffff; }
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }
html { width: 100%; }
body { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
body { margin: 0; padding: 0; }
table { border-spacing: 0; }
img { display: block !important; }
table td { border-collapse: collapse; }
.yshortcuts a { border-bottom: none !important; }
a { color: #FAF7EA; text-decoration: none; }
 @media only screen and (max-width: 640px) {
body { width: auto !important; }
table[class="table600"] { width: 450px !important; text-align: center !important; }
table[class="table-inner"] { width: 86% !important; }
table[class="table2-2"] { width: 47% !important; }
table[class="table3-3"] { width: 100% !important; text-align: center !important; }
table[class="table1-3"] { width: 29.9% !important; }
table[class="table3-1"] { width: 64% !important; text-align: center !important; }
/* Image */
img[class="img1"] { width: 100% !important; height: auto !important; }
}
 @media only screen and (max-width: 479px) {
body { width: auto !important; }
table[class="table600"] { width: 290px !important; }
table[class="table-inner"] { width: 80% !important; }
table[class="table2-2"] { width: 100% !important; }
table[class="table3-3"] { width: 100% !important; text-align: center !important; }
table[class="table1-3"] { width: 100% !important; }
table[class="table3-1"] { width: 100% !important; text-align: center !important; }
table[class="middle-line"] { display: none !important; }
/* image */
img[class="img1"] { width: 100% !important; }
}
</style>
</head>

<body>
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tbody><tr>
         <td>
            <!--Header-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FAF7EA">

               <!-- webversion -->
               <tbody><tr>
                  <td bgcolor="#2dabe0" height="25" align="center" valign="middle" style="color:#c1e4fa; font-family:Helvetica, Arial, sans-serif; font-size:11px;background-color: #4E1525;">
                     {{trans('main.Si no puede leer este mensaje, visualizarla en línea')}}
                     <a href="#" style="color:#ffffff; text-decoration:none;">{{trans('main.click aqui')}}</a>
                  </td>
               </tr>
               <!-- end webversion -->
               <tr>
                  <td align="center" style="background-color: #f8f8f8; ">
                     <table class="table600" height="175" bgcolor="#f8f8f8" width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #f8f8f8; ">

                        <!-- logo -->
                        <tbody><tr style="">
                              <img src="http://easyroomservice.com/templates/at_health/images/presets/preset1/logo.png" alt="logo">
                           </td>
                        <!-- end logo --> </tbody></table>
                  </td>
               </tr>
               <tr>
                  <td bgcolor="" style="background-color: rgb(78, 21, 37) ">
                     <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#c7e7fb" style="background-color: rgb(78, 21, 37) ">
                        <tbody><tr>
                           <td height="20"></td>
                        </tr>
                     </tbody></table>
                  </td>
               </tr>
            </tbody></table>

            <!--End Header--> </td>
      </tr>

      <!-- content with 2 buttons -->
      <tr>
         <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tbody><tr>
                  <td bgcolor="#f8f8f8">
                     <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                           <td height="25"></td>
                        </tr>

                        <!-- title -->
                        <tr>
                           <td height="54" align="center" style="font-family: Arial, Helvetica, sans-serif;font-size:30px; color:#6b6b6b;">
                              <span style="color:##750E2A;">{{trans('main.dear')}}, </span>
                               {{$name}}
                           </td>
                        </tr>
                        <!-- end title -->

                        <tr>
                           <td height="10"></td>
                        </tr>

                        <!-- content -->
                         <tr>
                           <td align="center" style="font-family: Arial, Helvetica, sans-serif;font-size:14px; color:#adadad; line-height:24px;">                               
                              {{trans('main.thanks for signing in')}} easyroomservices.com. 
                              <br />{{trans('main.to complete your registration you need to check your')}}
                              <br /> {{trans('main.email by clicking on the button Activate Account')}}. 
                              <br />{{trans('main.If you can not click on the button, copy the following link into your browser')}}.
                              <br /><p style="font-size:10px color: black !important;"><code style="font-size:10px color: black !important;">{{url('activate/'.$id.'/'.$code)}}</code></p>
                              <br />{{trans('main.Thank you for choosing us. If you have any questions or need any help, please feel free to contact us at ayuda@easyroomservice.com')}}
                              <br /> {{trans('main.el equipo record de Easy Room Services')}}.
                           </td>
                        </tr>
                        <!-- end content -->

                        <tr>
                           <td height="15"></td>
                        </tr>
                        <tr>
                           <td>
                              <table width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                                 <tbody><tr>
                                    <td>
                                       <!-- button -->
                                       <a style="font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#ffffff;" href="{{url('activate/'.$id.'/'.$code)}}">
                                          <table style="border-radius:4px;background-color: rgb(11, 114, 181);padding: 3px;" bgcolor="#bad576" width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                                             <tbody><tr>
                                                <td height="40" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#ffffff;">
                                                {{trans('main.Activate')}}
                                                </td>
                                             </tr>
                                          </tbody></table>
                                       </a>
                                       <!-- end button --> </td>
                                 </tr>
                              </tbody></table>
                           </td>
                        </tr>
                        <tr>
                           <td height="25"></td>
                        </tr>
                     </tbody></table>
                  </td>
               </tr>
                
            </tbody></table>
         </td>
      </tr>
      <!-- end content with 2 buttons -->
      <!--footer info-->
      <tr>
         <td>
            <table width="100%   " border="0" align="center" cellpadding="0" cellspacing="0">
               <tbody><tr>
                  <td height="30"></td>
               </tr>
               <tr>
                  <td height="30" align="center">
                     <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="table600">
                        <tbody><tr>
                           <td>
                              <table class="table-inner" width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                                 <tbody><tr>
                                    <td width="78" valign="middle" style="border-collapse: collapse;">
                                       <table width="100%" height="1" border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                          <tbody><tr>
                                             <td height="1" width="100%" bgcolor="#eae9e9" style="border-collapse: collapse;"></td>
                                          </tr>
                                       </tbody></table>
                                    </td>
                                    <td width="65" height="8" align="center" bgcolor="#FAF7EA" style="max-width:65px;"></td>
                                    <td width="78" valign="middle" style="border-collapse: collapse;">
                                       <table border="0" cellpadding="0" cellspacing="0" width="100%" height="1" style="border-collapse: collapse;">
                                          <tbody><tr>
                                             <td height="1" width="100%" bgcolor="#eae9e9" style="border-collapse: collapse;"></td>
                                          </tr>
                                       </tbody></table>
                                    </td>
                                 </tr>
                              </tbody></table>
                           </td>
                        </tr>
                     </tbody></table>
                  </td>
               </tr>
               <tr>
                  <td height="15"></td>
               </tr>
               <tr>
                  <td align="center" bgcolor="#e2e2e2">
                     <table class="table600" width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#e8e8e8">
                        <tbody>
                          <tr>
                             <td height="20"></td>
                        </tr>
                        <tr>
                           <td align="center" valign="top">
                              <table class="table-inner" width="600" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td align="center" style="font-family: Helvetica, Arial, sans-serif; font-size:12px ; color:#999999; padding:0px 35px; line-height:20px;">
                                       {{trans('main.Usted está recibiendo este mensaje porque usted comenzó en la parte alta de su cuenta y acepta los términos y condiciones. Si usted no inició este proceso, por favor escriba a')}}
                                       <a href="#" style="color:#009ce7; text-decoration:none">info@easyroomservice.com</a>
                                    </td>
                                 </tr>
                                 <!-- end notification -->
                                 <tr>
                                    <td height="20"></td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                     </table>
                     <br>
                  </td>
               </tr>
               <tr>
                  <td align="center" bgcolor="#d9d9d9">
                     <table class="table600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                           <td height="30" align="center" bgcolor="#e1e1e1" style="font-family: Helvetica, Arial, sans-serif; font-size:11px; color:#6b6b6b;">
                              <a href="http://www.easyroomservice.com/" style="color:#009ce7; text-decoration:none;">easyroomservice, Madrid, España </a> 
                           </td>
                        </tr>
                        <tr>
                           <td height="30" align="center" bgcolor="#e1e1e1" style="font-family: Helvetica, Arial, sans-serif; font-size:11px; color:#6b6b6b;">
                             Copyright © 2015
                              <a href="www.easycloudsolutions.com" style="color:#009ce7; text-decoration:none;"> www.easycloudsolutions.com</a>
                              , All rights reserved
                           </td>
                        </tr>
                     </tbody></table>
                  </td>
               </tr>
            </tbody></table>

            <!--End footer info--> </td>
      </tr>
   </tbody></table>
 </body></html>