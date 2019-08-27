<div style="border: 3px dashed #ed792c; padding: 0 15px 0 15px;color: black;font-size: 18px">
    <div style="margin-top: -15px">
        <h1 style="color: red;border-bottom: 1px solid #7c9bd6">NiceMeal.com</h1>
    </div>
    <div style=" font-size: 16px;margin-top: 15px;">
        <p>Dear Sir/Madam</p>
        <p>We are from NiceMeal team</p>
        <p>This email to confirm your order, NM-{{ $otp }} is your OTP number</p>
        <p>Please confirm with us as soon as possible</p>
        <p>Many thanks</p>

        <div style="height: 3px; background: #dcbd89; margin: 30px 0;"></div>

        <div>
            <br/>
            <div>
                <i style="color:#000; line-height:22px;">Thank you very much!</i>
                <i style="color:#000; line-height:22px;">Nice meal team.</i>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <h1 style="border-bottom: 1px solid #7c9bd6;border-top: 1px solid #7c9bd6;">Support Contact:</h1>
        </div>
        <p><span style="color:red;font-weight: bold">Email: </span>{{ $restaurant->email }}</p>
        <p><span style="color:red;font-weight: bold">Phone number: </span>{{ $restaurant->phone }}</p>
    </div>
</div>

<p style="text-align: center; font-size:16px">&copy; 2019 NiceMeal.com</p>
