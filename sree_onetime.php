<?php
//include 'header.php';
include 'vendor/autoload.php';

//echo "SDK_VERSION=" . Amazon\Pay\API\Client::SDK_VERSION . "\n";


$amazonpay_config = array(
    'public_key_id' => 'AHIUOFKGB5Q2SSZWRNMIT4ZO',
    'private_key'   => '-----BEGIN PRIVATE KEY-----
MIIEugIBADANBgkqhkiG9w0BAQEFAASCBKQwggSgAgEAAoIBAQDOreFDs08IiUGv
k9bLCwWoZQbc+ByQeEYU++GLr5ApjNh1tcGaS+o6bt5rFUMekv13fZnfO9zy+Anm
Ddet59cd9sXMTi9MdiwhP6qFrsTOOH6CDdTPRrOXgfVHZmtE/Ie4lVcZumxS5Yyo
vk4Ikql2LzR70b/zGLtA+ezF2rxN52cagPj8pS13UM4KQ1wg/hyCStr7pQ01Je9W
A3h4n++hk/Z0oiEgcR82NGcWBD5rxY+m5A7RPcnq96f64M7WI0E9mrpQWV3xIT1c
/p1R/EaqHBiEKIcrR5hClbvFQ3G4m7q6waNbXFVOggivuFOEvSY0s+U0ZMkIZcRV
9V8Ok99jAgMBAAECgf9Oe92zoOO9tYYpywyPDiBzUent2txrtvd4SZvcpnMqeK0o
Be+RTNUA7c/2Iy8i7RxTeroqr+xJxXlqh7KWRT0PyG8vysoGvyJwomExGYhZoqyw
2v11JnZVkl+khpt+qUJOemeGuQ1pkeZ8wBC9VT1ykXpu+En+PVO52OVHqrZE3mwU
nERjTediEU8HgGdIGYm8sakMr/x4FMbbt1fmmxLBvYdmXyyLCgoPYnmEusSX5sP4
Rai0nJ8FY8zOHzHwsBk99G4qN10rcEEEFlfzXyaEJZCINEaWaRCSX8T42XhwwEjk
17bDfJT7YezW52Uvh5HPJkWt7By/mLghRfQCKoECgYEA59Hid2ynM4bW/amCzHgi
+vLJCXwF7NA3SNR5TF1V67eW4evaotNXmfEoDYMBP3sSssTN+IAf2b55v/FErMxq
yGw9smtXil5iu7XL+1pbAXo+9Mu+gM4lwC7a/wpIfferUq0PgakS90fOcQBr4IIf
2Ad1k1Xq0lb7BOx1Y5s1iYECgYEA5Dyu5UIesHbaLcuGze0gcw9dySUr6sArgr0v
WtKhLCcL8J1a9HZLtqpx1Kga4eATikV9k9YkCZfdviSGgEydeNB4alSJ7sV8f1Pp
pRCk9DltMnxEiRNIwV0/k2DBu+C1ULlH8vTot0RNgylylEFy4DA9io+HHV4atBgS
2uuf8uMCgYAvrpQOTGL3zjxaYItu0ycexuFi+ged9hXo/QsWEfyiR1jZj1GhPCdA
msHKRa/0BrSJ4MEc4/2pI+yW9mFRyZoNL3ZhRIL1CwTz5yjVwngFjcd1QpMkm0JY
jUquOsc+YbrzfnU6DjTAeByWUafeveUe4ink7D8olIt9L8XVfw88AQKBgEHUuwGH
Y8C0V1P0K2rEJaLqYLu+y/8G9MXd+YWx0SkiDhCV4oE2ibojSXf0EOTrs9cjGgiF
MJnPwvawJFdnQdhyEPlibvJ+5dz4ACFLPrjuw29XZpE/DbIwSkEhHGArfUDOYFFU
kLcjrVPSpajbg93kLCwGIAu5c+xUMUQRyG3PAoGAehONgluappVDnimLJ6i9BKoq
1QNjH/lyHd+vj63okNkzTAHyAZ8ebQQmfaPWM52RuJ6e2p+e/pa59Ly2609OLp5P
RJ0iU0opGbRj8rQFKFqN9NH8QzqI40s/9wEIiJbOgIxs071NgsSkD0dTxv7rG5Nj
J4vHmhlRry1H3T9XUsc=
-----END PRIVATE KEY-----',
    'region'        => 'US',
    'sandbox'       => true
);
$client = new Amazon\Pay\API\Client($amazonpay_config);
$payloadrecurring = '{
    "storeId":"amzn1.application-oa2-client.a11228e4948f4cb28a59941ee5a42fee",
    "webCheckoutDetails":{
        "checkoutReviewReturnUrl":"/demo-cv2/checkout_review.php",
        "checkoutResultReturnUrl":"/demo-cv2/checkout_return.php"
    }
}';
$payloadrecurring = str_replace(array("\r", "\n"), '', $payloadrecurring);
$signaturerecurring = $client->generateButtonSignature($payloadrecurring);

$headers = array('x-amz-pay-Idempotency-Key' => uniqid());
$getbuyerid = $client->getBuyer($_GET['access_token'],$headers);

?>

<body>
<div class="my-5" id="AmazonPayButton"></div>
<script type="text/javascript" charset="utf-8">
    amazon.Pay.renderButton('#AmazonPayButton', {
        //set checkout environment
        merchantId: 'A25XNNT9UF2OF0',
        ledgerCurrency: 'USD',
        sandbox: true,
        // customize the buyer experience
        checkoutLanguage: 'en_US',
        productType: 'PayAndShip',
        placement: 'Cart',
        buttonColor: 'Gold',
        // configure Create Checkout Session request
        createCheckoutSessionConfig: {
            payloadJSON: '<?php echo $payloadrecurring; ?>', // payload generated in step 2
            signature: '<?php echo $signaturerecurring; ?>', // signature generatd in step 3
            publicKeyId: 'AHIUOFKGB5Q2SSZWRNMIT4ZO',
            algorithm: 'AMZN-PAY-RSASSA-PSS' // optional
        }
    });
</script>

<script>

        $.get("https://pay-api.amazon.com/sandbox/v2/buyers", {
            buyerToken: '<?php echo $_GET['buyerToken']; ?>',
        }).done(function (data) {
            try {
                JSON.parse(data);

            } catch (err) {
            }
            $("#get_capture_response").html(data);
        });

</script>
<?php
//Define a large json data
$payload = $payloadrecurring;
//call custom function for formatting json data
echo pretty_print($payload,"\n");

//Declare the custom function for formatting
function pretty_print($json_data)
{

//Initialize variable for adding space
$space = 0;
$flag = false;

//Using <pre> tag to format alignment and font
echo "<pre>";

//loop for iterating the full json data
for($counter=0; $counter<strlen($json_data); $counter++)
{

//Checking ending second and third brackets
if ( $json_data[$counter] == '}' || $json_data[$counter] == ']' )
{
$space--;
echo "\n";
echo str_repeat(' ', ($space*2));
}
 

//Checking for double quote(“) and comma (,)
if ( $json_data[$counter] == '"' && ($json_data[$counter-1] == ',' ||
 $json_data[$counter-2] == ',') )
{
echo "\n";
echo str_repeat(' ', ($space*2));
}
if ( $json_data[$counter] == '"' && !$flag )
{
if ( $json_data[$counter-1] == ':' || $json_data[$counter-2] == ':' )

//Add formatting for question and answer
echo '<span style="color:blue;font-weight:bold">';
else

//Add formatting for answer options
echo '<span style="color:red;">';
}
echo $json_data[$counter];
//Checking conditions for adding closing span tag
if ( $json_data[$counter] == '"' && $flag )
echo '</span>';
if ( $json_data[$counter] == '"' )
$flag = !$flag;

//Checking starting second and third brackets
if ( $json_data[$counter] == '{' || $json_data[$counter] == '[' )
{
$space++;
echo "\n";
echo str_repeat(' ', ($space*2));
}
}
echo "</pre>";
}
?>

</body>