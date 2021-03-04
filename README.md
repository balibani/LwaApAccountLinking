# LwaApAccountLinking

We have broken down the experiment into Two Parts :


1. LWA Team Linking an existing Amazon Pay ClientID to LWA
2. Testing against combination of LWA / CV2 Sign-in  + CV1 / CV2 

Sample Code for the Experiment

Sample Code for the experiment is hosted on github . This code will allow the tester to use two different clientIDs ( LWA and Amazon Pay ).  During the course of test the tester will have to go through the sequence on DeveloperID changes as shown in the Account Linking Section and check the BuyerID in the confirmation page. The JSON data is printed for validation.


https://github.com/balibani/LwaApAccountLinking

*Experiment Demo Site*:  https://ec2-34-209-34-177.us-west-2.compute.amazonaws.com/lwaExperiment/lwatest.php

************************ BEGIN LWA EXPERIMENT *******************************


*Account Linking* : 

As part of the account linking process , we have created an Amazon Pay Seller Account and LWA Developer Account as shown in the table below :



*LWA* :  Balibani+test@amazon.com	
*Client ID:*amzn1.application-oa2-client.a11228e4948f4cb28a59941ee5a42fee

*PWA*: Balibani+ap@amazon.com
Applciation Name : "Sandbox  Test App" 
	
*Client ID: *
 amzn1.application-oa2-client.6feb179b004c4f3da2b5e21736b00b7f
 
*Seller ID* : 
A25XNNT9UF2OF0
 
*Public Key* :  AHIUOFKGB5Q2SSZWRNMIT4ZO
 
 

Linked Client ID	
amzn1.application-oa2-client.a11228e4948f4cb28a59941ee5a42fee

The PWA ClientID has been replaced with LWA ClientID . And this change immediately reflected in the AP Seller Central . 


*SOP for merging two LWA accounts  *

*_Context _*

In the experiment we did, we took the following developer accounts: 

    * Developer Account for Amazon Pay - on SellerCentral
    * Developer Account for LWA - on DeveloperPortal

Both these developer accounts could have multiple applications. And these developer accounts would get a different directed id for the same customer, just because they are two different developer accounts. 
To merge the two accounts we can link them together such that they share the same developer id, yet different linkages, to have all the applications visible from either portal (SellerCentral / DeveloperPortal). Check the example below 

*_State before merging_*

Current State of LWA and Amazon Pay Accounts as represented by Anurag Sharma
[Image: image.png]

*_Merging process_*

* Identify the developer id for each type of linkage
* Identify the number of applications for each developer id
* Check the traffic for each of the applications and identify the  developer which has no production traffic for any of its applications  (this may not always be possible, in which case we will should work with  the developer to identify which directed ids they are okay with flipping)
* Transfer all the applications from the developer id with no traffic,  to the other developer id, using StegoService.CfApplicationTransfer API. (Refer to this wiki (https://w.amazon.com/index.php/IdentityServices/Stego_Service/User_Guide/API_Workflow_Examples#Searching_for_an_existing_linkage))
* Modify the linkage of the developer id with no traffic, to point to  the other developer id, using StegoService.CfLinkageUpdate API. (Refer to this wiki (https://w.amazon.com/index.php/IdentityServices/Stego_Service/User_Guide/API_Workflow_Examples#Searching_for_an_existing_linkage))

*_State after merging_*

Lets assume Pay applications had no production traffic. We will converge on the LWA applications in that case. 
Intermediate state after transferring of all Pay apps to LWA developer account

Anurag has listed the below two steps to unlink and link Amazon Pay ClientIDs .
[Image: image.png]

Final state after updating the SellerCentral linkage to point to LWA developer instead
[Image: image.png]Note that 'Developer ID 1' is now a dangling id with no linkage pointed to it. It can optionally be deleted from StegoService if needed. 
After this modification, 

* 3P can view all the LWA + Pay apps from both Seller Central and  Developer Portal.
* Directed Ids issued for Pay Apps will now switch to be the ones same  as ids issued for LWA apps.

************************ CONCLUDES LWA EXPERIMENT *******************************


************************ BEGIN Amazon Pay EXPERIMENT *******************************


*AP Experiments* : 

After the ClientIDs were linked between LWA and AP , we have run the clientIDs against the following combinations :



Scenario	LWA	CV1	CV2 Sign-In	CV2	Double Login Required ?	Legacy LWA BuyerID Matched Amazon Pay Buyer ID?	Prime Signal Available?
Woot's Expected Outcome -->		NO	YES	YES
Current Woot 	1	1			NO (appears to be fixed as of 7/15)	NO	YES
1	1	1	0	0	NO	YES	YES
2 ( Current Pitch to Woot for Q3 2020 )	1	0	0	1	NO*	YES*	YES*
3 ( Once H6 is available we expect to pitch this scenario )	0	0	1	1	NO	YES	NOt YET ( But will be available soon )


After Linking ClientIDs , we have used the LWA ClientID for both Login and Checkout Flows.

We did an experiment to check if an LWA ClientID could be used to render the amazon pay button.

_Result_:

1. Amazon Pay button rendered without any issues 
2. After logging in, the widgets rendered without asking for authentication

_Concern_ :

Is it possible to use “ANY” LWA ClientID to render the amazon pay button? 

_Expectation_:

The LWA ClientID should only work if the merchant has registered with the same email address on both seller central and developer.amazon.com (http://developer.amazon.com/)


*LWA client ID* : ClientID retrieved from developer.amazon.com (http://developer.amazon.com/) ( Login with Amazon credentials )
*Pay Client ID* : ClientID retrieved from seller central ( Integration Central )
*Pay Merchant ID* : Merchant retrieved from seller central ( Integration Central )

Code for rendering button

<script type='text/javascript'>
        window.onAmazonLoginReady = function() {
            amazon.Login.setClientId('amzn1.application-oa2-client.33d1c7b442234f898a80c48031c66ce6');
        };
        window.onAmazonPaymentsReady = function() {
            showButton();
        };
    </script>
    <script async='async' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>

<script type="text/javascript">
    function showButton() {
        var authRequest;
        OffAmazonPayments.Button("AmazonPayButton", "A60CEZTMKRA2U", {
            type: "PwA",
            color: "Gold",
            size: "large",
            authorization: function () {
                loginOptions = { scope: "profile payments:widget", popup: true };
                authRequest = amazon.Login.authorize(loginOptions, "set_recurring.php");
            },
            onError: function(error) {

                alert("The following error occurred: "
                       + error.getErrorCode()
                       + ' - ' + error.getErrorMessage());
            }
        });
    };
</script>

<script type="text/javascript">
   document.getElementById('Logout').onclick = function() {
        amazon.Login.logout();
    };
</script>

Code to render widgets

The Client ID and merchant ID used to render the widgets are from the same merchant account in seller central


<script type='text/javascript'>
    function getURLParameter(name, source) {
        return decodeURIComponent((new RegExp('[?|&|#]' + name + '=' +
            '([^&]+?)(&|#|;|$)').exec(source) || [,""])[1].replace(/\+/g,
            ' ')) || null;
    }

    var accessToken = getURLParameter("access_token", location.hash);
alert(accessToken);
    if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
        document.cookie = "amazon_Login_accessToken=" + accessToken +
            ";secure";
    }

    window.onAmazonLoginReady = function () {
        amazon.Login.setClientId('amzn1.application-oa2-client.a64c1e339d754ca5ac26012b177d5d4b');

        amazon.Login.setUseCookie(true);
    };

</script>

<script type="text/javascript">
    var billingAgreementId;

    new OffAmazonPayments.Widgets.Wallet({
        sellerId: 'A60CEZTMKRA2U',
        onReady: function(billingAgreement) {
            var billingAgreementId = billingAgreement.getAmazonBillingAgreementId();
            console.log(billingAgreementId);
        },
        agreementType: 'BillingAgreement',
        design: {
            designMode: 'responsive'
        },
        onPaymentSelect: function(billingAgreement) {
            // Replace this code with the action that you want to perform
            // after the payment method is selected.
        },
        onError: function(error) {
            // your error handling code
        }
    }).bind("walletWidgetDiv");
    new OffAmazonPayments.Widgets.Consent({
        sellerId: 'A60CEZTMKRA2U',
        // amazonBillingAgreementId obtained from the Amazon Address Book widget.
        amazonBillingAgreementId: billingAgreementId,
        design: {
            designMode: 'responsive'
        },
        onReady: function(billingAgreementConsentStatus){
            // Called after widget renders
            buyerBillingAgreementConsentStatus =
                billingAgreementConsentStatus.getConsentStatus();
            // getConsentStatus returns true or false
            // true - checkbox is selected
            // false - checkbox is unselected - default
        },
        onConsent: function(billingAgreementConsentStatus) {
            buyerBillingAgreementConsentStatus =
                billingAgreementConsentStatus.getConsentStatus();
            // getConsentStatus returns true or false
            // true - checkbox is selected - buyer has consented
            // false - checkbox is unselected - buyer has not consented

            // Replace this code with the action that you want to perform
            // after the consent checkbox is selected/unselected.
        },
        onError: function(error) {
            // your error handling code
        }
    }).bind("consentWidgetDiv");

   // }).bind("addressBookWidgetDiv");
</script>

************************ CONCLUDES Amazon Pay  EXPERIMENT *******************************


Appendix :

*LWA Contributors* : Anurag Sharama , David Li

Woot ! Impact Analysis 

**SUBJECT**:* ** WOOT LWA BUG IMPACT ANALYSIS* 

**DATE: ** JULY 2020**
**PREPARED BY: ** ADIAN KUMMET**
* ** *


*_*Overview*_*
Woot customers who sign in via "Login With Amazon" (LWA) are experiencing issues when presented with the option to sign in to their Amazon account on the checkout page (the “WantOne” page) resulting in increased customer exits and prevents customer checkout conversions (the “LWA Bug”) which have quantitative (i.e. lost OPS ($)) and qualitative (i.e. negative customer experience), with the quantitative impact within the scope of our analysis below. 
The LWA Bug originated in January 2020 and was tracked and analyzed by Woot during the period from Apr 22 – May 6 2020 (the “LWA Bug Period”). During the LWA Bug Period, an event was logged into Google Analytics (GA) with each instance being measured upon the customer experiencing the LWA Bug and exiting from the WantOne page (i.e. exit at cart checkout with no checkout conversion). The observed increase in exits of customers experiencing the LWA Bug as compared to those not experiencing the LWA Bug represents the incremental rate of exit attributable to the LWA Bug. GA defines a customer 'exit' as the number of times a customer leaves or otherwise is redirected from a specified page (i.e. the WantOne page). 
In order to quantify the LWA Bug impact we estimated the potential lost OPS ($) specifically attributable to the LWA Bug by calculating the product of the i) incremental customer exit rate on the WantOne page for customers who experience the LWA Bug and ii) the LWA Bug Period OPS ($).
 
*_*Impact Analysis*_*
During the LWA Bug Period, we found that customers who experience the LWA Bug on the WantOne page, exited the page at a higher rate (+319bps) than customers that do not experience the LWA Bug on the WantOne page.
During the LWA Bug Period, OPS ($) totaling approximately $7.9M was recorded. When adjusted by the increased exit rate attributable to the LWA Bug the estimated lost OPS ($) to approximate $252K. 
Considering the potential impact of the LWA Bug on YTD basis through Q2, total OPS ($) of approximately $88M was recorded, when adjusted for the impact of LWA Bug the estimated lost OPS ($) approximates $2.8M.

