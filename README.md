# LwaApAccountLinking

Sample Code for the experiment is hosted on github . This code will allow the tester to use two different clientIDs ( LWA and Amazon Pay ).  During the course of test the tester will have to go through the sequence on DeveloperID changes as shown in the Account Linking Section and check the BuyerID in the confirmation page. The JSON data is printed for validation.




Experiment Demo Site
=============
https://ec2-34-209-34-177.us-west-2.compute.amazonaws.com/lwaExperiment/lwatest.php


After Linking ClientIDs , we have used the LWA ClientID for both Login and Checkout Flows.

We did an experiment to check if an LWA ClientID could be used to render the amazon pay button.

 Result
=============

1. Amazon Pay button rendered without any issues 
2. After logging in, the widgets rendered without asking for authentication

 Concern
=============

Is it possible to use “ANY” LWA ClientID to render the amazon pay button? 

 Expected Result
=============

The LWA ClientID should only work if the merchant has registered with the same email address on both seller central and developer.amazon.com (http://developer.amazon.com/)


