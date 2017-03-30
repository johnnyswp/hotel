<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body>
   <table width="100%" border="0"  cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tbody>
      <tr>
         <td style="background: #FAF7EA; text-align: center; padding: 20px; font-size: 30px;"><b>{{$hotel_name}}</b></td>
      </tr>
     
                  <tr>
                     <td bgcolor="" style=" ">
                        <table class="table600"  border="0"  cellpadding="0" cellspacing="0"   style=" ">
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
                        <td bgcolor="#f8f8f8" style="text-align: center; ">
                           <table class="table600"  border="0"  cellpadding="0" cellspacing="0">
                              <tbody><tr>
                                 <td height="25"></td>
                              </tr>

                              <!-- title -->
                              <tr>
                                 <td height="54" align="center" style="font-family: Arial, Helvetica, sans-serif;font-size:30px; color:#6b6b6b;">
                                    <span style="color:##750E2A;">{{trans('main.dear')}} </span>
                                    {{$name}}
                                 </td>
                              </tr>
                              <!-- end title -->

                              <tr>
                                 <td height="10"></td>
                              </tr>

                              <!-- content -->
                              <tr>
                                 <td   style="font-family: Arial, Helvetica, sans-serif;font-size:14px; color:#adadad; line-height:24px;">                               
                                    {{trans('main.parte_0')}}
                                    <br />{{trans('main.parte_1')}}.
                                    <br />{{trans('main.parte_2')}}.
                                    <br /><p style="font-size:10px color: black !important; "><code style="font-size:10px color: black !important; ">{{url('/roomer/make/'.$token)}}</code></p>                              
                                    
                                    <br>
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
                                             <a style="font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#ffffff;" href="{{url('/roomer/make/'.$token)}}">
                                                <table style="border-radius:4px;background-color: rgb(11, 114, 181);padding: 3px;" bgcolor="#bad576" width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                                                   <tbody><tr>
                                                      <td height="40" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:14px; color:#ffffff;">
                                                         {{trans('main.hacer_pedido')}}
                                                      </td>
                                                   </tr>
                                                </tbody></table>
                                             </a>
                                             <!-- end button --> </td>
                                          </tr>
                                       </tbody></table>
                                    </td>
                                    <tr>
                                       <td style="font-family: Arial, Helvetica, sans-serif;font-size:14px; color:#adadad; line-height:24px;">
                                          <br />{{trans('main.parte_3')}}.                              
                                          <br />{{trans('main.parte_4')}}.
                                          <br /> {{trans('main.parte_5')}}.
                                       </td>
                                    </tr>
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
                     <table width="100%   " border="0"  cellpadding="0" cellspacing="0" style="padding: 20px; background: #E2E2E2; ">
                        <tbody> 
                        
                         
                        <tr>
                           <td  bgcolor="#e2e2e2">
                              <table class="table600"  border="0" cellspacing="0" cellpadding="0"  >
                                 <tbody>
                                  <tr>
                                     <td height="20"></td>
                                  </tr>
                                  <tr>
                                    <td  valign="top">
                                       <table class="table-inner"  border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td  style="font-family: Helvetica, Arial, sans-serif; font-size:12px ; color:#999999; padding:0px 35px; line-height:20px;">
                                                {{trans('main.escriba_a')}} {{Hotel::find(Hotel::id())->infoemail}}.
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
                        <td  bgcolor="#E2E2E2">
                           <table class="table600"  border="0"  cellpadding="0" cellspacing="0">
                              <tbody>
                              
                         </tbody></table>
                      </td>
                   </tr>
                </tbody></table>

            
             </tr>
          </tbody></table>
       </body></html>