<div style="padding: 15px 20px 30px;">
    <div style="color:#333; margin-bottom: 10px;">Welcome {{ $data['full_name'] }}</div>
    <br/>
    <div style="color:#333; margin-bottom: 10px;">Please, click on link as below to active your account.</div>

    <div style="color:#333; margin-bottom: 10px;"><a href="{{ $verify_url }}">Click link to confirm!</a></div>
    <div style="color:#333; margin-bottom: 10px;">This link will be expired in 02 days. Let verify as soon as possible.</div>

    <div style="height: 3px; background: #dcbd89; margin: 30px 0;"></div>

    <div>
        <br/>
        <div>
            <i style="color:#000; line-height:22px;">Thank you very much!</i>
            <i style="color:#000; line-height:22px;">Nice meal team.</i>
        </div>
    </div>

    <div style="background:#ececec; padding: 20px;">
        <table>
            <tr>
                <td style="font-size: 25px;">
                    <img src="/b2c-assets/img/logo.png" title="Nice Meal"/>
                </td>
                <td style="padding-left: 20px; color:#333;">
                    <div style="margin-bottom:5px;">55-57 Bau Cat 4</div>
                    <div style="margin-bottom:5px;"></div>
                    <div>{{ env('APP_URL') }}</div>
                </td>
            </tr>
        </table>
    </div>
</div>